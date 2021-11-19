<ul class="list-unstyled w-75 mt-sm-0 mt-4">
    @foreach($items as $menu_item)
    @if ($menu_item->title === "Follow Me")
    <li>{{$menu_item->title}} : </li>
    @endif
    <li>
        <a href="{{ $menu_item->link() }}">
            <i class="{{$menu_item->title}}"></i>
        </a>
    </li>
    @endforeach
</ul>
