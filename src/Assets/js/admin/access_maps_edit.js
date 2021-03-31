$(() => {

    // GoogleMap地図座標
    var location_latlon = ($('#location-latlon-hidden').val() != '') ? JSON.parse($('#location-latlon-hidden').val()) : {latitude: 35.658599, longitude: 139.745443, zoom: 13};
    var location_marker;
    if ($("#location-googlemap-container").length) {
        const location_googlemap = new google.maps.Map(document.getElementById("location-googlemap-container"), {
            zoom: location_latlon.zoom,
            center: new google.maps.LatLng(location_latlon.latitude, location_latlon.longitude),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDoubleClickZoom: true,
            disableDefaultUI : true,
            mapTypeControl : false,
            streetViewControl : false,
            zoomControl : true,
            scaleControl: false,
            scrollwheel: false,
            clickableIcons: false,
        }),
        locationPutMarker = position => {
            if (location_marker) {
                location_marker.setMap(null);
            }
            location_marker = new google.maps.Marker({
                position: position,
                map: location_googlemap,
            });
            location_latlon = {latitude: position.lat(), longitude: position.lng(), zoom: location_googlemap.getZoom()};
            $('#location-latlon-hidden').val(JSON.stringify(location_latlon));
        };
        locationPutMarker(location_googlemap.getCenter());
        location_googlemap.addListener('click', e => locationPutMarker(e.latLng));
        location_googlemap.addListener('zoom_changed', () => locationPutMarker(location_marker.getPosition()));
    }

});
