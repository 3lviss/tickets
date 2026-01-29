<?php

use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/tickets', [TicketsController::class, 'index'])->name('tickets.index');
