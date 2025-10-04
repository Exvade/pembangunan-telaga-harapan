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
        // === Angka utama (all time) ===
        $totalIn = (int) Income::sum('amount');
        $totalEx = (int) Expense::sum('amount');
        $saldo   = $totalIn - $totalEx;

        // === Bulan berjalan ===
        $now       = Carbon::now();
        $monthFrom = $now->copy()->startOfMonth()->toDateString();
        $monthTo   = $now->copy()->endOfMonth()->toDateString();

        $monthIn = (int) Income::whereBetween('date', [$monthFrom, $monthTo])->sum('amount');
        $monthEx = (int) Expense::whereBetween('date', [$monthFrom, $monthTo])->sum('amount');
        $monthSaldo = $monthIn - $monthEx;

        // === Rekap per kategori (untuk table "Top Kategori") ===
        // pakai withSum biar efisien
        $categoryStats = Category::select('id','name','target_amount','is_active')
            ->withSum('incomes as total_income', 'amount')
            ->withSum('expenses as total_expense', 'amount')
            ->get()
            ->map(function ($c) {
                $in = (int) ($c->total_income ?? 0);
                $ex = (int) ($c->total_expense ?? 0);
                $target = (int) ($c->target_amount ?? 0);
                return [
                    'id'            => $c->id,
                    'name'          => $c->name,
                    'is_active'     => (bool) $c->is_active,
                    'target_amount' => $target,
                    'total_income'  => $in,
                    'total_expense' => $ex,
                    'balance'       => $in - $ex,
                    'target_pct'    => $target > 0 ? round(($in / $target) * 100) : null,
                ];
            });

        // Urutan: pengeluaran terbesar bulan ini (untuk mendeteksi kategori paling aktif)
        $monthTopExpense = Expense::selectRaw('category_id, SUM(amount) as total')
            ->whereBetween('date', [$monthFrom, $monthTo])
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('total','category_id')
            ->toArray();

        // Ambil 5 kategori dengan saldo terbesar (positif)
        $topBalance = $categoryStats->sortByDesc('balance')->take(5)->values();

        // Hit-list kategori dengan expense terbanyak bulan ini (gabungkan nama + total)
        $topExpenseThisMonth = collect($monthTopExpense)
            ->map(function ($total, $categoryId) use ($categoryStats) {
                $cat = $categoryStats->firstWhere('id', (int)$categoryId);
                return [
                    'id'    => (int)$categoryId,
                    'name'  => $cat['name'] ?? 'Tidak diketahui',
                    'total' => (int)$total,
                ];
            })->values();

        // === Transaksi terbaru (campur pemasukan & pengeluaran) ===
        $latestIncomes = Income::with('category')->latest('date')->limit(5)->get()->map(function ($x) {
            return [
                'type'       => 'income',
                'date'       => $x->date,
                'category'   => $x->category?->name,
                'label'      => $x->source ?: 'Pemasukan',
                'amount'     => (int) $x->amount,
                'attachment' => $x->attachment_path,
            ];
        });

        $latestExpenses = Expense::with('category')->latest('date')->limit(5)->get()->map(function ($x) {
            return [
                'type'       => 'expense',
                'date'       => $x->date,
                'category'   => $x->category?->name,
                'label'      => $x->description,
                'amount'     => (int) $x->amount,
                'attachment' => $x->attachment_path,
            ];
        });

        /** @var Collection $latestTransactions */
        $latestTransactions = $latestIncomes->merge($latestExpenses)
            ->sortByDesc('date')
            ->take(8)
            ->values();

        // (Opsional) jumlah berita publish, kalau mau tampilkan
        $newsPublished = class_exists(News::class)
            ? (int) News::where('status','published')->count()
            : 0;

        return view('admin.dashboard', [
            // all-time
            'totalIn'   => $totalIn,
            'totalEx'   => $totalEx,
            'saldo'     => $saldo,
            // month-to-date
            'monthIn'   => $monthIn,
            'monthEx'   => $monthEx,
            'monthSaldo'=> $monthSaldo,
            'monthText' => $now->translatedFormat('F Y'), // e.g. "Oktober 2025"
            // kategori
            'topBalance'         => $topBalance,
            'topExpenseThisMonth'=> $topExpenseThisMonth,
            // transaksi terbaru
            'latestTransactions' => $latestTransactions,
            // opsional
            'newsPublished'      => $newsPublished,
        ]);
    }
}
