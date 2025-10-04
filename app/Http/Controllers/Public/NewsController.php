<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->get('q');
        $items = News::where('status','published')
            ->when($q, fn($qq)=>$qq->where('title','like',"%$q%"))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();
        return view('public.news.index', compact('items','q'));
    }

    public function show($slug)
    {
        $item = News::where('slug',$slug)->where('status','published')->firstOrFail();
        $others = News::where('status','published')
            ->where('id','!=',$item->id)
            ->latest('published_at')->limit(4)->get();
        return view('public.news.show', compact('item','others'));
    }
}
