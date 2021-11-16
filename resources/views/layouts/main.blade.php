<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Ecommerce | @yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">

    @yield('extra-css')
</head>

<body>
    <header class="top-nav">
        <div class="container d-flex flex-md-row flex-column align-items-md-center justify-content-md-between py-md-4">
            <div class="top-nav-logo text-center">
                <a href="" class="text-decoration-none">
                    <h3 class="text-white">Laravel Ecommerce</h3>
                </a>
            </div>
            <div class="top-nav-menu mt-md-0 mt-3">
                <ul class="list-unstyled d-flex justify-content-center ml-md-0 ml-5">
                    <li class="li-top-nav">
                        <a class="text-white text-decoration-none hover-top-nav-link" href="{{route('shop')}}">Shop</a>
                    </li>
                    <li class="li-top-nav">
                        <a class="text-white text-decoration-none hover-top-nav-link" href="">About</a>
                    </li>
                    <li class="li-top-nav">
                        <a class="text-white text-decoration-none hover-top-nav-link" href="">Blog</a>
                    </li>
                    <li class="li-top-nav">
                        <a class="text-white text-decoration-none hover-top-nav-link" href="{{route('cart')}}">
                            Cart
                            @if (Cart::instance('shopping')->count() > 0 )
                            <span class="badge bg-warning rounded-pill ml-1 text-dark">
                                {{Cart::instance('shopping')->count()}}
                            </span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        {{-- end top-nav --}}
    </header>
    {{-- end header --}}

    @yield('content')

    <footer>
        <div class="footer-content container d-flex flex-sm-row flex-column justify-content-sm-between">
            <div class="made-with">Made with <i class="fa fa-heart"></i> by Sithu</div>
            <ul class=" list-unstyled">
                <li>Follow Me:</li>
                <li><a href="#"><i class="fa fa-globe"></i></a></li>
                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                <li><a href="#"><i class="fab fa-github"></i></a></li>
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
            </ul>
        </div> <!-- end footer-content -->
    </footer>

    @yield('extra-js')
</body>

</html>
