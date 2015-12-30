$(document).ready(function () {

});

function createMap(lat, lng) {
    var latLng = new google.maps.LatLng(lat, lng);
    var myOptions = {zoom: 12, center: latLng, mapTypeId: google.maps.MapTypeId.ROADMAP};
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    new google.maps.Marker({
        map: map,
        position: latLng
    });
}

function geoCodeAddress(address) {
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({'address': address}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var lat = results[0].geometry.location.lat();
            var lng = results[0].geometry.location.lng();
            // cache the result to reduce number of requests
            $.post('/vendirun/google-map-cache-set', { address: address, lat: lat, lng: lng });
            createMap(lat, lng);
        } else {
            // alert("Geocode was not successful for the following reason: " + status);
        }
    });
}

function initializeMap() {
    var googleMapAddress = $('#googleMapAddress');
    console.log(googleMapAddress.val());
    if (googleMapAddress.length > 0) {
        var address = googleMapAddress.val();
        if (address !== '') {
            // get from cache (if exists in cache)
            $.post('/vendirun/google-map-cache-get', { address: address }, function(response) {
                if (response.success) {
                    createMap(response.lat, response.lng);
                }
                else {
                    geoCodeAddress(address);
                }
            }, 'json');
        }
    }
}