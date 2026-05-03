<?php

use App\Http\Controllers\PaperDocumentController;
use App\Http\Controllers\PaperShowController;
use App\Http\Controllers\PublicDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicDashboardController::class)->name('dashboard');
Route::get('/papers/{paper}/document/preview', [PaperDocumentController::class, 'preview'])
    ->name('papers.documents.preview');
Route::get('/papers/{paper}/document/download', [PaperDocumentController::class, 'download'])
    ->name('papers.documents.download');
Route::get('/papers/{paper}', [PaperShowController::class, 'show'])
    ->name('papers.show');

require __DIR__ . '/settings.php';
