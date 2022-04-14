<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;

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

Route::put('/parties/{id}', [PartyController::class, 'update']);

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
    Route::get('/parties/getByUser/{ownerNickname}', [PartyController::class, 'getByUser']);
    Route::get('/parties/getByGame/{id}', [PartyController::class, 'getByGame']);
    Route::get('/parties/{id}', [PartyController::class, 'getById']);
    // Route::put('/parties/{id}', [PartyController::class, 'update']);
    Route::delete('/parties/{id}', [PartyController::class, 'delete']);


    //MEMBERSHIPS
    Route::post('/memberships', [MembershipController::class, 'create']);
    Route::get('/memberships', [MembershipController::class, 'getAll']);
    Route::get('/memberships/user/{user_id}', [MembershipController::class, 'getByUser']);
    Route::get('/memberships/party/{party_id}', [MembershipController::class, 'getByParty']);
    Route::get('/memberships/{id}', [MembershipController::class, 'get']);
    Route::delete('/memberships/{id}', [MembershipController::class, 'delete']);


    //GAMES
    Route::post('/games', [GameController::class, 'create']);
    Route::get('/games', [GameController::class, 'getAll']);
    Route::get('/games/{id}', [GameController::class, 'getById']);
    Route::put('/games/{id}', [GameController::class, 'update']);
    Route::delete('/games/{id}', [GameController::class, 'delete']);


    //MESSAGES


});
