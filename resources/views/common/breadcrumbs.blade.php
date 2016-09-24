@if (count($breadcrumbs))
    <div class="vendirun-breadcrumbs">
        <ul class="breadcrumb">
            <?php $counter = 0; ?>
            @foreach ($breadcrumbs as $breadcrumb)
                <?php $counter++ ?>
                <li>
                    @if ($breadcrumb['slug'] && $counter < count($breadcrumbs))
                        <a href="{{ ($breadcrumb['slug'] == '/' ? '' : '/') . $breadcrumb['slug'] }}">
                            @endif
                            {{ $breadcrumb['title'] }}
                            @if ($breadcrumb['slug'])
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif