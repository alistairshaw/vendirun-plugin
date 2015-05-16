/**
 * Sets up the form validation for the standard selector or any ID that you pass in
 * @param theForm
 * @param excludeForKeyUp
 * @returns {*|jQuery}
 */
var formValidation = function (theForm, excludeForKeyUp) {
	return {

		$selector: '',

		init: function (theForm, excludeForKeyUp) {
			var selector = (theForm === undefined || theForm == 0) ? '.js-validate-form' : theForm;

			this.$selector = $(selector).validate({
				highlight: function (element) {
					$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				},
				unhighlight: function (element) {
					$(element).closest('.form-group').removeClass('has-error');
				},
				errorElement: 'span',
				errorClass: 'help-block',
				errorPlacement: function (error, element) {
					if (element.parent('.input-group').length) {
						error.insertAfter(element.parent());
					} else {
						error.insertAfter(element);
					}
				},
				success: function (element) {
					//$(element).closest('.form-group').addClass('has-success');
				},
				checkForAttr: function (excludeForKeyUp, element) {
					var applyKeyUp = true;

					if (excludeForKeyUp !== undefined) {
						$.each(excludeForKeyUp, function (index, val) {
							if ($(element).attr('id') == val) {
								applyKeyUp = false;
							}
						});
					}
					return applyKeyUp;
				},
				onkeyup: function (element) {
					if (excludeForKeyUp !== undefined) {
						if (this.settings.checkForAttr(excludeForKeyUp, element)) $.validator.defaults.onkeyup.apply(this, arguments)
					}
				}
				/*,submitHandler: function(form) {
				 var submitButton = $(selector).find('button[type="submit"]');
				 submitButton.width(submitButton.width()).addClass('disabled').html('<i class="fa fa-spinner fa-spin"></i>');
				 form.submit();
				 }*/
			});

			return this;
		}

	}.init(theForm, excludeForKeyUp);
};

$(document).ready(function() {
	formValidation();
});