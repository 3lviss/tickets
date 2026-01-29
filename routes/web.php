<?php

use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::controller(TicketsController::class)->prefix('tickets')->group(function () {
    Route::get('/', 'index')->name('tickets.index');
    Route::get('/create', 'create')->name('tickets.create');
    Route::post('/', 'store')->name('tickets.store');
    Route::get('/{ticket}', 'show')->name('tickets.show');
    Route::put('/{ticket}', 'update')->name('tickets.update');
    Route::delete('/{ticket}', 'destroy')->name('tickets.destroy');
});