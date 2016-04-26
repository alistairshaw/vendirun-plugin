var shippingCalculator = function(button) {
    return {

        shipping: null,

        $button: null,

        buttonSettings: {},

        init: function($button) {
            this.$button = $button;
            this.startProcess();
            this.updateShipping();
            return this;
        },

        startProcess: function() {
            this.buttonSettings = {
                'html': this.$button.html(),
                'val': this.$button.val(),
                'width': this.$button.width()
            };
            this.$button.attr('disabled', true).addClass('disabled').html('<i class="fa fa-spinner"></i>').val('...').width(this.buttonSettings.width + 'px');
            $('.js-display-shipping').html('<i class="fa fa-spinner fa-spin"></i>');
            $('.js-one-shipping-type').addClass('hidden');
            $('.js-multiple-shipping-types').addClass('hidden');
        },

        endProcess: function() {
            this.$button.attr('disabled', false).removeClass('disabled').html(this.buttonSettings.html).val(this.buttonSettings.val);
        },

        updateShipping: function() {
            var _this = this;
            _this.shipping = $('.js-current-shipping').html();
            var params = {
                countryId: $('#shippingcountryId').val(),
                shippingTypeId: $('#shippingTypeId').val()
            };
            apiManager.makeCall('shipping', 'calculate', params, function(response) {
                _this.endProcess();
                $('.js-display-total').html(response.data.totals.displayTotal);
                $('.js-tax').html(response.data.totals.tax);
                $('.js-display-shipping').html(response.data.totals.displayShipping);
                $('.js-total').html(response.data.totals.total);
                $('.js-total-before-tax').html(response.data.totals.totalBeforeTax);
                $('.js-shipping-before-tax').html(response.data.totals.shippingBeforeTax);

                var $one = $('.js-one-shipping-type');
                var $multiple = $('.js-multiple-shipping-types');
                if (response.data.availableShippingTypes.length <= 1) {
                    $one.removeClass('hidden').html(response.data.shippingTypeId);
                }
                else {
                    var options = '';
                    $.each(response.data.availableShippingTypes, function(index, val) {
                        options += '<option value="' + val + '"';
                        if (val == response.data.shippingTypeId) options += ' selected';
                        options += '>' + val + '</option>';
                    });
                    $multiple.removeClass('hidden').html(options);
                }
            });
        }
    }.init(button);
};