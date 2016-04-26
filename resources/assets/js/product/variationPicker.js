var variationPicker = function($container) {
    return {

        $container: null,

        availableSizes: [],

        availableColors: [],

        availableTypes: [],

        selectedVariationId: null,

        /**
         * @param $container jQuery object
         */
        init: function($container) {
            this.$container = $container;
            if (this.getInitialSettingsFromForm()) {
                this.loadProductVariations();
            }
        },

        /**
         * @return boolean false if this product has no variations
         */
        getInitialSettingsFromForm: function() {
            if ($('#noVariations').val() == 1) {
                this.$container.html('');
                return false;
            }

            this.availableSizes = JSON.parse($('#availableSizes').val());
            this.availableColors = JSON.parse($('#availableColors').val());
            this.availableTypes = JSON.parse($('#availableTypes').val());

            this.selectedVariationId = $('#productVariationId').val();

            return true;
        },

        loadProductVariations: function() {
            apiManager.makeCall('product', 'variations', { productId: $('#productId').val() }, function(response) {
                console.log(response);
            });
        }
    }.init($container)
};