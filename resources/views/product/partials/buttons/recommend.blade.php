<a href="{{ route(\AlistairShaw\Vendirun\App\Lib\LocaleHelper::getLanguagePrefixForLocale(App::getLocale()) . 'vendirun.productView', ['productId' => $product->id]) }}" data-product-name="{{ $product->product_name }}" data-product-id="{{ $product->id }}" class="btn btn-default btn-recommend js-send-to-friend" data-toggle="tooltip" title="{{ trans('vendirun::forms.sendToFriend') }}">
    <i class="fa fa-user"></i> {{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::forms.sendToFriend') }}
</a>