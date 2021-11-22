<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderShipped;
use App\Models\Order;
use App\Models\OrderProduct;
use Exception;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if (auth()->user() && request()->is('guest-checkout')) {
            return redirect()->route('checkout');
        }

        return view(
            'checkout',
            ['discount' => $this->getNumbers()->get('discount') ,
            'newSubtotal' => $this->getNumbers()->get('newSubtotal') ,
            'newTax' => $this->getNumbers()->get('newTax') ,
            'newTotal' => $this->getNumbers()->get('newTotal')
            ]
        );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(CheckoutRequest $request)
    {
        $contents = Cart::instance('shopping')->content()->map(function ($item) {
            return $item->model->slug. ',' . $item->qty;
        })->values()->toJson();

        try {
            $charges = Stripe::charges()->create([
                'amount' => $this->getNumbers()->get('newTotal') / 100,
                'currency' => 'CAD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    'contents' => $contents,
                    'quantity' => Cart::instance('shopping')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson()
                ],
            ]);

            //INSERT INTO orders table
            $order = $this->addToOrderTable($request, null);

            //send mail
            Mail::send(new OrderShipped($order));

            //SUCCESSFUL
            Cart::instance('shopping')->destroy();
            session()->forget('coupon');

            return redirect()->route('thankyou')->with('success_message', 'Thank you! Your Payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            $this->addToOrderTable($request, $e->getMessage());
            return back()->withErrors('Error!' . $e->getMessage());
        }
    }

    private function getNumbers()
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $discount_code = session()->get('coupon')['name'] ?? null;
        $newSubtotal = (Cart::instance('shopping')->subTotal() - $discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal + $newTax;

        return collect(['tax' => $tax ,'discount' => $discount , 'newSubtotal' => $newSubtotal , 'newTax' => $newTax , 'newTotal' => $newTotal ,'discount_code' => $discount_code]);
    }

    protected function addToOrderTable($request, $error)
    {
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'billing_discount' => $this->getNumbers()->get('discount'),
            'billing_discount_code' =>$this->getNumbers()->get('discount_code'),
            'billing_subtotal' => $this->getNumbers()->get('newSubtotal'),
            'billing_tax' => $this->getNumbers()->get('newTax'),
            'billing_total' =>$this->getNumbers()->get('newTotal'),
            'error' => $error,
        ]);

        //insert into order_product table
        foreach (Cart::instance('shopping')->content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->model->id,
                'quantity' => $item->qty,
            ]);
        }

        return $order;
    }
}
