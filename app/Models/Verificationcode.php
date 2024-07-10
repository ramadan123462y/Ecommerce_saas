<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verificationcode extends Model
{
    use HasFactory;

    protected $fillable = [

        'admin_id',
        'otp',
        'expire_at',
    ];

    public function admin(){


        return $this->belongsTo(Admin::class);
    }
}
