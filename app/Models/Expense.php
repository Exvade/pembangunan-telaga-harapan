<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['category_id','date','description','unit_label','amount','attachment_path','notes'];

    protected $casts = ['date' => 'date'];

    public function category() { return $this->belongsTo(Category::class); }
}
