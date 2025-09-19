<?php

namespace App\Jobs;

use App\Models\GooglePlayNotification;
use App\Services\Payments\GooglePlayService;
use Google\Service\Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessGooglePlayWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;
    public array $backoff = [60, 300, 900, 3600];

    /**
     * Create a new job instance.
     */
    public function __construct(public array $payload)
    {
        //
    }

    /**
     * Execute the job.
     * @throws Exception
     */
    public function handle(GooglePlayService $googlePlayService): void
    {
        Log::info('Processing Google Play webhook payload in queue', $this->payload);

        $messageData = json_decode(base64_decode($this->payload['message']['data']), true);
        $notification = $messageData['subscriptionNotification'];

        $purchaseToken = $notification['purchaseToken'];
        $notificationType = $notification['notificationType'];

        GooglePlayNotification::updateOrCreate(
            ['purchase_token' => $purchaseToken],
            [
                'product_id' => $notification['subscriptionId'],
                'notification_type' => $notificationType,
                'payload' => $messageData,
            ]
        );

        $googlePlayService->handleSubscriptionNotification($notification);
    }
}
