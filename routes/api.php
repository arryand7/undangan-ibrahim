<?php

use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::post('/rsvp', [GuestController::class, 'store'])
    ->middleware('throttle:10,1');

Route::get('/guests', [GuestController::class, 'index']);
