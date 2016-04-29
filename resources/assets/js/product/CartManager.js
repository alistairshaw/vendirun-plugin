function CartManager () {

    var cart = {
        items: null
    };

    /**
     * Find add to cart buttons and hide/show them
     */
    var hideAddToCartButtons = function() {
        $('.js-add-to-cart').removeClass('hidden').each(function() {
            var $button = $(this);
            $.each(cart.items, function(index, cartItem) {
                if (cartItem.product.id == $button.data('product-id')) $button.addClass('hidden');
            });
        });
    };

    /**
     * Find product count buttons and hide/show them
     */
    var showProductCountButtons = function() {
        $('.js-item-in-cart').addClass('hidden').each(function() {
            var $button = $(this);
            $.each(cart.items, function(index, cartItem) {
                if (cartItem.product.id == $button.data('product-id')) $button.removeClass('hidden').html(cartItem.quantity);
            });
        });
    };

    /**
     * Remove any instances of this product that are currently on the board
     * @param productVariationId
     */
    var triggerProductRemoval = function(productVariationId) {
        $('.js-cart-item').each(function() {
            if ($(this).data('id') == productVariationId) $(this).remove();
        });
    };

    /**
     * Find the item we just updated
     * @param productVariationId
     * @param items
     */
    var findItem = function(productVariationId, items) {
        var finalItem = null;
        $.each(items, function(index, cartItem) {
            if (cartItem.productVariationId == productVariationId) finalItem = cartItem;
        });
        if (finalItem === null) {
            triggerProductRemoval(productVariationId);
        }
        return finalItem;
    };

    /**
     * Add an item to the cart
     * @param productVariationId
     * @param quantity
     * @param callback
     */
    this.addToCart = function (productVariationId, quantity, callback) {
        apiManager.makeCall('cart', 'add', {productVariationId: productVariationId, quantity: quantity}, function (response) {
            $('.js-total-cart-products').html(response.data.itemCount);
            cart.items = response.data.items;
            response.data.ammendedItem = findItem(productVariationId, cart.items);
            callback(null, response);
            hideAddToCartButtons();
            showProductCountButtons();
        }, function (error) {
            callback(error);
        });
    };

    /**
     * @param productVariationId
     * @param quantity
     * @param callback
     */
    this.removeFromCart = function(productVariationId, quantity, callback) {
        apiManager.makeCall('cart', 'remove', {productVariationId: productVariationId, quantity: quantity}, function (response) {
            $('.js-total-cart-products').html(response.data.itemCount);
            cart.items = response.data.items;
            response.data.ammendedItem = findItem(productVariationId, cart.items);
            callback(null, response);
            hideAddToCartButtons();
            showProductCountButtons();
        }, function (error) {
            callback(error);
        });
    }
}