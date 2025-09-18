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
    abstract public function handleWebhook(array $payload): void;

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
    protected function cancelUserSubscription(
        int $userId,
        int $planId,
    ): ?UserSubscription
    {
        $subscription = UserSubscription::where('user_id', $userId)
            ->where('access_plan_id', $planId)
            ->first();

        $subscription?->update([
            'ends_at' => Carbon::now(),
            'status' => 'cancelled',
            'is_renewing' => false
        ]);

        return $subscription;
    }
}
