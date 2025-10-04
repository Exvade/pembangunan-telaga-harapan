<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->get('q');
        $items = Category::when($q, fn($qq)=>$qq->where('name','like',"%$q%"))
            ->orderBy('is_active','desc')
            ->latest()
            ->paginate(12);
        return view('admin.categories.index', compact('items','q'));
    }

    public function create()
    {
        return view('admin.categories.form', ['item'=>new Category()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:150|unique:categories,name',
            'description' => 'nullable|string',
            'target_amount' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $r->boolean('is_active', true);
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('status','Kategori dibuat.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', ['item'=>$category]);
    }

    public function update(Request $r, Category $category)
    {
        $data = $r->validate([
            'name' => 'required|string|max:150|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
            'target_amount' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $r->boolean('is_active', true);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('status','Kategori diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Opsional: larang hapus jika ada transaksi. Untuk simpel: izinkan.
        $category->delete();
        return back()->with('status','Kategori dihapus.');
    }
}
