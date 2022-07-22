<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MintController;
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
Route::get('auth/message', [AuthController::class, 'message']);
Route::post('auth/verify', [AuthController::class, 'login']);
//Route::middleware('auth:sanctum')->group( function (Request $request) {
    Route::post('mint', [MintController::class, 'create']);
//});
