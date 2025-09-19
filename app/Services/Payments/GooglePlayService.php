<?php
// app/Services/Payments/GooglePlayService.php
namespace App\Services\Payments;

use App\Enums\GooglePlayNotificationType;
use App\Models\GooglePlayNotification;
use App\Models\UserSubscription;
use Google\Client;
use Google\Exception;
use Google\Service\AndroidPublisher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class GooglePlayService extends BasePaymentService
{
    protected AndroidPublisher $service;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path(config('googlePlay.credentials_path')));
        $client->addScope(AndroidPublisher::ANDROIDPUBLISHER);

        $this->service = new AndroidPublisher($client);
    }

    /**
     * @throws \Google\Service\Exception
     */
    public function verifySubscription(string $packageName, string $productId, string $purchaseToken): AndroidPublisher\SubscriptionPurchase
    {
        return $this->service
            ->purchases_subscriptions
            ->get($packageName, $productId, $purchaseToken);
    }

    /**
     * @throws \Google\Service\Exception
     */
//    public function handleWebhook(array $payload): void
//    {
//
//        $messageData = json_decode(base64_decode($payload['message']['data']), true);
//        Log::log('info', json_encode($messageData));
//        $notification = $messageData['subscriptionNotification'];
//
//        $purchaseToken = $notification['purchaseToken'];
//        $notificationType = $notification['notificationType'];
//
//
//        GooglePlayNotification::updateOrCreate(
//            ['purchase_token' => $purchaseToken],
//            [
//                'product_id' => $notification['subscriptionId'],
//                'notification_type' => $notificationType,
//                'payload' => $messageData,
//            ]
//        );
//
//        $userSubscription = UserSubscription::where('token', $purchaseToken)->first();
//        // 3. Handle the notification as a state change.
//
//        if (!$userSubscription) {
//            return;
//        }
//        switch ($notificationType) {
//            case GooglePlayNotificationType::SUBSCRIPTION_CANCELED:
//            case GooglePlayNotificationType::SUBSCRIPTION_EXPIRED:
//            case GooglePlayNotificationType::SUBSCRIPTION_REVOKED:
//                $this->cancelUserSubscription($purchaseToken);
//                return;
//
//            case GooglePlayNotificationType::SUBSCRIPTION_RENEWED:
//            case GooglePlayNotificationType::SUBSCRIPTION_RECOVERED:
//                $subscriptionDetails = $this->verifySubscription(
//                    $messageData['packageName'],
//                    $notification['subscriptionId'],
//                    $purchaseToken
//                );
//
//                $this->createOrUpdateUserSubscription(
//                    $userSubscription->user_id,
//                    $userSubscription->access_plan_id,
//                    Carbon::createFromTimestampMs($subscriptionDetails->startTimeMillis),
//                    Carbon::createFromTimestampMs($subscriptionDetails->expiryTimeMillis),
//                    !$subscriptionDetails->cancelReason && $subscriptionDetails->autoRenewing
//                );
//                return;
//
//            default:
//
//                // Log or handle other events
//        }
//    }

    public function handleSubscriptionNotification(array $notification): void
    {
        $purchaseToken = $notification['purchaseToken'];
        $notificationType = $notification['notificationType'];

        $userSubscription = UserSubscription::where('token', $purchaseToken)->first();

        if (!$userSubscription) {
            return;
        }

        switch ($notificationType) {
            case GooglePlayNotificationType::SUBSCRIPTION_CANCELED:
            case GooglePlayNotificationType::SUBSCRIPTION_EXPIRED:
            case GooglePlayNotificationType::SUBSCRIPTION_REVOKED:
                $this->cancelUserSubscription($purchaseToken);
                break;

            case GooglePlayNotificationType::SUBSCRIPTION_RENEWED:
            case GooglePlayNotificationType::SUBSCRIPTION_RECOVERED:
                $subscriptionDetails = $this->verifySubscription(
                    $notification['packageName'],
                    $notification['subscriptionId'],
                    $purchaseToken
                );

                $this->createOrUpdateUserSubscription(
                    $userSubscription->user_id,
                    $userSubscription->access_plan_id,
                    Carbon::createFromTimestampMs($subscriptionDetails->startTimeMillis),
                    Carbon::createFromTimestampMs($subscriptionDetails->expiryTimeMillis),
                    !$subscriptionDetails->cancelReason && $subscriptionDetails->autoRenewing
                );
                break;

            default:
                // Log or handle other events
                break;
        }
    }


    /**
     * @throws \Google\Service\Exception
     */
    public function verifyWithServer(string $packageName, string $productId, string $purchaseToken, int $userId): UserSubscription
    {
        // 1. Verify the purchase with Google's API.
        $subscriptionDetails = $this->verifySubscription($packageName, $productId, $purchaseToken);

        // 2. Create or update the user's subscription record.
        $userSubscription = $this->createOrUpdateUserSubscription(
            $userId,
            $productId,
            Carbon::createFromTimestampMs($subscriptionDetails->startTimeMillis),
            Carbon::createFromTimestampMs($subscriptionDetails->expiryTimeMillis),
            !$subscriptionDetails->cancelReason && $subscriptionDetails->autoRenewing
        );

        // 3. Store the purchase token for future webhook lookups.
        $userSubscription->update(['purchase_token' => $purchaseToken]);

        // 4. Clean up any pending Pub/Sub notifications that we just linked.
        GooglePlayNotification::where('purchase_token', $purchaseToken)->delete();

        return $userSubscription;
    }

    /**
     * @throws \Google\Service\Exception
     */
    public function listVoidedPurchases(): array
    {
        $startTime = now()->subHours(48)->getTimestampMs();
        $endTime = now()->getTimestampMs();
        $packageName = config('googlePlay.package_name');
        $result = $this->service->purchases_voidedpurchases->listPurchasesVoidedpurchases($packageName, [
            'startTime' => $startTime,
            'endTime' => $endTime,
        ]);
        return $result->getVoidedPurchases() ?? [];
    }

}
