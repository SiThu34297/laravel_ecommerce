<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

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

        $stockLevel = $this->getStock($product->quantity);

        return view('product', compact('product', 'mightAlsoLike', 'stockLevel'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|min:4',
        ]);

        $query = request()->input('query');

        $products = Product::where('name', 'like', "%$query%")
                            ->orWhere('details', 'like', "%$query%")
                            ->orWhere('description', 'like', "%$query%")
                            ->paginate(10);


        return view('searchresult', compact('products'));
    }

    protected function getStock($quantity)
    {
        if ($quantity > setting('site.stock_thershold')) {
            $stockLevel = 'In Stock';
        } elseif ($quantity <= setting('site.stock_thershold') && $quantity > 0) {
            $stockLevel = 'Low Stock';
        } else {
            $stockLevel = "Not Available";
        }

        return $stockLevel;
    }
}
