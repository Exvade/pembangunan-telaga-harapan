<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->get('q');
        $items = News::when($q, fn($qq)=>$qq->where('title','like',"%$q%"))
            ->latest()->paginate(10);
        return view('admin.news.index', compact('items','q'));
    }

    public function create()
    {
        return view('admin.news.form', ['item' => new News()]);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'title'  => 'required|string|max:200',
            'body'   => 'required|string',
            'status' => 'required|in:draft,published',
            'cover'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $slug = Str::slug($data['title']).'-'.Str::random(5);
        $coverPath = $r->file('cover')?->store('covers','public');

        News::create([
            'title'        => $data['title'],
            'slug'         => $slug,
            'cover_path'   => $coverPath,
            'excerpt'      => Str::limit(strip_tags($r->input('body')), 160),
            'body'         => $data['body'],
            'status'       => $data['status'],
            'published_at' => $data['status']==='published' ? now() : null,
            'author_id'    => auth()->id(),
        ]);

        return redirect()->route('admin.news.index')->with('status','Berita ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.news.form', ['item'=>$news]);
    }

    public function update(Request $r, News $news)
    {
        $data = $r->validate([
            'title'  => 'required|string|max:200',
            'body'   => 'required|string',
            'status' => 'required|in:draft,published',
            'cover'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $coverPath = $news->cover_path;
        if ($r->hasFile('cover')) {
            if ($coverPath) Storage::disk('public')->delete($coverPath);
            $coverPath = $r->file('cover')->store('covers','public');
        }

        $news->update([
            'title'        => $data['title'],
            'cover_path'   => $coverPath,
            'excerpt'      => Str::limit(strip_tags($r->input('body')), 160),
            'body'         => $data['body'],
            'status'       => $data['status'],
            'published_at' => $data['status']==='published' ? ($news->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.news.index')->with('status','Berita diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->cover_path) Storage::disk('public')->delete($news->cover_path);
        $news->delete();
        return back()->with('status','Berita dihapus.');
    }
}
