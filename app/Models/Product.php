<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    /**
     * Protected fillables
     *
     * @var array
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    protected $fillable = [
        'category_uuid',
        'title',
        'price',
        'description',
        'metadata',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }
}
