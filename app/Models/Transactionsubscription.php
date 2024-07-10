<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactionsubscription extends Model
{
    use HasFactory;
    protected $fillable = [


        'store_id',
        'subscrubtion_id',
        'payment_id',
        'status_pay'
    ];

    public function subscrubtion()
    {


        $this->belongsTo(Subscrubtion::class);
    }

    public function store()
    {

        return $this->belongsTo(Store::class);
    }
}
