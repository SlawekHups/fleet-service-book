<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/vehicles/{vehicle}/service-book.pdf', \App\Http\Controllers\VehiclePdfController::class)
    ->name('vehicles.pdf');

Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['pl','en']), 400);
    session(['locale' => $locale]);
    return back();
})->name('locale.switch');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
