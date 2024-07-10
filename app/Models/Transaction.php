<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'order_id',
        'id_payment',
        'status',
        'total',
    ];

    public function store()
    {

        return $this->belongsTo(Store::class);
    }

    public function order()
    {


        return $this->belongsTo(Order::class);
    }


    static function booted()
    {


        static::addGlobalScope(new StoreScope());
    }
}
