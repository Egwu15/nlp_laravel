<?php

namespace App\Services\Payments;

use App\Models\UserSubscription;
use Carbon\Carbon;

class PaystackService extends BasePaymentService
{
    public function handleWebhook(array $payload): void
    {
        $event = $payload['event'] ?? '';
        $data = $payload['data'];

        $subscriptionCode = $data['subscription_code'] ?? null;
        $userSubscription = UserSubscription::where('subscription_code', $subscriptionCode)->first();

        if (!$userSubscription && $event !== 'charge.success') {
            return;
        }

        switch ($event) {
            case 'charge.success':
                $userId = $data['metadata']['user_id'] ?? $userSubscription->user_id ?? null;
                $planId = $data['plan']['plan_code'] ?? $userSubscription->access_plan_id ?? null;
                $subscriptionCode = $data['subscription_code'] ?? null;

                if (!$userId || !$planId || !$subscriptionCode) {
                    return; // Ignore if critical data is missing
                }

                // If it's a new subscription, link the subscription code
                $userSubscription = $this->createOrUpdateUserSubscription(
                    $userId,
                    $planId,
                    Carbon::now(),
                    Carbon::now()->addMonth(), // Use dynamic date based on plan
                    true
                );

                // Save the subscription code for future lookups
                $userSubscription->update(['subscription_code' => $subscriptionCode]);

                break;

            case 'subscription.not_renewing':
                $userSubscription?->update(['is_renewing' => false]);
                break;

            case 'subscription.disable':
            case 'subscription.cancel':
                if ($userSubscription) {
                    $this->cancelUserSubscription($userSubscription->user_id, $userSubscription->access_plan_id);
                }
                break;

            default:
                break;
        }
    }
}
