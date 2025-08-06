<?php

use App\Http\Controllers\OutgoingController;
use App\Models\Outgoing;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('outgoing', function () {
    $outgoing = Outgoing::where('user_id', auth()->id())
        ->where('has_been_sent', true)
        ->orderBy('date', 'desc')
        ->get();
        
    return Inertia::render('Outgoing', [
        'success' => session('success'),
        'outgoing' => $outgoing,
    ]);
})->middleware(['auth', 'verified'])->name('outgoing');

Route::post('outgoing', [OutgoingController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('outgoing.store');

Route::patch('outgoing/{outgoing}/thanked', [OutgoingController::class, 'updateThanked'])
    ->middleware(['auth', 'verified'])
    ->name('outgoing.updateThanked');

Route::patch('outgoing/{outgoing}/has-been-sent', [OutgoingController::class, 'updateHasBeenSent'])
    ->middleware(['auth', 'verified'])
    ->name('outgoing.updateHasBeenSent');

Route::get('received', function () {
    return Inertia::render('Received');
})->middleware(['auth', 'verified'])->name('received');

Route::get('offers', function () {
    $outgoing = Outgoing::where('user_id', auth()->id())
        ->where('has_been_sent', false)
        ->orderBy('date', 'desc')
        ->get();
        
    return Inertia::render('Offers', [
        'success' => session('success'),
        'outgoing' => $outgoing,
    ]);
})->middleware(['auth', 'verified'])->name('offers');

Route::get('analytics', function () {
    return Inertia::render('Analytics');
})->middleware(['auth', 'verified'])->name('analytics');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
