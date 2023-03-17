<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuid;

    /**
     * Protected fillables
     *
     * @var array
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    protected $fillable = [
        'type',
        'details',
        'title',
    ];
}
