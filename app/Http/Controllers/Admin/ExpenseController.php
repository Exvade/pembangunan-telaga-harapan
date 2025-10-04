<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Expense, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $r)
    {
        $categoryId = $r->get('category_id');
        $from = $r->get('from');
        $to = $r->get('to');

        $items = Expense::with('category')
            ->when($categoryId, fn($q)=>$q->where('category_id',$categoryId))
            ->when($from, fn($q)=>$q->whereDate('date','>=',$from))
            ->when($to, fn($q)=>$q->whereDate('date','<=',$to))
            ->latest('date')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('is_active',1)->orderBy('name')->get();

        return view('admin.expenses.index', compact('items','categories','categoryId','from','to'));
    }

    public function create()
    {
        $categories = Category::where('is_active',1)->orderBy('name')->get();
        return view('admin.expenses.form', ['item'=>new Expense(),'categories'=>$categories]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date|before_or_equal:today',
            'description' => 'required|string|max:200',
            'unit_label'  => 'nullable|string|max:50',
            'amount'      => 'required|integer|min:0',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'notes'       => 'nullable|string|max:255',
        ]);

        $path = $r->file('attachment')?->store('attachments/expenses','public');
        $data['attachment_path'] = $path;

        // (Opsional) peringatan saldo minus bisa kamu cek di UI nanti
        Expense::create($data);
        return redirect()->route('admin.expenses.index')->with('status','Pengeluaran ditambahkan.');
    }

    public function edit(Expense $expense)
    {
        $categories = Category::where('is_active',1)->orderBy('name')->get();
        return view('admin.expenses.form', ['item'=>$expense,'categories'=>$categories]);
    }

    public function update(Request $r, Expense $expense)
    {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date|before_or_equal:today',
            'description' => 'required|string|max:200',
            'unit_label'  => 'nullable|string|max:50',
            'amount'      => 'required|integer|min:0',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'notes'       => 'nullable|string|max:255',
        ]);

        $path = $expense->attachment_path;
        if ($r->hasFile('attachment')) {
            if ($path) Storage::disk('public')->delete($path);
            $path = $r->file('attachment')->store('attachments/expenses','public');
        }
        $data['attachment_path'] = $path;

        $expense->update($data);
        return redirect()->route('admin.expenses.index')->with('status','Pengeluaran diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->attachment_path) Storage::disk('public')->delete($expense->attachment_path);
        $expense->delete();
        return back()->with('status','Pengeluaran dihapus.');
    }
}
