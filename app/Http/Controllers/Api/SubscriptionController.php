<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccessPlanResource;
use App\Models\AccessPlan;
use App\Models\UserSubscription;
use App\Services\SubscriptionService;
use Carbon\Carbon;
use Google\Service\AndroidPublisher;
use Google_Client;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    public function plans()
    {
        $plans = $this->subscriptionService::allPlans();
        return response()->json(AccessPlanResource::collection($plans));
    }

    public function verifyGooglePurchase(Request $request)
    {
        $request->validate([
            'product_id' => 'required|string',
            'purchase_token' => 'required|string',
            'platform' => 'required|string',
        ]);

        $productId = $request->product_id;
        $purchaseToken = $request->purchase_token;
        $userId = auth()->user()->id;

        try {
            // Google Play API client
            $client = new Google_Client();
            $client->setAuthConfig(storage_path('app/private/nigerian-law-app-b00db00422ed.json'));
            $client->addScope(AndroidPublisher::ANDROIDPUBLISHER);

            $service = new AndroidPublisher($client);
            $packageName = "com.tedif.NigerianLawApp";

            $result = $service->purchases_subscriptions->get(
                $packageName,
                $productId,
                $purchaseToken
            );

            $expiry = $result->getExpiryTimeMillis() / 1000; // seconds
            $expiryDate = date('Y-m-d H:i:s', $expiry);

            // Status mapping
            $status = 'pending';
            if ($result->getCancelReason()) {
                $status = 'canceled';
            } elseif ($expiry < time()) {
                $status = 'expired';
            } else {
                $status = 'active';
            }

            $assess_plan = AccessPlan::select('id')->where('google_product_id', $productId)->first();


            // Store subscription
            UserSubscription::updateOrCreate(
                ['token' => $purchaseToken],
                [
                    'user_id' => $userId,
                    'access_plan_id' => $assess_plan->id,
                    'starts_at' => Carbon::now(),
                    'ends_at' => $expiryDate,
                    'is_renewing' => true,
                    'status' => $status,
                    'provider' => 'GooglePay'
                ]
            );

            return response()->json(['valid' => $status === 'active']);
        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
