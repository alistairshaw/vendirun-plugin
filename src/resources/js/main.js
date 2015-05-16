$(document).ready(function () {

	$('.js-fade-out').each(function () {
		var _this = $(this);

		var time = (_this.data('time')) ? _this.data('time') : 3;
		time = time * 1000;

		setTimeout(function () {
			_this.css('overflow', 'hidden').animate({ opacity: 0, height: 0 }, 1000, 'swing', function () {
				_this.remove();
			});
		}, time);
	});

});