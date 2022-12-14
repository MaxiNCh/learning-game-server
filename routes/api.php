<?php

use App\Http\Controllers\API\BroadcastController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\LobbyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/lobby/check-pincode', [LobbyController::class, 'checkPincode']);
Route::post('/lobby/join', [LobbyController::class, 'joinGame']);
Route::post('/broadcasting/auth', [BroadcastController::class, 'auth']);
Route::post('/broadcasting/logout', [BroadcastController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/games/user', [GameController::class, 'gamesByUser']);
    Route::apiResource('games', GameController::class);

    Route::post('/lobby/{game}', [LobbyController::class, 'create']);
    Route::post('/lobby/close/{lobby}', [LobbyController::class, 'close']);
});
