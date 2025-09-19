<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessGooglePlayWebhook;
use Google\Service\Exception;
use Illuminate\Http\Request;
use App\Services\Payments\GooglePlayService;
use Illuminate\Support\Facades\Log;

class GoogleWebhookController extends Controller
{

    public function handle(Request $request, GooglePlayService $google)
    {
        Log::info('Processing before queue', ['data' => $request->all()]);
        ProcessGooglePlayWebhook::dispatch($request->all());
        return response()->json(['status' => 'ok']);
    }
}

