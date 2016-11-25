@if ($currentCategory['slug'] || count($currentCategory['children']))
    <ul class="product-categories">
        @if ($currentCategory['slug'])
            <li class="selected">
                <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productSearch', array_merge(Request::query(), ['page' => 1, 'category' => ltrim($currentCategory['slug'], '/')])) }}">
                    {{ $currentCategory['categoryName'] }}
                </a>
            </li>
        @endif
        @foreach ($currentCategory['children'] as $category)
            <li>
                <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productSearch', array_merge(Request::query(), ['page' => 1, 'category' => ltrim($category['slug'], '/')])) }}">
                    {{ $category['categoryName'] }}
                </a>
            </li>
        @endforeach
        @if (!$currentCategory['parent'] && $currentCategory['slug'] !== '')
            <li class="back">
                <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productSearch', array_merge(Request::query(), ['page' => 1, 'category' => ''])) }}">
                    <i class="fa fa-angle-double-left"></i>
                    {{ trans('vendirun::product.browseProducts') }}
                </a>
            </li>
        @elseif ($currentCategory['parent'])
            <li class="back">
                <a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productSearch', array_merge(Request::query(), ['page' => 1, 'category' => ltrim($currentCategory['parent'], '/')])) }}">
                    <i class="fa fa-angle-double-left"></i>
                    {{ trans('vendirun::product.backTo') . ' ' . $currentCategory['parentName'] }}
                </a>
            </li>
        @endif
    </ul>
@endif