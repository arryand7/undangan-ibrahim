<?php

use App\Http\Controllers\DeployWebhookController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

Route::post('/rsvp', [GuestController::class, 'store'])
    ->middleware('throttle:10,1');

Route::get('/guests', [GuestController::class, 'index']);

Route::post('/webhooks/github/deploy', DeployWebhookController::class)
    ->middleware('throttle:30,1');
