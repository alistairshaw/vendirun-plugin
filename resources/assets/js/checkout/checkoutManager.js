var checkoutManager = function () {
    return {

        stripeFormAction: null,

        paymentType: 'stripe',

        init: function () {
            this.initializeStripe();
            this.enableFormValidation();
            this.setupRecalculateShipping();
            this.setupChoosePaymentType();
            this.setupBillingAddress();
            this.setupCompany();

            return this;
        },

        initializeStripe: function () {
            var paymentForm = $('#stripePaymentForm');
            if (paymentForm.length) {
                $('.js-stripe-form').removeClass('hidden');
                $('.js-stripe-option').removeClass('hidden');
                $('#paymentOptionStripe').prop('checked', true);
                $('#paymentOptionPaypal').prop('checked', false);
            }
        },

        enableFormValidation: function () {
            var _this = this;
            var $form = $('.js-checkout-payment-form');
            $form.validate();
            $form.on('submit', function (e) {
                e.preventDefault();
                var $form = $(this);
                $form.find('button[type="submit"]').prop('disabled', true);
                if (_this.paymentType == 'stripe') {
                    _this.validate($form, _this.validateStripe);
                }
                else {
                    _this.validate($form, function ($form) {
                        $form.get(0).submit();
                    });
                }
            });
        },

        validateStripe: function ($form) {
            stripeManager($form);
        },

        validate: function ($form, callback) {
            if ($form.valid()) {
                callback($form);
            }
            else {
                $form.find('button').prop('disabled', false);
            }
        },

        setupRecalculateShipping: function () {
            $('.js-recalculate-shipping-button').on('click', function (e) {
                e.preventDefault();
                shippingCalculator();
            });
        },

        setupChoosePaymentType: function () {
            var _this = this;
            var $form = $('.js-stripe-form');
            $('input[type=radio][name=paymentOption]').on('change', function () {
                _this.paymentType = $(this).val();
                $form.removeClass('hidden');
                if (_this.paymentType !== 'stripe') $form.addClass('hidden');
            });
        },

        setupBillingAddress: function () {
            $('.js-billing-address-form').toggle();
            $('#billingAddressSameAsShipping').on('change', function () {
                $('.js-billing-address-form').toggle();
            });
        },

        setupCompany: function () {
            $('.js-company-name-field').toggle();
            $('#company').on('change', function () {
                $('.js-company-name-field').toggle();
            });
        }
    }.init();
};

$(document).ready(function () {
    if ($('.js-checkout-payment-form').length) checkoutManager();
});