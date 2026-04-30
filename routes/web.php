<?php

use App\Http\Controllers\PaperDocumentController;
use App\Http\Controllers\PublicDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicDashboardController::class)->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/papers/{paper}/document/preview', [PaperDocumentController::class, 'preview'])
        ->name('papers.documents.preview');
    Route::get('/papers/{paper}/document/download', [PaperDocumentController::class, 'download'])
        ->name('papers.documents.download');
});

require __DIR__.'/settings.php';
