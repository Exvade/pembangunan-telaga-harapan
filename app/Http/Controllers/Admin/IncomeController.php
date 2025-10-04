<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Income, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncomeController extends Controller
{
    public function index(Request $r)
    {
        $categoryId = $r->get('category_id');
        $from = $r->get('from');
        $to = $r->get('to');

        $items = Income::with('category')
            ->when($categoryId, fn($q)=>$q->where('category_id',$categoryId))
            ->when($from, fn($q)=>$q->whereDate('date','>=',$from))
            ->when($to, fn($q)=>$q->whereDate('date','<=',$to))
            ->latest('date')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::where('is_active',1)->orderBy('name')->get();

        return view('admin.incomes.index', compact('items','categories','categoryId','from','to'));
    }

    public function create()
    {
        $categories = Category::where('is_active',1)->orderBy('name')->get();
        return view('admin.incomes.form', ['item'=>new Income(),'categories'=>$categories]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date|before_or_equal:today',
            'source'      => 'nullable|string|max:150',
            'amount'      => 'required|integer|min:0',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'notes'       => 'nullable|string|max:255',
        ]);

        $path = $r->file('attachment')?->store('attachments/incomes','public');
        $data['attachment_path'] = $path;

        Income::create($data);
        return redirect()->route('admin.incomes.index')->with('status','Pemasukan ditambahkan.');
    }

    public function edit(Income $income)
    {
        $categories = Category::where('is_active',1)->orderBy('name')->get();
        return view('admin.incomes.form', ['item'=>$income,'categories'=>$categories]);
    }

    public function update(Request $r, Income $income)
    {
        $data = $r->validate([
            'category_id' => 'required|exists:categories,id',
            'date'        => 'required|date|before_or_equal:today',
            'source'      => 'nullable|string|max:150',
            'amount'      => 'required|integer|min:0',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:2048',
            'notes'       => 'nullable|string|max:255',
        ]);

        $path = $income->attachment_path;
        if ($r->hasFile('attachment')) {
            if ($path) Storage::disk('public')->delete($path);
            $path = $r->file('attachment')->store('attachments/incomes','public');
        }
        $data['attachment_path'] = $path;

        $income->update($data);
        return redirect()->route('admin.incomes.index')->with('status','Pemasukan diperbarui.');
    }

    public function destroy(Income $income)
    {
        if ($income->attachment_path) Storage::disk('public')->delete($income->attachment_path);
        $income->delete();
        return back()->with('status','Pemasukan dihapus.');
    }
}
