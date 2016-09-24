var productView = function () {
    return {
        init: function () {
            this.setupVariationPicker();
            this.setupAddToCart();
        },

        setupVariationPicker: function () {
            var variationChoice = $('.js-variation-choice');
            if (variationChoice.length) variationPicker(variationChoice);
        },

        setupAddToCart: function () {
            var cart = new CartManager();
            $('.js-standard-add-to-cart').on('click', function () {
                var $button = $(this);
                var originalText = $button.html();
                $button.html('<i class="fa fa-spinner fa-spin"></i>').attr('disabled', true);
                var productVariationId = $('#productVariationId').val();
                var quantity = $('#quantity').val();
                cart.addToCart(productVariationId, quantity, function () {
                    $button.html(originalText).attr('disabled', false);
                });
            });
        }
    }.init();
};

$(document).ready(function () {
    if ($('.js-product-view').length > 0) productView();
});