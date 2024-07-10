<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscrubtion extends Model
{
    use HasFactory;


    protected $fillable = [


        'starts_at',
        'ends_at',
        'plan_id',
  
    ];


    public function stores()
    {


        return $this->hasMany(Store::class);
    }

    public function plan()
    {

        return $this->belongsTo(Plan::class);
    }

    public function transactionsubscriptions()
    {


        return $this->hasMany(Transactionsubscription::class);
    }
}
