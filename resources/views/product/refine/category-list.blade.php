<ul class="product-categories">
    @foreach ($categories as $category)
        <li>
            <a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productSearch',[$category->slug]) }}">{{ $category->category_name }}</a>
        </li>
    @endforeach
</ul>