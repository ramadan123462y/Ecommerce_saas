<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'country',
        'address1',
        'address2',
        'city',
        'zip',
    ];

    public function orders()
    {

        return $this->hasMany(Order::class);
    }
}
