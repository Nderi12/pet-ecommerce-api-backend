<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'title',
        'content',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];
}
