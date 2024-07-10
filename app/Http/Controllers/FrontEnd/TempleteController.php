<?php

namespace App\Http\Controllers\FrontEnd;

use App\Facades\CartFacade;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Store;
use function App\Http\Helpers\store;

use Illuminate\Support\Facades\Cookie;

class TempleteController extends Controller
{
    public function index()
    {

        $store = store();
        return view('Frontend.Templete.index', compact('store'));
    }

    public function product_details($product_id)
    {

        $store = store();
        $cart_facade = CartFacade::product_details($product_id);
        $cart = $cart_facade['cart'];
        $cart_item = $cart_facade['cart_item'];
        $cart_item_quantity = $cart_facade['cart_item_quantity'];
        $product = $cart_facade['product'];


        return view('Frontend.Templete.productdetails', compact('store', 'product', 'cart', 'cart_item_quantity'));
    }
}
