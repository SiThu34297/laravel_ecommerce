@extends('layouts.main')
@section('title','Home')
@section('content')
{{-- banner --}}
<div class="top-nav">
    <div
        class="container d-flex flex-lg-row flex-column align-items-lg-start align-items-md-center justify-content-lg-between py-md-5 pb-5">
        <div class="banner-text text-white w-lg-50">
            <h1 class="display-4">Laravel Ecommerce Demo</h1>
            <p>Include multiple products,categories,a shopping cart and a checkout system with
                Stripe
                integration.
            </p>
            <div class="mt-5">
                <button class="btn btn-outline-light">Blog Post</button>
                <button class="btn btn-outline-light">Github</button>
            </div>
        </div>
        <div class="banner-image mt-lg-0 mt-5">
            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cssgrid_macbook-pro-laravel.png"
                alt="bannerImage" width="85%">
        </div>
    </div>
</div>
{{-- end banner --}}
<section>
    <div class="container">
        <div class="section-text-box pt-5">
            <h1 class="text-center">Laravel Ecommerce</h1>
            <p class="text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloremque impedit
                alias veritatis velit
                repellat, dicta nemo eos reprehenderit, odit inventore repudiandae laudantium consequuntur officia
                ipsam, deleniti ab veniam expedita minima?</p>
        </div>
        <div class="section-button text-center mt-5">
            <div class="btn-group pb-4">
                <button class="btn btn-outline-dark">Feature</button>
                <button class="btn btn-outline-dark">On Sale</button>
            </div>
        </div>
        {{-- end text --}}
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-lg-5 pb-5">
            @foreach ($products as $product)
            <div class="col mt-5 text-center">
                <a href="{{route('shop.show',$product->slug)}}">
                    <img src="{{asset('images/products/'.$product->slug.'.jpg')}}" alt="product-img" width="100%">
                </a>
                <div class="mt-3 text-center">
                    <a href="{{route('shop.show',$product->slug)}}" class="text-decoration-none text-dark">
                        <h4>{{$product->name}}</h4>
                    </a>
                    <span>{{$product->presentPrice()}}</span>
                </div>
            </div>
            @endforeach
        </div>
        {{-- end product box --}}
        <div class="section-button text-center pb-5">
            <a href="{{route('shop')}}" class="btn btn-outline-dark">View More</a>
        </div>
    </div>
</section>
{{-- end product section --}}
<section class="blog-section">
    <div class="container">
        <div class="section-text-box text-center pt-5">
            <h1>From Our Blog</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente, vero aperiam atque dolorum quo
                inventore placeat est non numquam facere asperiores, iste deserunt ullam similique consequuntur
                quaerat porro autem illo.</p>
        </div>
        <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 g-4 py-5">
            <div class="col">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cssgrid_blog1.png" alt="blog-img"
                    width="100%">
                <div class="mt-3">
                    <h1>Blog Post Title</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam a temporibus rem, nulla
                        adipisci at minus inventore recusandae laudantium tempore?</p>
                </div>
            </div>
            <div class="col">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cssgrid_blog2.png" alt="blog-img"
                    width="100%">
                <div class="mt-3">
                    <h1>Blog Post Title</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam a temporibus rem, nulla
                        adipisci at minus inventore recusandae laudantium tempore?</p>
                </div>
            </div>
            <div class="col">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cssgrid_blog3.png" alt="blog-img"
                    width="100%">
                <div class="mt-3">
                    <h1>Blog Post Title</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam a temporibus rem, nulla
                        adipisci at minus inventore recusandae laudantium tempore?</p>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- end blog post section --}}
@endsection
