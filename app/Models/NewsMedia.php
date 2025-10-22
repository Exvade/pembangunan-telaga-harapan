<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsMedia extends Model
{
    protected $table = 'news_media';

    protected $fillable = [
        'news_id',
        'type',
        'file_path',
        'thumb_path',
        'mime_type',
        'embed_url',
        'caption',
        'credit',
        'taken_at',
        'location',
        'sort_order',
        'is_featured'
    ];

    protected $casts = [
        'taken_at'    => 'date',
        'is_featured' => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
