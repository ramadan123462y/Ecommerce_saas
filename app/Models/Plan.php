<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [


        'price',
        'duration',
        'templete_id',
    ];


    public  function stores()
    {


        return $this->hasMany(Store::class);
    }

    // public function templete()
    // {

    //     return $this->belongsTo(Templete::class);
    // }

    public function subscrubtions()
    {

        return $this->hasMany(Subscrubtion::class);
    }
}
