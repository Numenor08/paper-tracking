<?php

use App\Http\Controllers\ContributorController;
use App\Http\Controllers\PaperDocumentController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::resource('/contributors', ContributorController::class);
    Route::get('/papers/{paper}/document/preview', [PaperDocumentController::class, 'preview'])
        ->name('papers.documents.preview');
    Route::get('/papers/{paper}/document/download', [PaperDocumentController::class, 'download'])
        ->name('papers.documents.download');
});

require __DIR__.'/settings.php';
