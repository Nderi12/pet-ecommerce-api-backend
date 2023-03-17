<?php

namespace App\Traits;

use \Illuminate\Support\Str;

trait HasUuid 
{
    /**
     *  Create a hook in the boot method
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getRouteKeyName()} = $model->{$model->getRouteKeyName()} ?: (string) Str::uuid();
        });
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable()
    {
        return array_merge($this->fillable, [ 
            $this->getRouteKeyName() 
        ]);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}