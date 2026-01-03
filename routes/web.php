<?php

use App\Http\Controllers\RecipientController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/ebook', function () {
    return Inertia::render('Ebook', []);
});

Route::post('/send-ebook/{name}/{email}', [RecipientController::class, 'sendEbook'])
    ->name('send-ebook');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
