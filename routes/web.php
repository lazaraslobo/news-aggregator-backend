<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// web.php
Route::get('/sanctum/csrf-cookie', function () {
    return response()->json('CSRF token set');
});

Route::get('/{any}', function () {
    return view('react');
})->where('any', '.*');
