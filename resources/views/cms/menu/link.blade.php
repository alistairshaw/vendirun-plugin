<li class="{{ (count($item->sub_menu) > 0) ? 'dropdown' : '' }} {{ $activeClass }}">
    <a href="{{ $link }}"{!! count($item->sub_menu) ? ' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"' : '' !!}>
        {{ $item->page_name }}
        @if (count($item->sub_menu) > 0)
            <span class="caret"></span>
        @endif
    </a>
    @if(count($item->sub_menu) > 0)
        <ul class="dropdown-menu" role="menu">
            @include('vendirun::cms.menu.item', ['menu' => $item->sub_menu])
        </ul>
    @endif
</li>