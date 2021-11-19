<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use Exception;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;

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

            Cart::instance('shopping')->destroy();
            session()->forget('coupon');

            return redirect()->route('thankyou')->with('success_message', 'Thank you! Your Payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            return back()->withErrors('Error!' . $e->getMessage());
        }
    }

    private function getNumbers()
    {
        $tax = config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (Cart::instance('shopping')->subTotal() - $discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal + $newTax;

        return collect(['tax' => $tax ,'discount' => $discount , 'newSubtotal' => $newSubtotal , 'newTax' => $newTax , 'newTotal' => $newTotal]);
    }
}
