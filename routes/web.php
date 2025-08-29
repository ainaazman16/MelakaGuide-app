<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [PlaceController::class, 'index'])->name('home');
Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
Route::get('/places/create', [PlaceController::class, 'create'])->name('places.create');
Route::post('/places', [PlaceController::class, 'store'])->name('places.store');
Route::get('/places/{place}', [PlaceController::class, 'show'])->name('places.show');

// Auth-only routes
Route::middleware('auth')->group(function () {
    Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])->name('places.edit');
    Route::put('/places/{place}', [PlaceController::class, 'update'])->name('places.update');
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('places.destroy');

    Route::post('/places/{place}/reviews', [ReviewController::class,'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class,'destroy'])->name('reviews.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::get('/places/{place}', [PlaceController::class, 'show'])->name('places.show');
// Route::resource('places', PlaceController::class)->only(['index', 'show']);



// Dashboard redirect
Route::get('/dashboard', function () {
    return redirect()->route('places.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
