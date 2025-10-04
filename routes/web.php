<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\BudgetController as AdminBudgetController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\IncomeController as AdminIncomeController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;


// Redirect root sementara ke login (boleh diubah nanti)
Route::get('/', fn() => redirect()->route('login'));

// Auth routes dari Breeze sudah otomatis tersedia (login, logout, dll)
Route::get('/dashboard', fn () => redirect()->route('admin.dashboard'))->name('dashboard');
// GROUP ADMIN
Route::middleware(['auth','role:admin'])

    ->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('news', AdminNewsController::class)->except(['show']);
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('incomes', AdminIncomeController::class)->except(['show']);
        Route::resource('expenses', AdminExpenseController::class)->except(['show']);
    });

require __DIR__.'/auth.php';
