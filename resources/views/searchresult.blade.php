@extends('layouts.main')
@section('title','Search')
@section('content')
<div class="shop-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Search</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4">
                <div class="search-bar mt-2">
                    <form action="{{route('search')}}" method="GET">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" name="query" class="form-control" placeholder="Search for product"
                                value="{{request()->input('query')}}">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- end shop section --}}
<section>
    <div class="container py-5">
        <div class="row">
            @if (session()->has('success_message'))
            <div class="col-md-10 col-8">
                <div class="alert alert-success">
                    {{session()->get('success_message')}}
                </div>
            </div>
            @endif
            {{-- end success message --}}
            @if (count($errors) > 0)
            <div class="col-md-10 col-8">
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{$error}}</div>
                @endforeach
            </div>
            @endif
            {{-- end error message --}}
            <div class="col-12">
                <h1>Search Result</h1>
                <span>{{$products->count()}} result(s) for {{request()->input('query')}}</span>
            </div>
            <div class="col-12">
                <table class="table table-striped table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Description</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <th>
                                <a href="{{route('shop.show',$product->slug)}}"
                                    class="text-decoration-none">{{$product->name}}</a>
                            </th>
                            <td>{{$product->details}}</td>
                            <td>{!! Str::limit($product->description,90) !!}</td>
                            <td>{{$product->presentPrice()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$products->appends(request()->input())->links()}}
            </div>
        </div>
    </div>
</section>
{{-- end product section --}}
@endsection
