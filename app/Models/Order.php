<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function App\Http\Helpers\store_saller;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [

        'cookie_id',
        'adress_id',
        'user_id',
        'store_id',
        'total',
        'status'
    ];

    public function user()
    {


        return $this->belongsTo(User::class);
    }

    public function store()
    {

        return $this->belongsTo(Store::class);
    }

    public function orderitems()
    {


        return  $this->hasMany(OrderItem::class, 'order_id');
    }

    public function adress()
    {

        return $this->belongsTo(Adress::class);
    }

    public function transactions()
    {

        return $this->hasMany(Transaction::class);
    }

    static function booted()
    {

        static::addGlobalScope(new StoreScope());
    }
}
