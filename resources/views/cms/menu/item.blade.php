@foreach ($menu as $item)
    @include('vendirun::cms.menu.link', ['item' => $item])
@endforeach