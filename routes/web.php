<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LawController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/laws', [LawController::class, 'laws'])->name('laws');
    Route::get('/laws/{law}/chapters', [LawController::class, 'chapters'])->name('laws.chapters');
    Route::get('/chapters/{chapter}/parts', [LawController::class, 'parts'])->name('chapters.parts');
    Route::get('/parts/{part}/sections', [LawController::class, 'sections'])->name('parts.sections');

});


require __DIR__.'/auth.php';
