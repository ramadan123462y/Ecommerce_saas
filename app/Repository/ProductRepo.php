<?php

namespace App\Repository;

use App\Models\Product;
use Illuminate\Support\Str;

use function App\Http\Helpers\store_saller;

class ProductRepo
{


    public function find($id)
    {


        return  Product::findorfail($id);
    }

    public function get()
    {


        return Product::get();
    }


    public function update($request, $status, $file)
    {



        Product::findorfail($request->id)->update([

            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'original_price' => $request->original_price,
            'selling_price' => $request->selling_price,
            'description' => $request->description,
            'small_description' => $request->small_description,
            'quantity' => $request->quantity,
            'status' => $status,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_descreption' => $request->meta_descreption,
            'categorie_id' => $request->categorie_id,
            'file_name' => $file

        ]);
    }

    public function store($request, $status, $file)
    {


        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'original_price' => $request->original_price,
            'selling_price' => $request->selling_price,
            'description' => $request->description,
            'small_description' => $request->small_description,
            'quantity' => $request->quantity,
            'status' => $status,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_descreption' => $request->meta_descreption,
            'store_id' => store_saller()->id,
            'categorie_id' => $request->categorie_id,
            'file_name' => $file
        ]);
    }

    public function delete($id)
    {

        Product::findorfail($id)->delete();
    }
}
