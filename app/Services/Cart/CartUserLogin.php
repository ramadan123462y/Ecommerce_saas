<?php

namespace App\Services\Cart;

use App\Events\MakeCart;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Notifications\CreateCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

use function App\Http\Helpers\store;

class CartUserLogin implements CartInterface
{
    public function cart()
    {


        $cart = Cart::with('cart_items')->User()->first();
        $cartitems = [];
        if (isset($cart)) {


            $cartitems = $cart->cart_items()->selectRaw('(subtotal * quantity) AS total')->addSelect('cart_items.*')->with('product')->get();
        }

        return array('cart' => $cart, 'cartitems' => $cartitems);
    }

    public function updateorcreate($request, $id_product)
    {


        $quantity = 1;
        $active = true;
        if ($request->query('quantity')) {

            $quantity = $request->query('quantity');
            // when false make allowed item updated
            $active = false;
        }

        // $cart_id = $this->generate_cart_id();
        // بناء علي user  or cookie
        $cart = Cart::where('user_id', Auth::guard('web')->user()->id)->first();


        if (!isset($cart)) {


            $cart =  Cart::create([

                'store_id' => store()->id,
                'user_id' => Auth::guard('web')->user()->id

            ]);

            event(new MakeCart($cart));
        }

        $product = Product::findorfail($id_product);

        if (CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first() && $active) {

            notyf()
                ->position('x', 'center')
                ->position('y', 'top')
                ->addError('Product Already In Cart Items');
            return redirect()->back();
        }



        $item = CartItem::updateOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $id_product
            ],
            [

                'subtotal' => $product->selling_price,
                'quantity' => $quantity,
                'cart_id' => $cart->id,
                'product_id' => $id_product,
                'product_name' => $product->name
            ]
        );

        notyf()
            ->position('x', 'center')
            ->position('y', 'top')
            ->addSuccess('Product Aded Or Updated In Cart Items');
    }


    public function update_quintity($id, $quenty)
    {


        $cart_item = CartItem::find($id);
        $price = $cart_item->product->selling_price;
        $cart_item->update([

            'subtotal' => $quenty * $price,
            'quantity' => $quenty,
        ]);

        return response()->json($cart_item->subtotal);
    }

    public function  product_details($product_id)
    {

        $product = Product::findorfail($product_id);
        $cart = [];

        if (Auth::guard('web')->check()) {


            $cart = Cart::where('user_id', Auth::guard('web')->user()->id)->first();
        }



        $cart_item = [];
        if (!empty($cart) && isset($cart)) {

            $cart_item = $cart->cart_items()->where('product_id', $product_id)->first();
        }


        if (!isset($cart_item->quantity)) {

            $cart_item_quantity = 0;
        } else {
            $cart_item_quantity = $cart_item->quantity;
        }

        return array('cart' => $cart, 'cart_item' => $cart_item, 'cart_item_quantity' => $cart_item_quantity, 'product' => $product);
    }


    public function sum_totalcart()
    {

        $cart = Cart::with('cart_items')
            ->selectRaw("(SELECT sum(subtotal) FROM cart_items ) AS subtotal")
            ->addselect('carts.*')
            ->User()->first();
        return $cart;
    }
}
