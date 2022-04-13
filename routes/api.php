<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartyController;
// use App\Http\Controllers\MembershipController;

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

//AUTHS
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);


    //USERS
    Route::get('/users', [UserController::class, 'getAll']);
    Route::get('/users/{id}', [UserController::class, 'getById']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'delete']);


    //PARTIES
    Route::post('/parties', [PartyController::class, 'create']);
    Route::get('/parties', [PartyController::class, 'getAll']);
    Route::get('/parties/getByUser/{id}', [PartyController::class, 'getByUser']);
    Route::get('/parties/getByGame/{id}', [PartyController::class, 'getByGame']);
    Route::get('/parties/{id}', [PartyController::class, 'getById']);
    Route::put('/parties/{id}', [PartyController::class, 'update']);
    Route::delete('/parties/{id}', [PartyController::class, 'delete']);


});
