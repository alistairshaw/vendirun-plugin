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
     * Updates anything on the page tagged with the appropriate classes
     * @param data
     */
    var updatePageData = function (data) {
        $('.js-shopping-cart-total').html(data.displayTotals.displayTotal);
        $('.js-shopping-cart-shipping-total').html(data.displayTotals.displayShipping);
    };

    /**
     * Shows the cart popup and then removes it after a short amount of time
     * @param item
     */
    var showCartAddPopup = function(item) {
        if (item === undefined || !item) return;
        var popupContainer = $('.cart-added-popup');
        popupContainer.show();

        var display = item.quantity + ' x ' + item.productName;

        popupContainer.find('.product-name').html(display);
        popupContainer.find('.js-close-cart-added-popup').off('click').on('click', function() {
           popupContainer.hide();
        });

        setTimeout(function() {
            popupContainer.hide();
        }, 8000);
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
            updatePageData(response.data);
            showCartAddPopup(response.data.itemAdded);
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
            updatePageData(response.data);
        }, function (error) {
            callback(error);
        });
    };
}