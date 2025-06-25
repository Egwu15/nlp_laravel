<?php

use App\Http\Controllers\Api\LawController;
use App\Http\Controllers\Api\LegalTerm\LegalTermController;
use App\Http\Controllers\Api\LegalTerm\WordOfTheDayController;
use App\Models\WordOfTheDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\{
    RegisterController,
    LoginController,
    LogoutController,
    UserController
};

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::get('/test', function (Request $req) {
    return response()->json(['message' => 'test']);
});


Route::get('/terms/today', [WordOfTheDayController::class, 'showToday']);
Route::get('/terms/all_time', [WordOfTheDayController::class, 'showMonthly']);
Route::get('/term/{term}', [LegalTermController::class, 'searchLegalTerm']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', UserController::class);
    Route::post('/logout', LogoutController::class);
    Route::Resource('/laws', LawController::class);
});


