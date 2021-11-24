<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('cart');
    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $duplicates = Cart::instance('shopping')->search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart')->with('success_message', 'Item is already in your cart');
        }

        Cart::instance('shopping')->add($request->id, $request->name, 1, $request->price)->associate('App\Models\Product');

        return redirect()->route('cart')->with('success_message', 'Item was added to your cart');
    }
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,5',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Quantity must be between 1 and 5!');
            return response()->json(['success' => false], 400);
        }
        if ($request->product_Quantity < $request->quantity) {
            session()->flash('error', 'We currently do not have enough items in stock!');
            return response()->json(['success' => false], 400);
        }

        Cart::instance('shopping')->update($id, $request->quantity);

        session()->flash('success_message', 'Quantity was updated successfully!');
        return response()->json(['success' => true]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        Cart::instance('shopping')->remove($id);

        return back()->with('success_message', 'Item has been removed!');
    }

    /**
    * Save to save for later.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function switchToSaveForLater($id)
    {
        $item = Cart::instance('shopping')->get($id);

        Cart::instance('shopping')->remove($id);

        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart')->with('success_message', 'Item is already save for later.');
        }

        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');

        return back()->with('success_message', 'Item has been saved for later!');
    }
}
