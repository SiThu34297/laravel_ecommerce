<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLaterController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::instance('saveForLater')->remove($id);

        return back()->with('success_message', 'Item has been removed!');
    }


    /**
    * Save to save for later.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function switchToCart($id)
    {
        $item = Cart::instance('saveForLater')->get($id);

        Cart::instance('saveForLater')->remove($id);

        $duplicates = Cart::instance('shopping')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart')->with('success_message', 'Item is already in your cart');
        }

        Cart::instance('shopping')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Product');

        return back()->with('success_message', 'Item has been moved to cart!');
    }
}
