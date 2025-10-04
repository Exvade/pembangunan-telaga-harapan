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
        $latestNews = News::where('status','published')
            ->latest('published_at')->limit(3)->get();

        $totalIn = (int) Income::sum('amount');
        $totalEx = (int) Expense::sum('amount');
        $saldo   = $totalIn - $totalEx;

        return view('public.home', compact('latestNews','totalIn','totalEx','saldo'));
    }

    public function transparency(Request $r)
    {
        $categories = Category::select('id','name','description','target_amount','is_active')
            ->withSum('incomes as total_income','amount')
            ->withSum('expenses as total_expense','amount')
            ->orderBy('is_active','desc')
            ->orderBy('name')
            ->get()
            ->map(function($c){
                $in = (int)($c->total_income ?? 0);
                $ex = (int)($c->total_expense ?? 0);
                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'description' => $c->description,
                    'target_amount' => (int)($c->target_amount ?? 0),
                    'is_active' => (bool)$c->is_active,
                    'total_income' => $in,
                    'total_expense' => $ex,
                    'balance' => $in - $ex,
                    'target_pct' => ($c->target_amount ?? 0) > 0
                        ? round($in / $c->target_amount * 100)
                        : null,
                ];
            });

        $global = [
            'total_income' => (int) Income::sum('amount'),
            'total_expense'=> (int) Expense::sum('amount'),
        ];
        $global['balance'] = $global['total_income'] - $global['total_expense'];

        return view('public.transparency.index', compact('categories','global'));
    }

    public function categoryShow(Category $category, Request $r)
    {
        // daftar transaksi terbaru (campur pemasukan & pengeluaran)
        $incomes = $category->incomes()->latest('date')->limit(10)->get()->map(function($x){
            return [
                'type' => 'income',
                'date' => $x->date,
                'label'=> $x->source ?: 'Pemasukan',
                'amount'=>(int)$x->amount,
                'attachment'=>$x->attachment_path,
            ];
        });
        $expenses = $category->expenses()->latest('date')->limit(10)->get()->map(function($x){
            return [
                'type' => 'expense',
                'date' => $x->date,
                'label'=> $x->description,
                'amount'=>(int)$x->amount,
                'attachment'=>$x->attachment_path,
                'unit'=>$x->unit_label,
            ];
        });

        $transactions = $incomes->merge($expenses)->sortByDesc('date')->values();

        $summary = [
            'total_income'  => (int) $category->incomes()->sum('amount'),
            'total_expense' => (int) $category->expenses()->sum('amount'),
            'target_amount' => (int) ($category->target_amount ?? 0),
            'is_active'     => (bool) $category->is_active,
        ];
        $summary['balance'] = $summary['total_income'] - $summary['total_expense'];
        $summary['target_pct'] = $summary['target_amount'] > 0
            ? round($summary['total_income'] / $summary['target_amount'] * 100)
            : null;

        return view('public.transparency.show', compact('category','summary','transactions'));
    }
}
