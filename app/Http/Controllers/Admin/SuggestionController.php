<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;

class SuggestionController extends Controller
{
  public function index()
  {
    $data = Suggestion::latest()->get();
    return view('admin.suggestions.index', compact('data'));
  }

  public function togglePublish($id)
  {
    $s = Suggestion::findOrFail($id);
    $s->allow_public = !$s->allow_public;
    $s->save();

    return back();
  }

  public function markHandled($id)
  {
    Suggestion::where('id', $id)->update([
      'status' => 'handled'
    ]);

    return back();
  }
}
