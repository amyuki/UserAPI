<?php

use App\Http\Controllers\UserController;
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

Route::post('user/create', [UserController::class, 'create']);
Route::post('user/login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('user/avatar', [UserController::class, 'uploadAvatar']);
    Route::get('user/search', [UserController::class, 'search']);
    Route::get('user/{user}', [UserController::class, 'view']);
    Route::put('user/{user}', [UserController::class, 'update']);
    Route::delete('user/{user}', [UserController::class, 'delete']);
});
