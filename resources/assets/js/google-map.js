$(document).ready(function () {
    var googleMapAddress = $('#googleMapAddress');
    if (googleMapAddress.length > 0) {
        var latlng = new google.maps.LatLng(0, 0);
        var myOptions = {zoom: 12, center: latlng, mapTypeId: google.maps.MapTypeId.ROADMAP};
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var geocoder = new google.maps.Geocoder();

        geocoder.geocode({'address': googleMapAddress.val()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
                map.setCenter(results[0].geometry.location);
                new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            } else {
                // alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
});