<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


use function App\Http\Helpers\store;

class FilterContoller extends Controller
{
    public function show_products(Request $request, $id_categorei = false)
    {
        $store = store();
        $categories = Categorie::query();
        $products = [];
        if ($request->product_name) {

            $products = Product::where('name', 'like', "%$request->product_name%")->get();
        }else{


            if ($id_categorei) {
                $categories->where('id', $id_categorei);
            }


            $categories = $categories
                ->with('products')
                ->selectRaw("(SELECT count(*) FROM products WHERE products.categorie_id = categories.id) AS product_count")
                ->selectRaw("(SELECT count(*) FROM products ) AS counts")
                ->addselect('categories.*')
                ->get();

        }


        return  view('Frontend.Templete.filters', compact('store', 'categories', 'products'));
    }
}
