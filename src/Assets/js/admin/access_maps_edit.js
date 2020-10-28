$(function(){

    // GoogleMap地図座標
    var location_latlon = ($('#location-latlon-hidden').val() != '') ? JSON.parse($('#location-latlon-hidden').val()) : {latitude: eval(35.658599), longitude: eval(139.745443), zoom: 13};
    var $location_map_container = $("#location-googlemap-container")[0] ? $("#location-googlemap-container") : null;
    var location_googlemap;
    var location_marker;
    if ($location_map_container) {
        location_googlemap = new google.maps.Map(document.getElementById("location-googlemap-container"), {
            zoom: location_latlon.zoom,
            center: new google.maps.LatLng(location_latlon.latitude, location_latlon.longitude),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDoubleClickZoom: true,
            disableDefaultUI : true,
            mapTypeControl : false,
            streetViewControl : false,
            zoomControl : true,
            scaleControl: false,
            scrollwheel: true,
            clickableIcons: false,
        });
        _locationPutMarker(location_googlemap.getCenter());
        google.maps.event.addListener(location_googlemap, "click", function(event) {
            _locationPutMarker(event.latLng);
        });
    }
    function _locationPutMarker(position) {
        if (location_marker) {
            location_marker.setMap(null);
        }
        location_marker = new google.maps.Marker({
            position: position,
            map: location_googlemap,
        });
        location_latlon.latitude = position.lat();
        location_latlon.longitude = position.lng();
        location_latlon.zoom = location_googlemap.getZoom()
        $('#location-latlon-hidden').val(JSON.stringify(location_latlon));
    }

});
