var quantityButtons = function() {
    return {
        init: function() {
            this.setupAddButtons();
            this.setupRemoveButtons();
            return this;
        },

        setupAddButtons: function() {
            $('.js-increase-quantity').on('click', function(event) {
                event.preventDefault();
                var $button = $(this);
                $button.parents('.js-quantity-buttons').find('span').html('<i class="fa fa-spinner fa-spin"></i>');
                var cart = new CartManager();
                cart.addToCart($button.data('id'), 1, function(error, response) {
                    if (error) {
                        $button.parents('.js-quantity-buttons').find('span').html('?');
                        alert(error);
                    }
                    else {
                        $button.parents('.js-quantity-buttons').find('span').html(response.data.ammendedItem.quantity);
                    }
                });
            });
        },

        setupRemoveButtons: function() {
            $('.js-decrease-quantity').on('click', function(event) {
                event.preventDefault();
                var $button = $(this);
                $button.parents('.js-quantity-buttons').find('span').html('<i class="fa fa-spinner fa-spin"></i>');
                var cart = new CartManager();
                cart.removeFromCart($button.data('id'), 1, function(error, response) {
                    if (error) {
                        $button.parents('.js-quantity-buttons').find('span').html('?');
                        alert(error);
                    }
                    else {
                        $button.parents('.js-quantity-buttons').find('span').html(response.data.ammendedItem.quantity);
                    }
                });
            });
        }
    }.init();
};

$(document).ready(function() {
    if ($('.js-quantity-buttons').length > 0) quantityButtons();
});