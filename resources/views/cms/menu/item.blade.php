@foreach ($menu as $item)
    @if ($item->slug == '/customer/register')
        @include('vendirun::cms.menu.login-button')
    @else
        @include('vendirun::cms.menu.link', ['item' => $item])
    @endif
@endforeach