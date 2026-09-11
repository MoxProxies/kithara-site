<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotifyController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])
    ->middleware('throttle:5,1')
    ->name('contact.send');

Route::post('/notify', [NotifyController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('notify');

Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');
