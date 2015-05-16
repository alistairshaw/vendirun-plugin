var propertyMap = function () {
	return {

		lat: 0,
		lng: 0,

		init: function () {
			var _this = this;

			// check if lat and lng are set, if so, show map
			var latField = $('#propertyLat');
			var lngField = $('#propertyLng');

			if (latField.length && lngField.length) {
				_this.lat = latField.val();
				_this.lng = lngField.val();
				_this.setupMap();
			}
		},

		setupMap: function () {
			var _this = this;
			console.log(_this);
			google.maps.event.addDomListener(window, 'load', function() { _this.initialize(_this.lat, _this.lng); });
		},

		initialize: function(lat, lng) {
			console.log(lat, lng);
			var myLatlng = new google.maps.LatLng(lat, lng);
			var mapOptions = {
				zoom: 14,
				center: myLatlng
			};
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: 'Property Location'
			});
		}
	}.init();
};

$(document).ready(function() {
	if ($('.js-single-property').length) {
		propertyMap();
	}
});

