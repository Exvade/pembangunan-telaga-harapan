<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Income, Expense, News};
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIn = (int) Income::sum('amount');
        $totalEx = (int) Expense::sum('amount');
        $saldo   = $totalIn - $totalEx;

        $now       = Carbon::now();
        $monthFrom = $now->copy()->startOfMonth()->toDateString();
        $monthTo   = $now->copy()->endOfMonth()->toDateString();

        $monthIn    = (int) Income::whereBetween('date', [$monthFrom, $monthTo])->sum('amount');
        $monthEx    = (int) Expense::whereBetween('date', [$monthFrom, $monthTo])->sum('amount');
        $monthSaldo = $monthIn - $monthEx;

        // TOP pengeluaran per kategori (bulan ini) — FIX: jangan select categories.*
        $topExpenseThisMonth = Category::query()
            ->join('expenses', 'expenses.category_id', '=', 'categories.id')
            ->whereBetween('expenses.date', [$monthFrom, $monthTo])
            ->groupBy('categories.id', 'categories.name')
            ->select('categories.id', 'categories.name')                 // ✅ hanya kolom yang digrup
            ->selectRaw('SUM(expenses.amount) AS total')                 // ✅ agregat
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Transaksi terbaru — tetap Model + atribut virtual
        $latestIncomes = Income::with('category')
            ->latest('date')->limit(5)->get()
            ->map(function (Income $x) {
                $x->setAttribute('type', 'income');
                $x->setAttribute('label', $x->source ?: 'Pemasukan');
                return $x;
            });

        $latestExpenses = Expense::with('category')
            ->latest('date')->limit(5)->get()
            ->map(function (Expense $x) {
                $x->setAttribute('type', 'expense');
                $x->setAttribute('label', $x->description);
                return $x;
            });

        $latestTransactions = $latestIncomes
            ->merge($latestExpenses)
            ->sortByDesc('date')->take(8)->values();

        $newsPublished = class_exists(News::class)
            ? (int) News::where('status', 'published')->count()
            : 0;

        return view('admin.dashboard', [
            'totalIn'              => $totalIn,
            'totalEx'              => $totalEx,
            'saldo'                => $saldo,
            'monthIn'              => $monthIn,
            'monthEx'              => $monthEx,
            'monthSaldo'           => $monthSaldo,
            'monthText'            => $now->translatedFormat('F Y'),
            'topExpenseThisMonth'  => $topExpenseThisMonth,  // item = Category (id,name) + total
            'latestTransactions'   => $latestTransactions,   // item = Income/Expense model + attr
            'newsPublished'        => $newsPublished,
        ]);
    }
}
