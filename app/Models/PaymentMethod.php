<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;




    protected $fillable = [

        'method', 'status'
    ];


    public function stores()
    {

        return $this->belongsToMany(Store::class, 'payment_store', 'paymentmethod_id', 'store_id')->withPivot(
            'api_key',
            'user_name',
            'password',
            'status',
        );
    }
}
