@extends('layouts.main')

@section('content')
<div class="shop-section">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cart</li>
            </ol>
        </nav>
    </div>
</div>

<section>
    <div class="container py-5">
        @if (session()->has('success_message'))
        <div class="col-md-10 col-8">
            <div class="alert alert-success">
                {{session()->get('success_message')}}
            </div>
        </div>
        @endif
        {{-- end success message --}}
        @if (session()->has('error'))
        <div class="col-md-10 col-8">
            <div class="alert alert-danger">
                {{session()->get('error')}}
            </div>
        </div>
        @endif
        {{-- end error message --}}
        @if (Cart::instance('shopping')->count() > 0)
        <div class="row px-3">
            <div class="col-md-10 col-8">
                <h3 class="border-bottom pb-4">{{Cart::instance('shopping')->count()}} item(s) in Shopping Cart</h3>
            </div>
            @foreach (Cart::instance('shopping')->content() as $item)
            <div class="col-md-10 col-8 offset-md-0 offset-1 border-bottom py-3">
                <div class="d-flex flex-md-row flex-column justify-content-between align-items-md-center">
                    <a href="{{route('shop.show',$item->model->slug)}}" class="w-25">
                        <img src="{{asset('images/products/'.$item->model->slug.'.jpg')}}" alt="product-img"
                            width="100%">
                    </a>
                    <div class="text-box mt-md-0 mt-3">
                        <a href="{{route('shop.show',$item->model->slug)}}" class="text-decoration-none text-dark">
                            <h5>{{$item->model->name}}</h5>
                        </a>
                        <span>{{$item->model->details}}</span>
                    </div>
                    <div class="option-btn mt-md-0 mt-3">
                        <form action="{{route('cart.destroy',$item->rowId)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove">
                                Remove
                            </button>
                        </form>
                        {{-- end remove post method --}}
                        <form action="{{route('cart.switchToSaveForLater',$item->rowId)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn-remove">
                                Save for later
                            </button>
                        </form>
                        {{-- end save for later post method --}}
                    </div>
                    <div class="total-input mt-md-0 mt-3">
                        <select data-id="{{$item->rowId}}" class="form-control quantity">
                            @for ($i = 1 ; $i <= 5 ; $i++) <option {{$item->qty == $i ? "selected" : ''}}>{{$i}}
                                </option>
                                @endfor
                        </select>
                    </div>
                    <div class="price mt-md-0 mt-3">
                        <h5>{{presentPrice($item->subtotal())}}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{-- end cart product --}}
        <div class="row px-3 my-4">
            <div class="col-md-4 cart-total py-2">
                <p>Shopping is free because we're awaesome like that.Also because that's additional stuff I don't feel
                    like figuring out.</p>
            </div>
            <div class="col-md-4 cart-total py-2 text-md-right">
                <span>Subtotal <span class="ml-3">{{presentPrice(Cart::subtotal())}}</span> </span><br>
                <span>Tax(13%) <span class="ml-3">{{presentPrice(Cart::tax())}}</span></span><br>
                <strong>Total <span class="ml-3">{{presentPrice(Cart::total())}}</span></strong>
            </div>
        </div>
        {{-- end total price --}}
        <div class="row">
            <div class="col-md-4">
                <a href="{{route('shop')}}" class="btn btn-outline-dark">Continue Shopping</a>
            </div>
            <div class="col-md-4 text-lg-right mt-md-0 mt-3">
                <a href="{{route('checkout')}}" class="btn btn-teal">Proceed to Checkout</a>
            </div>
        </div>
        {{-- end button --}}
        @else
        <div class="row mt-4 px-3">
            <div class="col-12">
                <h3>No item in the shopping cart.</h3>
            </div>
            <div class="col-12">
                <a href="{{route('shop')}}" class="btn btn-outline-dark">Continue Shopping</a>
            </div>
        </div>
        @endif

        {{-- save for later --}}
        @if (Cart::instance('saveForLater')->count() > 0)
        <div class="row px-3 mt-5">
            <div class="col-md-10 col-8">
                <h3 class="border-bottom pb-4"> {{Cart::instance('saveForLater')->count()}} item(s) Save For Later</h3>
            </div>
            @foreach (Cart::instance('saveForLater')->content() as $item)
            <div class="col-md-10 col-8 offset-md-0 offset-1 border-bottom py-3">
                <div class="d-flex flex-md-row flex-column justify-content-between align-items-md-center">
                    <a href="{{route('shop.show',$item->model->slug)}}" class="w-25">
                        <img src="{{asset('images/products/'.$item->model->slug.'.jpg')}}" alt="product-img"
                            width="100%">
                    </a>
                    <div class="text-box mt-md-0 mt-3">
                        <a href="{{route('shop.show',$item->model->slug)}}" class="text-decoration-none text-dark">
                            <h5>{{$item->model->name}}</h5>
                        </a>
                        <span>{{$item->model->details}}</span>
                    </div>
                    <div class="option-btn mt-md-0 mt-3">
                        <form action="{{route('saveforlater.destroy',$item->rowId)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove">
                                Remove
                            </button>
                        </form>
                        {{-- end remove post method --}}
                        <form action="{{route('saveforlater.switchToCart',$item->rowId)}}" method="POST">
                            @csrf
                            <button type="submit" class="btn-remove">
                                Move To Cart
                            </button>
                        </form>
                        {{-- end save for later post method --}}
                    </div>
                    <div class="price mt-md-0 mt-3">
                        <h5>{{$item->model->presentPrice()}}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="row mt-5">
            <div class="col-md-10 col-8">
                <h4 class="px-3">You have no item save for later.</h4>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@section('extra-js')
<script src="{{asset('js/app.js')}}"></script>
<script>
    function hello(){
            const className = document.querySelectorAll('.quantity');
            Array.from(className).forEach(function(element){
                element.addEventListener('change',function(){
                    id = element.getAttribute('data-id');
                    axios.patch(`/cart/${id}`, {
                        quantity: this.value
                    })
                    .then(function (response) {
                        // console.log(response);
                        window.location.href = "{{route('cart')}}"
                    })
                    .catch(function (error) {
                        console.log(error);
                        window.location.href = "{{route('cart')}}"
                    });
                })
            });
        }
        hello();
</script>
@endsection
