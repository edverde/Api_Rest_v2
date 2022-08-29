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

// Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/players', [UserController::class, 'userAll'])->name('allUsers');
    Route::put('players/{id}', [UserController::class, 'updateName'])->name('updateName');

    Route::post('players/{id}/games', [GameController::class, 'rollDice'])->name('rollDice');
    Route::delete('players/{id}/games', [GameController::class, 'delete'])->name('delete');
    Route::get('/players/{id}/games', [GameController::class, 'show'])->name('show');
// });