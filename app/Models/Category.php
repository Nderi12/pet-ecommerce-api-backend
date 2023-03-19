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
        'slug',
        'title',
    ];

    /**
     * Static method called automatically when the model is booted
     *
     * @var array
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    protected static function boot()
    {
        parent::boot();

        // Closure that is executed when a new instance of the model is being created.
        static::creating(function ($category) {
            // Set the value of the slug on the model generated from the name
            $category->slug = Str::slug($category->name);
        });
    }

    /**
     * Get all products to a category
     *
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
