<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myfatoorahmethodes extends Model
{
    use HasFactory;

    protected $fillable = [
        'PaymentMethodId',
        'PaymentMethodAr',
        'PaymentMethodEn',
        'ImageUrl',
    ];
}
