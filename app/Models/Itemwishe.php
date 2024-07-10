<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemwishe extends Model
{
    use HasFactory;

    protected $fillable = [


        'wishe_id',
        'product_id'
    ];



    public function wishe()
    {


        return $this->belongsTo(Wishe::class);
    }

    public function product(){

        return $this->belongsTo(Product::class);
    }
}
