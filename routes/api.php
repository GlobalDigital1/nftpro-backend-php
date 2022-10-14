<?php

use App\Enums\NftBlockchain;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\GasController;
use App\Http\Controllers\MintController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevenueCatWebHookController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserFcmTokenController;
use App\Http\Controllers\UserNftController;
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
Route::get('auth/message', [AuthController::class, 'message']);
Route::post('auth/verify', [AuthController::class, 'login']);
Route::post('revenue-cat', [RevenueCatWebHookController::class, 'handle']);
Route::get('config', [ConfigController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('fcm', [UserFcmTokenController::class, 'create']);
    Route::post('mint/{chain}', [MintController::class, 'create'])
         ->whereIn('chain', NftBlockchain::toArray());
    Route::post('transfer/{chain}', [TransferController::class, 'create'])
         ->whereIn('chain', NftBlockchain::toArray());
    Route::get('gas/{chain}', [GasController::class, 'show'])
         ->whereIn('chain', NftBlockchain::toArray());
    Route::get('nfts', [UserNftController::class, 'index']);
    Route::get('nfts/{id}', [UserNftController::class, 'show']);
    Route::get('profile', [ProfileController::class, 'show']);
    Route::post('profile', [ProfileController::class, 'update']);
    Route::delete('profile', [ProfileController::class, 'delete']);
});
