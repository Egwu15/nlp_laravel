<?php

// app/Services/Payments/BasePaymentService.php
namespace App\Services\Payments;

use App\Models\UserSubscription;
use Carbon\Carbon;

abstract class BasePaymentService
{
    /**
     * Handle the webhook payload from the provider
     */

    /**
     * Save subscription data after successful verification
     */
    protected function createOrUpdateUserSubscription(
        int    $userId,
        int    $planId,
        Carbon $startsAt,
        Carbon $endsAt,
        bool   $isRenewing = true
    ): UserSubscription
    {
        return UserSubscription::updateOrCreate(
            [
                'user_id' => $userId,
                'access_plan_id' => $planId,
            ],
            [
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'is_renewing' => $isRenewing,
            ]
        );
    }

    /**
     * Immediately cancel a user's subscription.
     */
    public function cancelUserSubscription(
        string $token,
    ): ?UserSubscription
    {
        $subscription = UserSubscription::where('token', $token)->first();

        $subscription?->update([
            'ends_at' => Carbon::now(),
            'status' => 'cancelled',
            'is_renewing' => false
        ]);

        return $subscription;
    }

}
