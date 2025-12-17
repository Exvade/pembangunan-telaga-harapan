<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Category, Income, Expense, News, Suggestion};

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

        $suggestions = Suggestion::where('allow_public', true)
            ->latest()
            ->get();

        return view('public.home', compact(
            'latestNews',
            'totalIn',
            'totalEx',
            'saldo',
            'suggestions'
        ));
    }

    // pastikan ada di atas file

    public function transparency(\Illuminate\Http\Request $r)
    {
        $totalIncome  = (int) \App\Models\Income::sum('amount');
        $totalExpense = (int) \App\Models\Expense::sum('amount');
        $balance      = $totalIncome - $totalExpense;

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

        $grandExpense = max(1, (int) \App\Models\Expense::sum('amount'));
        $categories = $categories->map(function ($c) use ($grandExpense) {
            $c['share_pct'] = round(($c['total_expense'] / $grandExpense) * 100);
            return $c;
        });

        $global = [
            'total_income'  => $totalIncome,
            'total_expense' => $totalExpense,
            'balance'       => $balance,
        ];

        // 🚀 Tambahan: pemasukan terbaru (limit 12)
        $recentIncomes = Income::select('id', 'date', 'source', 'amount', 'attachment_path')
            ->latest('date')
            ->latest('id')   // buat urutan stabil jika tanggal sama
            ->limit(12)
            ->get();

        return view('public.transparency.index', compact('categories', 'global', 'recentIncomes'));
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
