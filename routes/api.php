<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;

Route::get('/events', [EventController::class, 'index']);
Route::post('/registrations', [RegistrationController::class, 'store']);
Route::get('/registrations', [RegistrationController::class, 'index']);
Route::get('/registrations/filter', [RegistrationController::class, 'filter']);
