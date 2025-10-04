<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['category_id','date','source','amount','attachment_path','notes'];

    protected $casts = ['date' => 'date'];

    public function category() { return $this->belongsTo(Category::class); }
}
