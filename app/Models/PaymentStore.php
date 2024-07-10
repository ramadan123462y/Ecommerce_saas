<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStore extends Model
{
    use HasFactory;
    protected $table = 'payment_store';

    protected $fillable = [

        'paymentmethod_id',
        'store_id',
        'api_key',
        'user_name',
        'password',
        'status',
    ];
}
