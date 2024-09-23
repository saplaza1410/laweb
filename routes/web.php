<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/contacts', [ContactController::class, 'index']);
Route::get('/we', [HomeController::class, 'we']);
