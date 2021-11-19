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
        <div class="container d-flex flex-lg-row flex-column justify-content-md-between py-md-4">
            <div class="top-nav-logo d-flex flex-lg-row flex-column">
                <a href="{{route('index')}}" class="text-decoration-none">
                    <h3 class="text-white mr-5">Laravel Ecommerce</h3>
                </a>
                {{menu('main', 'layouts.menu.header_menu')}}
            </div>
            {{-- end right menu --}}
            <div class="top-nav-menu mt-md-0 mt-3">
                <ul class="list-unstyled d-flex justify-content-lg-center mt-lg-0 mt-2">
                    @guest
                    <li class="li-top-nav">
                        <a class="text-white text-decoration-none hover-top-nav-link" href="{{route('register')}}"> Sign
                            Up</a>
                    </li>
                    <li class="li-top-nav">
                        <a class="text-white text-decoration-none hover-top-nav-link"
                            href="{{route('login')}}">Login</a>
                    </li>
                    @else
                    <li class="nav-item dropdown li-top-nav">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-decoration-none text-white p-0"
                            href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
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
            {{-- end left menu --}}
        </div>
        {{-- end top-nav --}}
    </header>
    {{-- end header --}}

    @yield('content')

    <footer>
        <div class="footer-content container d-flex flex-sm-row flex-column justify-content-sm-between">
            <div class="made-with w-100">Made with <i class="fa fa-heart"></i> by Sithu</div>
            {{menu('footer','layouts.menu.footer_menu')}}
        </div> <!-- end footer-content -->
    </footer>

    @yield('extra-js')
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>
