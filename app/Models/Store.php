<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [

        'title',
        'sub_domain',
        'logo',
        'plan_id',
        'subscrubtion_id',
        'templete_id',
        'active'

    ];


    public function categories()
    {


        return $this->hasMany(Store::class);
    }

    public function products()
    {


        return $this->hasMany(Product::class);
    }

    public function saller()
    {

        return $this->hasOne(Saller::class);
    }

    public function carts()
    {

        return $this->hasMany(Cart::class);
    }

    public function orders()
    {


        return $this->hasMany(Order::class);
    }



    public function plan()
    {


        return $this->belongsTo(Plan::class);
    }

    public function subscrubtion()
    {

        return $this->belongsTo(Subscrubtion::class);
    }

    public function templete()
    {

        return $this->belongsTo(Templete::class);
    }

    public function users()
    {


        return $this->belongsToMany(User::class, 'store_user', 'store_id', 'user_id');
    }

    public function wishes()
    {


        return $this->hasMany(Wishe::class);
    }
    // ______________________________local global


    public function scopeCurrent(Builder $builder)
    {

        $builder->where('id', App::make('store')->id);
    }

    public function paymentmethods()
    {


        return $this->belongsToMany(PaymentMethod::class, 'payment_store', 'store_id', 'paymentmethod_id')->withPivot(
            'api_key',
            'user_name',
            'password',
            'status',
        );
    }

    public function transactions()
    {

        return $this->hasMany(Transaction::class);
    }

    public function transactionsubscriptions(){

        return $this->hasMany(Transactionsubscription::class);
    }



}
