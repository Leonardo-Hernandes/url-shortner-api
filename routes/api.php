<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);

// Users
Route::post('/user/register', [UserController::class, 'register']);
Route::delete('/user/delete', [UserController::class, 'delete']);

// Links
Route::middleware('auth:api')->post('/link', [LinkController::class, 'store']);
Route::middleware('auth:api')->put('/link/{id?}', [LinkController::class, 'update']);
Route::middleware('auth:api')->delete('/link/delete/{id?}', [LinkController::class, 'delete']);
Route::get('/link/redirect/{id?}', [LinkController::class, 'show']);
Route::get('/link/search/{id?}', [LinkController::class, 'search']);