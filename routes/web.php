<?php

use App\Http\Controllers\jsController;
use Illuminate\Support\Facades\Route;

Route::prefix('js')->as('js')->group(function () {
    Route::any('/{layout}/{page}/{file}', [jsController::class, 'javaScript']);
});
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('login', 'Backend\Auth\AuthController@formLogin')->name('login');
Route::get('register', 'Backend\Auth\AuthController@formRegister')->name('register');
Route::post('sign-in','Backend\Auth\AuthController@login')->name('sign-in');
Route::post('sign-up','Backend\Auth\AuthController@register')->name('sign-up');
