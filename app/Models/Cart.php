<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Cart extends Model
{
    use HasFactory;


    protected $fillable = [

        'store_id',
        'user_id',
        'cookie_id'
    ];


    public function store()
    {

        return $this->belongsTo(Store::class);
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }




    public function cart_items()
    {

        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function scopeCookie(Builder $builder)
    {
        $builder->where('cookie_id', Cookie::get('card_id'));
    }
    public  function scopeUser(Builder $builder)
    {


        $builder->where('user_id', Auth::guard('web')->user()->id);
    }

    public static function booted()
    {

        static::addGlobalScope(new StoreScope());
    }
}
