<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\StoreScope;
use App\Observers\CategorieObserve;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Categorie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'slug',
        'meta_title',
        'meta_descrip',
        'meta_keywords',
        'file_name',
        'store_id',
    ];


    public function store()
    {


        return $this->belongsTo(Store::class);
    }

    public function products()
    {

        return $this->hasMany(Product::class);
    }
    // local scope ___________________Active________________
    public  function scopeActive(EloquentBuilder $builder)
    {
        // select * from where ----- . where('status', 1);
        $builder->where('status', 1);
    }



    protected static function booted()
    {

        static::addGlobalScope(new StoreScope());
        static::observe(new CategorieObserve());
    }
}
