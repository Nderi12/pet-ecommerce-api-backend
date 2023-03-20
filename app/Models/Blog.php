<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];
}
