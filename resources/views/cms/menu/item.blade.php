@foreach ($menu as $item)
    <?php //var_dump($item) ?>
    <li class="{{ (count($item->sub_menu) > 0) ? 'dropdown' : '' }}">
        <a href="{{ URL::to($item->slug) }}"{!! count($item->sub_menu) ? ' class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"' : '' !!}>
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
@endforeach