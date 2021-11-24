@extends('layouts.main')
@section('title',$product->name)
@section('content')
<div class="shop-section">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('shop')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>
        </nav>
    </div>
</div>
{{-- end shop section --}}
<section>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6 offset-lg-1 col-sm-10">
                <div class="border border-2 p-5 text-center">
                    <img id="current-image" src="{{productImage($product->image)}}" alt="product-img" width="50%"
                        class="active">
                </div>
                <div class="row mt-2">
                    <div class="col-lg-3 col-4 mt-2">
                        <div class="product-gallery">
                            <img src="{{productImage($product->image)}}" alt="product-img" class="clickImage">
                        </div>
                    </div>
                    @if ($product->images)
                    @foreach (json_decode($product->images) as $image )
                    <div class="col-lg-3 col-4 mt-2">
                        <div class="product-gallery">
                            <img src="{{asset('storage/'.$image)}}" alt="productGallary" class="clickImage">
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-sm-10 mt-4 mt-lg-0">
                <h1 class="mb-3">{{$product->name}}</h1>
                <h4 class="mb-3">{{$product->details}}</h4>
                <span
                    class="badge {{$stockLevel === 'In Stock' ? 'bg-success' : ''}} {{$stockLevel === 'Low Stock' ? 'bg-warning' : ''}} {{$stockLevel === 'Not Available' ? 'bg-danger' : ''}} text-white mb-3">{{$stockLevel}}</span>
                <h1 class="mb-3">{{$product->presentPrice()}}</h1>
                <p class="mb-3">{!! $product->description !!}</p>
                @if ($product->quantity > 0)
                <form action="{{route('cart.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$product->id}}">
                    <input type="hidden" name="name" value="{{$product->name}}">
                    <input type="hidden" name="price" value="{{$product->price}}">
                    <button type="submit" class="btn btn-outline-dark">Add To Cart</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</section>
{{-- end product section --}}
<section class="py-4 product-section-like">
    <div class="container">
        <h3>You may also like.....</h3>
        <div class="row row-cols-sm-4 row-cols-2">
            @foreach ($mightAlsoLike as $product)
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
            @endforeach
        </div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    const clickImage = document.querySelectorAll('.clickImage');
    const currentImage = document.getElementById('current-image');
    clickImage.forEach(element => {
        element.addEventListener('click',function(e){
            // currentImage.src = e.target.src;
            currentImage.classList.remove('active');
            currentImage.addEventListener('transitionend',()=>{
                currentImage.src = e.target.src;
                currentImage.classList.add('active');
            })
        })
    });
</script>
@endsection
