<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\NewsMedia;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index(Request $r)
    {
        $q = $r->get('q');

        $items = News::withCount('media') // ⬅️ tambahkan ini
            ->when($q, fn($qq) => $qq->where('title', 'like', "%$q%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.news.index', compact('items', 'q'));
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

            // dokumentasi kegiatan
            'media_files.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,mp4,webm|max:12288', // 12MB
            'embed_urls'    => 'nullable|string', // satu-per-baris
        ]);

        $slug      = \Illuminate\Support\Str::slug($data['title']) . '-' . \Illuminate\Support\Str::random(5);
        $coverPath = $r->file('cover')?->store('covers', 'public');

        $news = News::create([
            'title'        => $data['title'],
            'slug'         => $slug,
            'cover_path'   => $coverPath,
            'excerpt'      => \Illuminate\Support\Str::limit(strip_tags($r->input('body')), 160),
            'body'         => $data['body'],
            'status'       => $data['status'],
            'published_at' => $data['status'] === 'published' ? now() : null,
            'author_id'    => auth()->id(),
        ]);

        // === SIMPAN MEDIA UPLOAD ===
        if ($r->hasFile('media_files')) {
            foreach ($r->file('media_files') as $file) {
                if (!$file) continue;
                $mime = $file->getClientMimeType();
                $path = $file->store('news_docs', 'public');

                $type = str_starts_with($mime, 'image/') ? 'image'
                    : (str_starts_with($mime, 'video/') ? 'video' : 'file');

                NewsMedia::create([
                    'news_id'   => $news->id,
                    'type'      => $type,
                    'file_path' => $path,
                    'mime_type' => $mime,
                    'caption'   => null,
                    'credit'    => null,
                    'sort_order' => 0,
                ]);
            }
        }

        // === SIMPAN VIDEO EMBED (YouTube/Vimeo) ===
        if ($r->filled('embed_urls')) {
            $lines = preg_split("/\r\n|\n|\r/", trim($r->input('embed_urls')));
            foreach ($lines as $url) {
                $url = trim($url);
                if ($url === '') continue;
                if (!$this->isAllowedEmbed($url)) continue; // skip jika bukan domain whitelist
                NewsMedia::create([
                    'news_id'   => $news->id,
                    'type'      => 'video',
                    'embed_url' => $url,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()->route('admin.news.index')->with('status', 'Berita ditambahkan.');
    }


    public function edit(News $news)
    {
        return view('admin.news.form', ['item' => $news]);
    }

    public function update(Request $r, News $news)
    {
        $data = $r->validate([
            'title'  => 'required|string|max:200',
            'body'   => 'required|string',
            'status' => 'required|in:draft,published',
            'cover'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // media
            'media_files.*'  => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf,mp4,webm|max:12288',
            'embed_urls'     => 'nullable|string',
            'media'          => 'nullable|array', // media[ID][caption|credit|sort_order|is_featured]
            'media_delete'   => 'nullable|array', // id-id yang mau dihapus
        ]);

        // Cover
        $coverPath = $news->cover_path;
        if ($r->hasFile('cover')) {
            if ($coverPath) Storage::disk('public')->delete($coverPath);
            $coverPath = $r->file('cover')->store('covers', 'public');
        }

        $news->update([
            'title'        => $data['title'],
            'cover_path'   => $coverPath,
            'excerpt'      => \Illuminate\Support\Str::limit(strip_tags($r->input('body')), 160),
            'body'         => $data['body'],
            'status'       => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($news->published_at ?? now()) : null,
        ]);

        // HAPUS media yang dicentang
        if ($r->filled('media_delete')) {
            $ids = array_map('intval', $r->input('media_delete', []));
            $toDel = NewsMedia::where('news_id', $news->id)->whereIn('id', $ids)->get();
            foreach ($toDel as $m) {
                if ($m->file_path) Storage::disk('public')->delete($m->file_path);
                if ($m->thumb_path) Storage::disk('public')->delete($m->thumb_path);
                $m->delete();
            }
        }

        // UPDATE caption/credit/urutan/featured
        if ($r->filled('media')) {
            foreach ($r->input('media') as $id => $payload) {
                $m = NewsMedia::where('news_id', $news->id)->where('id', (int)$id)->first();
                if (!$m) continue;
                $m->caption     = $payload['caption']    ?? $m->caption;
                $m->credit      = $payload['credit']     ?? $m->credit;
                $m->sort_order  = isset($payload['sort_order']) ? (int)$payload['sort_order'] : $m->sort_order;
                $m->is_featured = isset($payload['is_featured']) ? (bool)$payload['is_featured'] : false;
                $m->save();
            }
        }

        // TAMBAH media baru dari upload
        if ($r->hasFile('media_files')) {
            foreach ($r->file('media_files') as $file) {
                if (!$file) continue;
                $mime = $file->getClientMimeType();
                $path = $file->store('news_docs', 'public');
                $type = str_starts_with($mime, 'image/') ? 'image'
                    : (str_starts_with($mime, 'video/') ? 'video' : 'file');

                NewsMedia::create([
                    'news_id'   => $news->id,
                    'type'      => $type,
                    'file_path' => $path,
                    'mime_type' => $mime,
                    'sort_order' => 0,
                ]);
            }
        }

        // TAMBAH embed video baru
        if ($r->filled('embed_urls')) {
            $lines = preg_split("/\r\n|\n|\r/", trim($r->input('embed_urls')));
            foreach ($lines as $url) {
                $url = trim($url);
                if ($url === '') continue;
                if (!$this->isAllowedEmbed($url)) continue;
                NewsMedia::create([
                    'news_id'   => $news->id,
                    'type'      => 'video',
                    'embed_url' => $url,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()->route('admin.news.edit', $news)->with('status', 'Berita diperbarui.');
    }

    protected function isAllowedEmbed(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST) ?: '';
        $host = strtolower($host);
        return str_contains($host, 'youtube.com')
            || str_contains($host, 'youtu.be')
            || str_contains($host, 'vimeo.com');
    }


    public function destroy(News $news)
    {
        if ($news->cover_path) Storage::disk('public')->delete($news->cover_path);
        $news->delete();
        return back()->with('status', 'Berita dihapus.');
    }
}
