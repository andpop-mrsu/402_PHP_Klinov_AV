<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::post('/player', [HomeController::class, 'setPlayer']);
Route::post('/reset', [HomeController::class, 'reset']);

Route::get('/play', [GameController::class, 'show']);
Route::post('/play', [GameController::class, 'submit']);

Route::get('/history', [HistoryController::class, 'index']);