<a href="{{ $viewProductRoute }}"
   data-product-name="{{ $productDisplay['productName'] }}"
   data-product-id="{{ $productDisplay['id'] }}"
   class="btn btn-default"
   data-toggle="tooltip"
   title="{{ trans('vendirun::product.addToCart') }}">
    <i class="fa fa-shopping-cart"></i> {{ $abbreviatedButtons ? '' : ' ' . trans('vendirun::product.addToCart') }}
</a>