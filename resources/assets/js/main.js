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

	// If there are thumbnails on the page, we want them all the same size
	if ($('.thumbnail').length > 0) thumbnails.init();

    $('[data-toggle="tooltip"]').tooltip();

});

var urlManager = function() {
    return {
        init: function() {
            return this;
        },

        addParameterToUrl: function(param, value) {
            var queryParameters = {}, queryString = location.search.substring(1),
                re = /([^&=]+)=([^&]*)/g, m;

            while (m = re.exec(queryString)) {
                queryParameters[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
            }

            queryParameters[param] = value;

            location.search = $.param(queryParameters);
        }
    }.init();
};