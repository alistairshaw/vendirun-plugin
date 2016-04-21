var shippingCalculator = function() {
    return {

        shipping: null,

        init: function() {
            this.getShipping();
            return this;
        },

        getShipping: function() {
            var _this = this;
            _this.shipping = $('.js-current-shipping').html();
            console.log("Making Call");
            apiManager.makeCall('shipping', 'calculate');
        }
    }.init();
};