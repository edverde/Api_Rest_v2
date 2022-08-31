<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;



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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/players', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/users', [UserController::class, 'userAll'])->name('allUsers');//role admin
    Route::put('/players/{id}', [UserController::class, 'updateName'])->name('updateName');

    Route::get('/players', [GameController::class, 'successRate'])->name('successRate');
    Route::post('/players/{id}/games', [GameController::class, 'rollDice'])->name('rollDice');
    Route::delete('/players/{id}/games', [GameController::class, 'delete'])->name('delete');
    Route::get('/players/{id}/games', [GameController::class, 'show'])->name('show');

    Route::get('/players/ranking', [GameController::class, 'ranking'])->name('ranking');
    Route::get('/players/ranking/loser', [GameController::class, 'loser'])->name('loser');
    Route::get('/players/ranking/winner', [GameController::class, 'winner'])->name('winner');
    Route::get('/players/ranking/top5', [GameController::class, 'top5'])->name('top5');

    
});