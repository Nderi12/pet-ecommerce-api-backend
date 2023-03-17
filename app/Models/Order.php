<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuid;

    /**
     * Protected fillables
     *
     * @var array
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    protected $fillable = [
        'user_id',
        'order_status_id',
        'payment_id',
        'products',
        'address',
        'delivery_fee',
        'amount',
        'shipped_at',
    ];
}
