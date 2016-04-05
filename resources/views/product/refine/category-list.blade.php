<ul class="product-categories">
    @if ($currentCategory->slug)
        <li class="selected">
            <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productSearch',[$currentCategory->slug]) }}">{{ $currentCategory->category_name }}</a>
        </li>
    @endif
    @foreach ($currentCategory->sub_categories as $category)
        <li>
            <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productSearch',[$category->slug]) }}">{{ $category->category_name }}</a>
        </li>
    @endforeach
    @if (!$currentCategory->parent && $currentCategory->slug !== '')
        <li class="back">
            <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productSearch',['']) }}"><i class="fa fa-angle-double-left"></i> {{ trans('vendirun::product.browseProducts') }}</a>
        </li>
    @elseif ($currentCategory->parent)
        <li class="back">
            <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productSearch',[$currentCategory->parent->slug]) }}"><i class="fa fa-angle-double-left"></i> {{ trans('vendirun::product.backTo') . ' ' . $currentCategory->parent->category_name }}</a>
        </li>
    @endif
</ul>