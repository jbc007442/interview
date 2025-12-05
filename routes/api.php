<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All CRUD operations are handled through API.
| These routes return JSON responses only.
|
*/


// Create User (POST /api/users)
Route::post('/users', [UserController::class, 'store']);


// Get All Users (GET /api/users)
Route::get('/users', [UserController::class, 'index']);


// Get Single User (GET /api/users/{id})
Route::get('/users/{id}', [UserController::class, 'show']);


// Update User (PUT /api/users/{id])
Route::put('/users/{id}', [UserController::class, 'update']);


// Delete User (DELETE /api/users/{id})
Route::delete('/users/{id}', [UserController::class, 'destroy']);
