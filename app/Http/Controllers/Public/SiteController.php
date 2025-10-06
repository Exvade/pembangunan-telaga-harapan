<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Category, Income, Expense, News};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SiteController extends Controller
{
    public function home()
    {
        $latestNews = News::where('status', 'published')
            ->latest('published_at')->limit(3)->get();

        $totalIn = (int) Income::sum('amount');
        $totalEx = (int) Expense::sum('amount');
        $saldo   = $totalIn - $totalEx;

        return view('public.home', compact('latestNews', 'totalIn', 'totalEx', 'saldo'));
    }

    public function transparency(\Illuminate\Http\Request $r)
    {
        $totalIncome  = (int) \App\Models\Income::sum('amount');
        $totalExpense = (int) \App\Models\Expense::sum('amount');
        $balance      = $totalIncome - $totalExpense;

        // total pengeluaran per kategori
        $categories = \App\Models\Category::select('id', 'name', 'description', 'is_active')
            ->withSum('expenses as total_expense', 'amount')
            ->orderBy('is_active', 'desc')
            ->orderBy('name')
            ->get()
            ->map(function ($c) {
                return [
                    'id'            => $c->id,
                    'name'          => $c->name,
                    'description'   => $c->description,
                    'is_active'     => (bool)$c->is_active,
                    'total_expense' => (int) ($c->total_expense ?? 0),
                ];
            });

        // total semua pengeluaran untuk hitung persentase kategori
        $grandExpense = max(1, (int) \App\Models\Expense::sum('amount')); // hindari bagi 0

        // hitung persentase
        $categories = $categories->map(function ($c) use ($grandExpense) {
            $c['share_pct'] = round(($c['total_expense'] / $grandExpense) * 100);
            return $c;
        });

        $global = [
            'total_income'  => $totalIncome,
            'total_expense' => $totalExpense,
            'balance'       => $balance,
        ];

        return view('public.transparency.index', compact('categories', 'global'));
    }


    public function categoryShow(\App\Models\Category $category, \Illuminate\Http\Request $r)
    {
        $expenses = $category->expenses()->latest('date')->paginate(15);

        $totalExpense = (int) $category->expenses()->sum('amount');

        return view('public.transparency.show', [
            'category'      => $category,
            'totalExpense'  => $totalExpense,
            'expenses'      => $expenses,
        ]);
    }
}
