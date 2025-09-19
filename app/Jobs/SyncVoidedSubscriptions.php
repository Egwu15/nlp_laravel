<?php

namespace App\Jobs;

use App\Models\UserSubscription;
use App\Services\Payments\GooglePlayService;
use Google\Service\Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncVoidedSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public array $backoff = [60, 300, 900, 3600];


    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(GooglePlayService $googlePlayService): void
    {
        Log::info('Running job SyncVoidedSubscriptions');

        try {
            Log::info('Fetching voided purchases...');
            $voidedPurchases = $googlePlayService->listVoidedPurchases();
            Log::info('Successfully fetched voided purchases: ', ['count' => count($voidedPurchases)]);

        } catch (\Exception $e) {
            Log::error("Failed to fetch voided purchases: {$e->getMessage()}");
            // Re-throw the exception so the job's 'failed' method is called
            throw $e;
        }

        foreach ($voidedPurchases as $voided) {
            $token = $voided->purchaseToken ?? null;

            if (!$token) {
                continue;
            }

            Log::info('SyncVoidedSubscriptions - checking token: ' . $token);

            $userSubscription = UserSubscription::where('token', $token)->first();

            if ($userSubscription) {
                Log::info("Voiding subscription for token {$token}");
                $googlePlayService->cancelUserSubscription($token);
            }
        }
    }


    public function failed(\Exception $e): void
    {
        Log::error("Failed to sync voided subscriptions", [$e]);
    }
}
