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

    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('news', AdminNewsController::class)->except(['show']);
        // AJAX: upload media langsung untuk sebuah berita
        Route::post('news/{news}/media', [AdminNewsController::class, 'storeMedia'])
            ->name('news.media.store')
            ->middleware('auth');
        Route::delete('news/{news}/media/{media}', [AdminNewsController::class, 'mediaDestroy'])
            ->name('news.media.destroy');
        Route::post('news/media/temp', [AdminNewsController::class, 'storeTempMedia'])
            ->name('news.media.temp');

        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('incomes', AdminIncomeController::class)->except(['show']);
        Route::resource('expenses', AdminExpenseController::class)->except(['show']);

        Route::get('/suggestions', [SuggestionAdminController::class, 'index']);
        Route::post('/suggestions/{id}/publish', [SuggestionAdminController::class, 'togglePublish']);
        Route::post('/suggestions/{id}/handled', [SuggestionAdminController::class, 'markHandled']);
    });

require __DIR__ . '/auth.php';
