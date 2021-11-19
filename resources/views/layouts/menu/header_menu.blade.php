<ul class="list-unstyled d-flex justify-content-lg-center justify-content-sm-end justify-content-start">
    @foreach($items as $menu_item)
    <li class="li-top-nav">
        <a class="text-white text-decoration-none hover-top-nav-link" href="{{ $menu_item->link() }}">
            {{$menu_item->title }}
            @if ($menu_item->title === 'Cart')
            @if (Cart::instance('shopping')->count() > 0 )
            <span class="badge bg-warning rounded-pill ml-1 text-dark">
                {{Cart::instance('shopping')->count()}}
            </span>
            @endif
            @endif
        </a>
    </li>
    @endforeach
</ul>
