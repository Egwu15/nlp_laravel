<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Google\Service\Exception;
use Illuminate\Http\Request;
use App\Services\Payments\GooglePlayService;

class GoogleWebhookController extends Controller
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, GooglePlayService $google)
    {
        $google->handleWebhook($request->all());
        return response()->json(['status' => 'ok']);
    }
}
