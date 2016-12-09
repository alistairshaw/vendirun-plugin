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
                $('.js-paypal-logo').addClass('hidden');
            }
        },

        enableFormValidation: function () {
            var _this = this;
            var $form = $('.js-checkout-payment-form');

            if ($form.hasClass('js-do-not-validate')) {
                $form.on('submit', function(e) {
                    if (_this.paymentType == 'stripe') {
                        e.preventDefault();
                        _this.validateStripe($form);
                    }
                });
                return true;
            }

            $form.validate();
            $('#emailAddress').rules('add', {required: true, email: true});
            $('#fullName').rules('add', {required: true});
            if ($('#shippingaddress1').length) {
                $('#shippingaddress1').rules('add', {required: true});
                $('#shippingcity').rules('add', {required: true});
                $('#shippingpostcode').rules('add', {required: true});
                $('#billingaddress1').rules('add', {required: true});
                $('#billingcity').rules('add', {required: true});
                $('#billingpostcode').rules('add', {required: true});
            }

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
                shippingCalculator($(this));
            }).addClass('hidden');
            $('#shippingcountryId').on('change', function () {
                shippingCalculator($('.js-recalculate-shipping-button'));
            });
            $('.js-multiple-shipping-types').on('change', function () {
                shippingCalculator($('.js-recalculate-shipping-button'));
            });
        },

        setupChoosePaymentType: function () {
            var _this = this;
            var $form = $('.js-stripe-form');
            $('input[type=radio][name=paymentOption]').on('change', function () {
                _this.paymentType = $(this).val();
                $('.js-paypal-logo').removeClass('hidden');
                $form.removeClass('hidden');
                if (_this.paymentType !== 'stripe') $form.addClass('hidden');
                if (_this.paymentType !== 'paypal') $('.js-paypal-logo').addClass('hidden');
            });
        },

        setupBillingAddress: function () {
            if ($('#shippingaddressId').val() !== 'NOTAPPLICABLE') $('.js-billing-address-form').toggle();
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