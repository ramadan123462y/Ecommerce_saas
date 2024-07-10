<?php

namespace App\Http\Controllers\FrontEnd;

use App\Events\MakeOrder;
use App\Facades\CartFacade;
use App\Facades\MyFatoorahFacade;
use App\Facades\PaypalFacade;
use App\Facades\ThawaniFacade;
use App\Http\Controllers\Controller;
use App\Models\Adress;
use App\Models\Cart;
use App\Models\Myfatoorahmethodes;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\MakeOrderNotification;
use App\Repository\OrderRepo;
use App\StrategyPattern\Payments\MyfatoorahStrategy;
use App\StrategyPattern\Payments\PaypalStrategy;
use App\StrategyPattern\Payments\StripeStrategy;
use App\StrategyPattern\Payments\ThawaniStrategt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;

use function App\Http\Helpers\store;

class CheckoutController extends Controller
{
    public $OrderRepo;

    public function __construct(OrderRepo $OrderRepo)
    {

        $this->OrderRepo = $OrderRepo;
    }

    public function index()
    {


        $store = store();
        $cart = CartFacade::sum_totalcart();

        if (!isset($cart)) {

            flash()->addError('Please Add To Cart First');
            return redirect('categorie');
        }

        $payment_method =   ($store->paymentmethods)[0];
        $payment_methods_myfatoorah = [];

        if ($payment_method['method'] == 'myfatoorah') {

            $payment_methods_myfatoorah = Myfatoorahmethodes::all();
        }

        return view('Frontend.Templete.checkout', compact('store', 'cart', 'payment_methods_myfatoorah', 'payment_method'));
    }

    public function store_order(Request $request)
    {

        $adress = $this->store_adress($request);
        $cart = CartFacade::sum_totalcart();

        $order = $this->OrderRepo->store($cart, $adress);
        foreach ($cart->cart_items as $item) {

            $order_items = $this->OrderRepo->order_item($order, $item);
        }
        $store = store();
        $payment_method = ($store->paymentmethods)[0];
        $cart->delete();
        // ________________________________________________________________payments___________________
        if ($payment_method['method'] == 'myfatoorah') {

            $MyfatoorahStrategy = new MyfatoorahStrategy();


            return $MyfatoorahStrategy->create_order($payment_method, $order, $request);
        } elseif ($payment_method['method'] == 'paypal') {

            $PaypalStrategy = new PaypalStrategy();


            return $PaypalStrategy->create_order($payment_method, $order);
        } elseif ($payment_method['method'] == 'thawani') {

            $ThawaniStrategt = new ThawaniStrategt();


            return  $ThawaniStrategt->create_order($payment_method, $order);
        } elseif ($payment_method['method'] == 'stripe') {


            $StripeStrategy = new StripeStrategy();


            return  $StripeStrategy->create_order($payment_method, $order);
        }
    }


    public function callback_sucess(Request $request, $id_order)
    {

        $store = store();
        $payment_method = ($store->paymentmethods)[0];

        if ($payment_method['method'] == 'myfatoorah') {

            $MyfatoorahStrategy = new MyfatoorahStrategy();
            sweetalert()->addSuccess('Paid Sucessfully');
            return $MyfatoorahStrategy->callback_sucess($request, $id_order);
        } elseif ($payment_method['method'] == 'paypal') {

            $PaypalStrategy = new PaypalStrategy();
            sweetalert()->addSuccess('Paid Sucessfully');
            return $PaypalStrategy->callback_sucess($request, $id_order);
        } elseif ($payment_method['method'] == 'stripe') {

            $StripeStrategy = new StripeStrategy();
            sweetalert()->addSuccess('Paid Sucessfully');
            return $StripeStrategy->callback_sucess($request, $id_order);
        } elseif ($payment_method['method'] == 'thawani') {

            $ThawaniStrategt = new ThawaniStrategt();
            sweetalert()->addSuccess('Paid Sucessfully');
  
            return $ThawaniStrategt->callback_sucess($request, $id_order);
        }
    }
    public function callback_error(Request $request, $id_order)
    {

        $store = store();
        $payment_method = ($store->paymentmethods)[0];

        if ($payment_method['method'] == 'myfatoorah') {

            $MyfatoorahStrategy = new MyfatoorahStrategy();
            return $MyfatoorahStrategy->callback_error($request, $id_order);
        } elseif ($payment_method['method'] == 'paypal') {

            $PaypalStrategy = new PaypalStrategy();
            return $PaypalStrategy->callback_error($request, $id_order);
        } elseif ($payment_method['method'] == 'thawani') {

            $ThawaniStrategt = new ThawaniStrategt();
            return $ThawaniStrategt->callback_error($request, $id_order);
        } elseif ($payment_method['method'] == 'stripe') {

            $StripeStrategy = new StripeStrategy();
            return $StripeStrategy->callback_error($request, $id_order);
        }
    }

    private function store_adress($request)
    {
        $adress =  Adress::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'country' => $request->country,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'city' => $request->city,
            'zip' => $request->zip,
        ]);
        return $adress;
    }
}
