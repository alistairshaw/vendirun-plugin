@if (count($breadcrumbs))
    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            <li><a href="/{{ $breadcrumb['slug'] }}">{{ $breadcrumb['title'] }}</a></li>
        @endforeach
    </ul>
@endif