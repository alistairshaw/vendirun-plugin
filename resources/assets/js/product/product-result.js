var productResultManager = function() {
    return {
        init: function() {
            this.setupAddToCartButtons();
            return this;
        },
        
        setupAddToCartButtons: function() {
            var _this = this;
            $('.js-product-result').find('.js-add-to-cart').on('click', function(event) {
                var $variationModal = $('#productVariationModal');
                if ($variationModal.length == 0) return true;
                event.preventDefault();

                var $modalError = $('.js-product-variation-modal-error');
                $modalError.addClass('hidden');
                var $addToCartConfirm = $('.js-add-to-cart-modal-confirm');
                var originalAddToCartText = $addToCartConfirm.html();
                $variationModal.modal('show');
                $addToCartConfirm.html('<i class="fa fa-spinner fa-spin"></i>').addClass('disabled').prop('disabled', true);
                variationPicker($('.js-modal-variation-choice'), $(this).data('product-id'), function() {
                    $addToCartConfirm.html(originalAddToCartText).removeClass('disabled').prop('disabled', false).on('click', function(event) {
                        event.preventDefault();
                        $addToCartConfirm.css('width', $addToCartConfirm.outerWidth()).html('<i class="fa fa-spinner fa-spin"></i>').addClass('disabled').prop('disabled', true);
                        _this.addItemToCart(function() {
                            $addToCartConfirm.html(originalAddToCartText).removeClass('disabled').prop('disabled', false);
                        });
                    });
                });
            });
        },

        /**
         * Use the CartManager to add the item to the cart
         * @param callback
         */
        addItemToCart: function(callback) {
            var cartManager = new CartManager();
            var $variationModal = $('#productVariationModal');
            var $modalError = $('.js-product-variation-modal-error');
            cartManager.addToCart($('#productVariationId').val(), $('#pvModalQuantity').val(), function(error, response) {
                if (error) {
                    $modalError.removeClass('hidden').html(error);
                }
                else {
                    $variationModal.modal('hide');
                }

                callback();
            });
        }
    }.init();
};

$(document).ready(function() {
     if ($('.js-product-result').length) productResultManager();
});