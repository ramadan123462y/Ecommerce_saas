<?php

namespace App\Models;


use App\Models\Scopes\StoreScope;
use App\Observers\ProductObserve;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [


        'name',
        'slug',
        'original_price',
        'selling_price',
        'description',
        'small_description',
        'quantity',
        'trending',
        'status',
        'meta_title',
        'meta_keyword',
        'meta_descreption',
        'store_id',
        'categorie_id',
        'file_name'
    ];


    public function store()
    {


        return $this->belongsTo(Store::class);
    }
    public function categorie()
    {


        return $this->belongsTo(Categorie::class);
    }



    public function cart_items()
    {


        return $this->belongsToMany(CartItem::class);
    }

    public function itemwishes()
    {


        return $this->hasMany(Itemwishe::class);
    }

    protected static function booted()
    {

        static::addGlobalScope(new StoreScope());
        static::observe(new ProductObserve());
    }

    public function scopeActive(Builder $builder)
    {

        $builder->where('status', 1);
    }
}
