@extends('layouts.main')

@section('title','Checkout')

@section('extra-css')
<script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
<div class="shop-section">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
    </div>
</div>

<section>
    <div class="container">
        <h1 class="py-3">Checkout</h1>
        @if (session()->has('success_message'))
        <div class="col-md-10 col-8">
            <div class="alert alert-success">
                {{session()->get('success_message')}}
            </div>
        </div>
        @endif
        {{-- success message --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="row py-4">
            <div class="col-md-6">
                <h3>Billing Details</h3>
                <form action="{{route('checkout.store')}}" method="POST" id="payment-form" class="pb-md-0 pb-5">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{old('email')}}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}" required>
                    </div>
                    <div class="mb-3">
                        <label>Address</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{old('address')}}"
                            required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label>City</label>
                                <input type="text" id="city" name="city" class="form-control" value="{{old('city')}}"
                                    required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label>Province</label>
                                <input type="text" id="province" name="province" class="form-control"
                                    value="{{old('province')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label>Postal Code</label>
                                <input type="text" id="postalcode" name="postalcode" class="form-control"
                                    value="{{old('postalcode')}}" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control" value="{{old('phone')}}"
                                    required>
                            </div>
                        </div>
                    </div>
                    {{-- payment --}}
                    <h3 class="py-2">Payment Detail</h3>
                    <div class="mb-3">
                        <label>Name On Card</label>
                        <input type="text" id="name_on_card" name="name_on_card" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Credit or debit Card</label>
                        <div id="card-element">
                            <!-- placeholder for Elements -->
                        </div>
                        <p id="payment-result">
                            <!-- we'll pass the response from the server here -->
                        </p>
                    </div>
                    <button type="submit" id="order-complete" class="btn order-complete-btn">Complete Order</button>
                </form>
            </div>
            {{-- end user information --}}

            <div class="col-md-6">
                <h4>Your Order</h4>
                @foreach (Cart::instance('shopping')->content() as $item)
                <div class="border-bottom py-3">
                    <div class="d-flex flex-md-row flex-column justify-content-between align-items-md-center">
                        <img src="{{asset('images/products/'.$item->model->slug.'.jpg')}}" alt="product-img"
                            width="150">
                        <div class="text-box mt-md-0 mt-3">
                            <h5>{{$item->model->name}}</h5>
                            <span>{{$item->model->details}}</span>
                            <h5>{{$item->model->presentPrice()}}</h5>
                        </div>
                        <div class="mt-md-0 mt-3">
                            <span class="border p-2">{{$item->qty}}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- end order cart --}}
                <div class="border-bottom py-3 d-flex flex-column">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>{{presentPrice(Cart::subTotal())}}</span>
                    </div>
                    {{-- end subtotal --}}
                    @if (session()->get('coupon'))
                    <div class="d-flex justify-content-between mb-2">
                        <span>
                            Discount({{session()->get('coupon')['name']}})
                            <form action="{{route('coupon.destroy')}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-decoration-none text-dark">
                                    Remove
                                </button>
                            </form>
                        </span>
                        <span>-{{presentPrice($discount)}}</span>
                    </div>
                    {{-- end discount coupon --}}
                    <div class="d-flex justify-content-between border-top pt-1 mb-2">
                        <span>New Subtotal</span>
                        <span>{{presentPrice($newSubtotal)}}</span>
                    </div>
                    {{-- end tax --}}
                    @endif
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>{{presentPrice($newTax)}}</span>
                    </div>
                    {{-- end tax --}}
                    <div class="d-flex justify-content-between mb-2 border-top pt-3">
                        <h5>Total</h5>
                        <h5>{{presentPrice($newTotal)}}</h5>
                    </div>
                    {{-- end total --}}
                </div>
                {{-- end total price --}}
                @if (! session()->has('coupon'))
                <div class="col-8">
                    <div class="py-3">
                        <span>Have a code?</span>
                        <div class="border p-3">
                            <div class="input-group">
                                <form action="{{route('coupon.store')}}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="text" name="coupon_code" class="form-control">
                                    <button type="submit" class=" btn btn-outline-dark">Apply</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end code --}}
                @endif
            </div>
            {{-- product detail --}}
        </div>
    </div>
</section>
@endsection

@section('extra-js')
<script>
    var stripe = Stripe('pk_test_51JvgyoHUSWBMUFltuJPeZgBh9FXjTsMCcwtWbvI2h63HR1o71QCBBbBBkN198PjnCY2mFL772aIvFfb559TglLIe00sMaVwa28');
    var elements = stripe.elements();
    var cardElement = elements.create('card',{
        style: {
            base: {
                color: '#000',
                fontWeight: '500',
                fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
                fontSize: '16px',
                fontSmoothing: 'antialiased',
                '::placeholder':{
                    color: '#aab7c4',
                }
            },
            invalid: {
                iconColor: '#fa755a',
                color: '#fa755a',
            },
        },
        hidePostalCode: true,
    });
    cardElement.mount('#card-element');

    var resultContainer = document.getElementById('payment-result');
    cardElement.on('change', function(event) {
        if (event.error) {
            resultContainer.textContent = event.error.message;
        } else {
            resultContainer.textContent = '';
        }
    });

    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();

        //disabel the button after submitting form
        document.getElementById('order-complete').disabled = true;

        var options = {
            name: document.getElementById('name_on_card').value,
            address_line1: document.getElementById('address').value,
            address_city: document.getElementById('city').value,
            address_state: document.getElementById('province').value,
            address_zip: document.getElementById('postalcode').value
        }

        stripe.createToken(cardElement,options).then(function(result) {
            // Handle result.error or result.token
            if(result.error){
                var errorElement = document.getElementById('payment-result');
                errorElement.textContent = result.error.message;
                document.getElementById('order-complete').disabled = false;
            }else{
                stripeTokenHandler(result.token);
            }
        });

        function stripeTokenHandler(token){
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type','hidden');
            hiddenInput.setAttribute('name','stripeToken');
            hiddenInput.setAttribute('value',token.id);
            form.appendChild(hiddenInput);

            //submit the form
            form.submit();
        }
    });
</script>
@endsection
