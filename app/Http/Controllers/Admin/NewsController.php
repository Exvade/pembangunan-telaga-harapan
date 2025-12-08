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
        $items = News::when($q, fn($qq) => $qq->where('title', 'like', "%$q%"))
            ->latest()
            ->paginate(10);
        return view('admin.news.index', compact('items', 'q'));
    }

    public function create()
    {
        return view('admin.news.form', ['item' => new News()]);
    }

    public function store(Request $r)
    {
        // 1. Validasi
        $data = $r->validate([
            'title'  => 'required|string|max:200',
            'body'   => 'required|string',
            'status' => 'required|in:draft,published',
            'cover'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // Kita tidak butuh validasi media_files fisik lagi di sini jika pakai AJAX semua
            'temp_files' => 'nullable|array',
        ]);

        $slug = Str::slug($data['title']) . '-' . Str::random(5);
        $coverPath = $r->file('cover')?->store('covers', 'public');

        // 2. Buat Berita
        $news = News::create([
            'title'        => $data['title'],
            'slug'         => $slug,
            'cover_path'   => $coverPath,
            'excerpt'      => Str::limit(strip_tags($r->input('body')), 160),
            'body'         => $data['body'],
            'status'       => $data['status'],
            'published_at' => $data['status'] === 'published' ? now() : null,
            'author_id'    => auth()->id(), // Pastikan ada auth
        ]);

        // 3. PROSES FILE DARI TEMP (AJAX UPLOAD)
        if ($r->has('temp_files')) {
            foreach ($r->input('temp_files') as $jsonFile) {
                $fileData = json_decode($jsonFile, true);

                if (!$fileData || !Storage::disk('public')->exists($fileData['path'])) continue;

                // Pindahkan file dari temp ke folder berita
                $newPath = "news-media/{$news->id}/" . basename($fileData['path']);
                Storage::disk('public')->move($fileData['path'], $newPath);

                $news->media()->create([
                    'type'       => $fileData['type'],
                    'file_path'  => $newPath,
                    'mime_type'  => $fileData['mime'],
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()->route('admin.news.index')->with('status', 'Berita berhasil diterbitkan.');
    }

    public function storeTempMedia(Request $r)
    {
        // Validasi 30MB
        $r->validate([
            'file' => 'required|file|max:30720|mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/quicktime,video/webm',
        ]);

        if ($r->hasFile('file')) {
            $file = $r->file('file');
            $mime = $file->getMimeType();
            $type = str_starts_with($mime, 'image/') ? 'image' : 'video';

            // Simpan ke folder temp
            $path = $file->store('temp', 'public');

            return response()->json([
                'ok' => true,
                'data' => [
                    'path' => $path, // Path sementara
                    'url'  => asset('media/' . $path),
                    'type' => $type,
                    'mime' => $mime
                ]
            ]);
        }

        return response()->json(['ok' => false], 400);
    }

    public function edit(News $news)
    {
        $news->load(['media' => fn($q) => $q->orderBy('sort_order')->orderBy('id')]);
        return view('admin.news.form', ['item' => $news]);
    }

    public function update(Request $r, News $news)
    {
        $data = $r->validate([
            'title'  => 'required|string|max:200',
            'body'   => 'required|string',
            'status' => 'required|in:draft,published',
            'cover'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // HANYA foto & video, tidak boleh PDF
            'media_files'   => 'nullable|array',
            'media_files.*' => 'file|max:30720|mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/quicktime,video/webm',
            'delete_media_ids'   => 'array',
            'delete_media_ids.*' => 'integer',
        ]);

        $coverPath = $news->cover_path;
        if ($r->hasFile('cover')) {
            if ($coverPath) Storage::disk('public')->delete($coverPath);
            $coverPath = $r->file('cover')->store('covers', 'public');
        }

        $news->update([
            'title'        => $data['title'],
            'cover_path'   => $coverPath,
            'excerpt'      => Str::limit(strip_tags($r->input('body')), 160),
            'body'         => $data['body'],
            'status'       => $data['status'],
            'published_at' => $data['status'] === 'published' ? ($news->published_at ?? now()) : null,
        ]);

        // Hapus media yg ditandai (fallback non-AJAX)
        $idsToDelete = $r->input('delete_media_ids', []);
        if (!empty($idsToDelete)) {
            $medias = $news->media()->whereIn('id', $idsToDelete)->get();
            foreach ($medias as $m) {
                if ($m->file_path) Storage::disk('public')->delete($m->file_path);
                $m->delete();
            }
        }

        // ========== Fallback non-AJAX: upload media baru saat update ==========
        if ($r->hasFile('media_files')) {
            $limit    = 10;
            $existing = $news->media()->count();
            $files    = $r->file('media_files');

            foreach ($files as $file) {
                if (!$file) continue;
                if ($existing >= $limit) break;

                $mime = $file->getMimeType();
                $type = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'video/') ? 'video' : null);
                if (!$type) continue;

                $stored = $file->store("news-media/{$news->id}", 'public');

                $news->media()->create([
                    'type'       => $type,
                    'file_path'  => $stored,
                    'mime_type'  => $mime,
                    'caption'    => null,
                    'credit'     => null,
                    'sort_order' => 0,
                ]);

                $existing++;
            }
        }

        return redirect()->route('admin.news.index')->with('status', 'Berita diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->cover_path) Storage::disk('public')->delete($news->cover_path);
        foreach ($news->media as $m) {
            if ($m->file_path) Storage::disk('public')->delete($m->file_path);
        }
        $news->media()->delete();
        $news->delete();

        return back()->with('status', 'Berita dihapus.');
    }

    /**
     * AJAX: Upload media (hanya foto & video) dengan batas total 10 per berita.
     * Route contoh: admin.news.media.store
     */
    public function storeMedia(Request $r, News $news)
    {
        $data = $r->validate([
            'media_files'   => ['required', 'array', 'min:1'],
            'media_files.*' => [
                'required',
                'file',
                'max:30720',
                // HANYA foto & video
                'mimetypes:image/jpeg,image/png,image/webp,image/gif,video/mp4,video/quicktime,video/webm',
            ],
        ], [
            'media_files.required'    => 'Pilih minimal satu file.',
            'media_files.*.mimetypes' => 'Hanya gambar atau video yang diperbolehkan.',
            'media_files.*.max'       => 'Ukuran file maksimal 30 MB.',
        ]);

        $limit    = 10;
        $existing = $news->media()->count();
        $incoming = count($data['media_files']);

        if ($existing >= $limit) {
            return response()->json([
                'ok' => false,
                'error' => "Media untuk berita ini sudah mencapai batas {$limit} item."
            ], 422);
        }

        if ($existing + $incoming > $limit) {
            $allowed = $limit - $existing;
            return response()->json([
                'ok' => false,
                'error' => "Anda hanya bisa menambah {$allowed} file lagi (maks {$limit} per berita)."
            ], 422);
        }

        $created = [];
        foreach ($data['media_files'] as $file) {
            if (!$file) continue;

            $mime = $file->getMimeType();
            $type = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'video/') ? 'video' : null);
            if (!$type) continue;

            $stored = $file->store("news-media/{$news->id}", 'public');

            $media = $news->media()->create([
                'type'       => $type,
                'file_path'  => $stored,
                'mime_type'  => $mime,
                'caption'    => null,
                'credit'     => null,
                'sort_order' => 0,
            ]);

            $created[] = [
                'id'   => $media->id,
                'type' => $media->type,
                'url'  => asset('media/' . $media->file_path),
                'mime' => $media->mime_type,
            ];
        }

        return response()->json(['ok' => true, 'items' => $created]);
    }
}
