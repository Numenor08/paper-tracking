<?php

use App\Http\Controllers\ContributorController;
use App\Http\Controllers\PaperDocumentController;
use App\Http\Controllers\PublicDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', PublicDashboardController::class)->name('public.dashboard');
Route::get('/public/api/statistics', [PublicDashboardController::class, 'statistics'])->name('public.api.statistics');
Route::get('/public/api/papers', [PublicDashboardController::class, 'papers'])->name('public.api.papers');
Route::get('/public/api/contributors', [PublicDashboardController::class, 'contributors'])->name('public.api.contributors');
Route::get('/public/api/status-distribution', [PublicDashboardController::class, 'statusDistribution'])->name('public.api.status_distribution');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
    Route::resource('/contributors', ContributorController::class);
    Route::get('/papers/{paper}/document/preview', [PaperDocumentController::class, 'preview'])
        ->name('papers.documents.preview');
    Route::get('/papers/{paper}/document/download', [PaperDocumentController::class, 'download'])
        ->name('papers.documents.download');
});

require __DIR__.'/settings.php';
