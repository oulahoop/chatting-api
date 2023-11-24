<?php

use App\Http\Controllers\API\ChannelController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ServerController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;

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

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::get('users', [UserController::class, 'index']);

Route::middleware('auth:api')->group( function () {
    Route::get('messages', [MessageController::class, 'index']);
    Route::post('messages', [MessageController::class, 'store']);
    Route::get('messages/user/{user_id_to}', [MessageController::class, 'getMessageWith']);
    Route::get('messages/channel/{channel_id}', [MessageController::class, 'getChannelMessage']);
    Route::post('server', [ServerController::class, 'store']);
    Route::post('channel', [ChannelController::class, 'store']);
    Route::get('me', [UserController::class, 'me']);
});
