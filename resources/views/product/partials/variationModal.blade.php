<div class="modal fade" tabindex="-1" role="dialog" id="productVariationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route(LocaleHelper::localePrefix() . 'vendirun.productAddToCartPost') }}" id="productVariationModalForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ trans('vendirun::product.addToCart') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger hidden js-product-variation-modal-error"></div>
                    <div class="product-variation-choice js-modal-variation-choice"></div>
                    <input type="hidden" id="productVariationId" name="productVariationId">
                    <div class="product-variation-price">
                        <div class="add-to-cart">
                            <input type="number" step="1" min="1" name="quantity" id="pvModalQuantity" value="1">
                            <span class="price js-product-price"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary js-add-to-cart-modal-confirm"><i class="fa fa-shopping-cart-plus"></i> {{ trans('vendirun::product.addToCart') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>