<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Templete extends Model
{
    use HasFactory;

    protected $fillable = [

        'num_templete',
        'file_name'
    ];

    // public function plans()
    // {


    //     return $this->hasMany(Plan::class);
    // }

    public function stores()
    {


        return $this->hasMany(Store::class, 'templete_id');
    }
}
