<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'documentsCount' => Document::count(),
        'myDocumentsCount' => auth()->user()->documents()->count(),
        'usersCount' => User::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // La recherche doit être déclarée AVANT le resource, sinon /documents/search
    // serait interprétée comme /documents/{document}.
    Route::get('/documents/search', [DocumentController::class, 'search'])->name('documents.search');
    Route::resource('documents', DocumentController::class);
    Route::resource('users', UserController::class);
});

require __DIR__ . '/auth.php';
