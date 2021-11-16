<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagination = 9;
        $categories = Category::all();

        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
            $categories = Category::all();
            $categoryName = optional($categories->where('slug', request()->category)->first())->name;
        } else {
            $products = Product::take(12)->inRandomOrder();
            $categoryName = 'Featured';
        }
        if (request()->price === 'lowToHigh') {
            $products = $products->orderBy('price')->paginate($pagination);
        } elseif (request()->price === 'highToLow') {
            $products = $products->orderBy('price')->paginate($pagination);
        } else {
            $products = $products->paginate($pagination);
        }
        return view('shop', compact('products', 'categories', 'categoryName'));
    }
    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->inRandomOrder()->take(4)->get();
        return view('product', compact('product', 'mightAlsoLike'));
    }
}
