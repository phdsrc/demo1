<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::apiResource('users', \App\Http\Controllers\UserController::class)
    ->only(['index', 'show', 'create', 'edit']);
