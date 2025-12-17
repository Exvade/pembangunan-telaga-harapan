<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = [
        'name',
        'message',
        'photos',
        'allow_public',
        'status',
    ];

    protected $casts = [
        'photos' => 'array',
        'allow_public' => 'boolean',
    ];
}
