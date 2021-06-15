<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendController;

Auth::routes();

Route::get('/', [FriendController::class, 'index'])->name('home');
Route::resource('friends', FriendController::class);
