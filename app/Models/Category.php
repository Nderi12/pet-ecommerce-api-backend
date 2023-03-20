<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory, HasUuid;

    /**
     * Protected fillables
     *
     * @var array
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    protected $fillable = [
        'uuid',
        'slug',
        'title',
    ];

    /**
     * Get all products to a category
     *
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_uuid', 'uuid');
    }
}
