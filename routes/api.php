<?php

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
Route::post('/test', function (Request $req) {
    return response()->json(['message' => 'test']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', UserController::class);
    Route::post('/logout', LogoutController::class);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
