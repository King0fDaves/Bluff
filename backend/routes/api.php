<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GameController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/get-room', [RoomController::class, 'getRoom']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/host-room', [RoomController::class, 'hostRoom']);
    Route::post('/join-room', [RoomController::class, 'joinRoom']);
    Route::delete('/leave-room', [RoomController::class, 'leaveRoom']);
    Route::delete('/remove-room', [RoomController::class, 'removeRoom']);

    Route::post('/start-game', [GameController::class, 'startGame']);


    Route::get('/token', [AuthController::class, 'getToken']);
    Route::delete('/logout', [AuthController::class, 'logout']);

});