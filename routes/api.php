<?php

use App\Http\Controllers\Api\AppForceUpdateController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\Law\RuleController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Webhooks\GoogleWebhookController;
use App\Http\Controllers\Webhooks\PaystackWebhookController;
use App\Http\Controllers\Api\Auth\{LoginController, LogoutController, RegisterController, UserController};
use App\Http\Controllers\Api\Law\LawController;
use App\Http\Controllers\Api\LegalTerm\LegalTermController;
use App\Http\Controllers\Api\LegalTerm\WordOfTheDayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

Route::get('/test', function (Request $req) {
    return response()->json(['message' => 'all good!']);
});


Route::get('/terms/today', [WordOfTheDayController::class, 'showToday']);
Route::get('/terms/all_time', [WordOfTheDayController::class, 'showMonthly']);
Route::get('/term/{term}', [LegalTermController::class, 'searchLegalTerm']);
Route::get('/version/{platform}', AppForceUpdateController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', UserController::class);
    Route::post('/logout', LogoutController::class);
    Route::Resource('/laws', LawController::class);
    Route::Resource('/rules', RuleController::class);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/subscriptions/plans', [SubscriptionController::class, 'plans']);
    Route::post('verify_google_purchase', [SubscriptionController::class, 'verifyGooglePurchase']);

    Route::post('/webhooks/google-play', [GoogleWebhookController::class, 'handle']);
    Route::post('/webhooks/paystack', [PaystackWebhookController::class, 'handle']);

});
