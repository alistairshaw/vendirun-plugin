var stripeManager = function($form) {
    return {
        init: function() {
            Stripe.card.createToken($form, this.stripeResponseHandler);
        },

        stripeResponseHandler: function(status, response) {
            var $form = $('#stripePaymentForm');
            var $errorDiv = $form.find('.js-payment-errors');
            $errorDiv.addClass('hidden');

            if (response.error) {
                $errorDiv.removeClass('hidden').html(response.error.message);
                $(document).scrollTop($errorDiv.position().top);
                $form.find('button').prop('disabled', false);
            } else {
                // response contains id and card, which contains additional card details
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and submit
                $form.get(0).submit();
            }
        }
    }.init($form);
};