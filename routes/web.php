<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('outgoing', function () {
    return Inertia::render('Outgoing');
})->middleware(['auth', 'verified'])->name('outgoing');

// Route::post('/outgoing', [OutgoingController::class, 'store']); // maybe not needed?
// Route::middleware('/outgoing', [OutgoingController::class, 'store']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
