<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Category, Income, Expense, News};
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIn = (int) \App\Models\Income::sum('amount');
        $totalEx = (int) \App\Models\Expense::sum('amount');
        $saldo   = $totalIn - $totalEx;

        $now       = \Illuminate\Support\Carbon::now();
        $monthFrom = $now->copy()->startOfMonth()->toDateString();
        $monthTo   = $now->copy()->endOfMonth()->toDateString();

        $monthIn   = (int) \App\Models\Income::whereBetween('date', [$monthFrom, $monthTo])->sum('amount');
        $monthEx   = (int) \App\Models\Expense::whereBetween('date', [$monthFrom, $monthTo])->sum('amount');
        $monthSaldo = $monthIn - $monthEx;

        // TOP pengeluaran per kategori (bulan ini)
        $topExpenseThisMonth = \App\Models\Expense::selectRaw('category_id, SUM(amount) as total')
            ->whereBetween('date', [$monthFrom, $monthTo])
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function ($row) {
                $cat = \App\Models\Category::find($row->category_id);
                return [
                    'id'    => (int) $row->category_id,
                    'name'  => $cat?->name ?? 'Tidak diketahui',
                    'total' => (int) $row->total,
                ];
            });

        // Transaksi terbaru (campur pemasukan & pengeluaran)
        $latestIncomes = \App\Models\Income::with('category')->latest('date')->limit(5)->get()->map(function ($x) {
            return [
                'type'       => 'income',
                'date'       => $x->date,
                'category'   => $x->category?->name,
                'label'      => $x->source ?: 'Pemasukan',
                'amount'     => (int) $x->amount,
                'attachment' => $x->attachment_path,
            ];
        });

        $latestExpenses = \App\Models\Expense::with('category')->latest('date')->limit(5)->get()->map(function ($x) {
            return [
                'type'       => 'expense',
                'date'       => $x->date,
                'category'   => $x->category?->name,
                'label'      => $x->description,
                'amount'     => (int) $x->amount,
                'attachment' => $x->attachment_path,
            ];
        });

        $latestTransactions = $latestIncomes->merge($latestExpenses)
            ->sortByDesc('date')->take(8)->values();

        $newsPublished = class_exists(\App\Models\News::class)
            ? (int) \App\Models\News::where('status', 'published')->count()
            : 0;

        return view('admin.dashboard', [
            'totalIn'   => $totalIn,
            'totalEx'   => $totalEx,
            'saldo'     => $saldo,
            'monthIn'   => $monthIn,
            'monthEx'   => $monthEx,
            'monthSaldo' => $monthSaldo,
            'monthText' => $now->translatedFormat('F Y'),
            'topExpenseThisMonth' => $topExpenseThisMonth,
            'latestTransactions' => $latestTransactions,
            'newsPublished'      => $newsPublished,
        ]);
    }
}
