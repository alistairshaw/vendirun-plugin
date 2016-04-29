<a href="{{ $viewProductRoute }}"
   data-product-name="{{ $productDisplay['productName'] }}"
   data-product-id="{{ $productDisplay['id'] }}"
   class="btn btn-default js-add-to-cart{{ $cart->countProducts($productDisplay['id']) ? ' hidden' : '' }}"
   data-toggle="tooltip"
   title="{{ trans('vendirun::product.addToCart') }}">
    <i class="fa fa-shopping-cart"></i> {{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::product.addToCart') }}
</a>
<a href="{{ route(LocaleHelper::localePrefix() . 'vendirun.productCart') }}"
   data-product-name="{{ $productDisplay['productName'] }}"
   data-product-id="{{ $productDisplay['id'] }}"
   class="btn btn-default item-in-cart js-item-in-cart{{ $cart->countProducts($productDisplay['id']) ? '' : ' hidden' }}"
   data-toggle="tooltip"
   title="{{ trans('vendirun::product.viewCart') }}">
    {{ $cart->countProducts($productDisplay['id']) }}
</a>