<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

Route::prefix('auth')->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
});