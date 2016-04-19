jQuery(function($) {
    $('#stripePaymentForm').submit(function(event) {
        var $form = $(this);
        var $btn = $(document.activeElement);

        if ($btn.hasClass('js-recalculate-shipping-button')) return true;

        // Disable the submit button to prevent repeated clicks
        $form.find('button[type="submit"]').prop('disabled', true);

        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form from submitting with the default action
        return false;
    });
});

function stripeResponseHandler(status, response) {
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