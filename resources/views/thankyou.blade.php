@extends('layouts.main')

@section('content')
<div class="main-thank">
    <div class="thank">
        <h1>Thank You for Your Order</h1>
        <span>A confimation email was sent.</span><br>
        <a href="{{route('index')}}" class="btn btn-outline-dark mt-3">Home Page</a>
    </div>
</div>
@endsection
