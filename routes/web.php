<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\BudgetController as AdminBudgetController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\IncomeController as AdminIncomeController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;
use App\Http\Controllers\Public\SiteController;
use App\Http\Controllers\Public\NewsController as PublicNewsController;
use App\Http\Controllers\Admin\SuggestionController as SuggestionAdminController;
use App\Http\Controllers\Public\SuggestionController;




// Redirect root sementara ke login (boleh diubah nanti)
Route::get('/', [SiteController::class, 'home'])->name('public.home');

Route::get('/berita', [PublicNewsController::class, 'index'])->name('public.news.index');
Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])->name('public.news.show');

Route::get('/transparansi', [SiteController::class, 'transparency'])->name('public.transparency');
Route::get('/transparansi/kategori/{category}', [SiteController::class, 'categoryShow'])->name('public.category.show');
// catatan: {category} akan by default binding ke ID (int). Boleh pakai id dulu untuk simpel.

Route::view('/tentang', 'public.about')->name('public.about');

// Auth routes dari Breeze sudah otomatis tersedia (login, logout, dll)
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'))->name('dashboard');

Route::post('/saran', [SuggestionController::class, 'store'])->name('suggestion.store');
Route::get('/saran-publik', [SuggestionController::class, 'publicIndex']);
// GROUP ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.') // Prefix nama route jadi 'admin.'
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Resource Routes (News, Category, Income, Expense)
        Route::resource('news', AdminNewsController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('incomes', AdminIncomeController::class)->except(['show']);
        Route::resource('expenses', AdminExpenseController::class)->except(['show']);

        // --- MEDIA UPLOAD (News) ---
        Route::post('news/{news}/media', [AdminNewsController::class, 'storeMedia'])->name('news.media.store');
        Route::delete('news/{news}/media/{media}', [AdminNewsController::class, 'mediaDestroy'])->name('news.media.destroy');
        Route::post('news/media/temp', [AdminNewsController::class, 'storeTempMedia'])->name('news.media.temp');

        // --- SUGGESTIONS (SARAN) ---
        // 1. Halaman Index (Daftar Saran) -> INI YANG BIKIN ERROR SEBELUMNYA
        Route::get('/suggestions', [SuggestionAdminController::class, 'index'])
            ->name('suggestions.index');

        // 2. Toggle Publish
        Route::post('/suggestions/{id}/publish', [SuggestionAdminController::class, 'togglePublish'])
            ->name('suggestions.publish');

        // 3. Mark as Handled
        Route::post('/suggestions/{id}/handled', [SuggestionAdminController::class, 'markHandled'])
            ->name('suggestions.handled');
    });

require __DIR__ . '/auth.php';
