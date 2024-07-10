<?php

namespace App\Http\Controllers\FrontEnd;

use App\Facades\CartFacade;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

use function App\Http\Helpers\store;


class CartController extends Controller
{

    public  function index()
    {

        $store = store();
        $cartfacade = CartFacade::cart();
        $cart = $cartfacade['cart'];
        $cartitems = $cartfacade['cartitems'];

        return view('Frontend.Templete.cart', compact('store', 'cartitems'));
    }

    public function store(Request $request, $id_product)
    {

        CartFacade::updateorcreate($request, $id_product);
        return redirect()->back();
    }

    public function increase_item($id, $quenty)
    {

        return CartFacade::update_quintity($id, $quenty);
    }
}
