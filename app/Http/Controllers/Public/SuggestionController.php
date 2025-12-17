<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuggestionController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'nullable|string|max:100',
      'message' => 'required',
      'photos.*' => 'image|max:2048'
    ]);

    $photos = [];

    if ($request->hasFile('photos')) {
      foreach ($request->file('photos') as $file) {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/suggestions'), $filename);
        $photos[] = $filename;
      }
    }

    Suggestion::create([
      'name' => $request->name,
      'message' => $request->message,
      'photos' => $photos,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Terima kasih! Saran Anda berhasil dikirim.'
    ]);
  }

  public function publicIndex()
  {
    $suggestions = Suggestion::where('allow_public', true)
      ->latest()
      ->get();

    return view('suggestions.public', compact('suggestions'));
  }
}
