var sendToFriend = function() {
	return {
		init: function() {
			this.setupForm();
			this.setupClose();
			return this;
		},

		setupForm: function() {
			$('.js-send-to-friend').on('click', function() {
				var rfForm = $('.js-recommend-a-friend-form');
				$(this).parents('.buttons').after(rfForm);
				rfForm.removeClass('hide');

				// data values to pass into form
				$('#propertyId').val($(this).data('property-id'));
				$('#propertyName').val($(this).data('property-name'));
			});
		},

		setupClose: function() {
			$('.js-send-to-friend-close').on('click', function() {
				$('.js-recommend-a-friend-form').addClass('hide');
			});
		}
	}.init();
};

$(document).ready(function() {
	if ($('.js-recommend-a-friend-form').length) sendToFriend();
});