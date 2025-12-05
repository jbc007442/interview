<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Frontend Views Only)
|--------------------------------------------------------------------------
|
| These routes ONLY return Blade views.
| API routes handle all CRUD actions.
|
*/

// Registration page
Route::get('/', function () {
    return view('auth.register');
});

// Users list page
Route::get('/users', function () {
    return view('users.index');
});

// View user page
Route::get('/users/{id}', function ($id) {
    return view('users.show', compact('id'));
});

// Edit user page
Route::get('/users/{id}/edit', function ($id) {
    return view('users.edit', compact('id'));
});
