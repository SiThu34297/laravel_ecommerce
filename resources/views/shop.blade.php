@extends('layouts.main')
@section('title','Shop')
@section('content')
<div class="shop-section">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shop</li>
            </ol>
        </nav>
    </div>
</div>
{{-- end top nav --}}
<section class="container py-3">
    <div class="row">
        <div class="col-sm-3">
            <div class="categories">
                <h3>By Category</h3>
                <div class="category-list mt-4">
                    @foreach ($categories as $cat)
                    <a href="{{route('shop',['category'=>$cat->slug])}}"
                        class="text-decoration-none {{request()->category === $cat->slug ?'text-primary' : 'text-dark'}}">
                        <h5>{{$cat->name}}</h5>
                    </a>
                    @endforeach
                </div>
            </div>
            {{-- end categorise --}}
            <div class="price my-4">
                <h3>By Price</h3>
                <div class="price-list mt-4">
                    <a href="{{route('shop',['category'=>request()->category,'price'=>'lowToHigh'])}}"
                        class="text-decoration-none text-dark">
                        <h5>Low to high</h5>
                    </a>
                    <a href="{{route('shop',['category'=>request()->category,'price'=>'highToLow'])}}"
                        class="text-decoration-none text-dark">
                        <h5>High to low</h5>
                    </a>
                </div>
            </div>
            {{-- end categories price --}}
        </div>
        <div class="col-sm-9">
            <h1 class="fw-bold">{{$categoryName}}</h1>
            <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 mb-4">
                @forelse ($products as $product)
                <div class="col mt-5 text-center">
                    <a href="{{route('shop.show',$product->slug)}}">
                        <img src="{{asset('storage/'.$product->image)}}" alt="product-img" width="100%">
                    </a>
                    <div class="mt-3 text-center">
                        <a href="{{route('shop.show',$product->slug)}}" class="text-decoration-none text-dark">
                            <h4>{{$product->name}}</h4>
                        </a>
                        <span>{{$product->presentPrice()}}</span>
                    </div>
                </div>
                @empty
                <h5 class="px-3 mt-4">No items found</h5>
                @endforelse
            </div>
            {{$products->appends(request()->input())->links()}}
        </div>
    </div>
</section>
@endsection
