<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wishe extends Model
{
    use HasFactory;

    protected $fillable = [


        'store_id',
        'user_id'
    ];

    public function store()
    {


        return $this->belongsTo(Store::class);
    }

    public function user()
    {


        return $this->belongsTo(User::class);
    }

    public function itemwishes()
    {

        return $this->hasMany(Itemwishe::class);
    }

    public function scopeCurrentuser(Builder $builder)
    {

        $builder->where('user_id', Auth::guard('web')->user()->id);
    }

    public static function booted()
    {

        static::addGlobalScope(new StoreScope());
    }
}
