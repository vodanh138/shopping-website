<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Google Maps </title>
<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>
</head>
<body>

<form id="locationForm">
    <label for="address">Enter Address:</label>
    <input type="text" id="address" name="address">
    <label for="latitude">Latitude:</label>
    <input type="text" id="latitude" name="latitude">
    <label for="longitude">Longitude:</label>
    <input type="text" id="longitude" name="longitude">
    <button type="button" onclick="searchLocation()">Search</button>
</form>

<div id="map"></div>

<script>
    var marker = null;

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 0, lng: 0},
            zoom: 8
        });
        window.map = map;
    }

    function searchLocation() {
        var address = document.getElementById('address').value;
        var latitude = parseFloat(document.getElementById('latitude').value);
        var longitude = parseFloat(document.getElementById('longitude').value);

        if (address) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {
                    window.map.setCenter(results[0].geometry.location);
                    if (marker) {
                        marker.setMap(null);
                    }
                    marker = new google.maps.Marker({
                        map: window.map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        } else if (!isNaN(latitude) && !isNaN(longitude)) {
            window.map.setCenter({lat: latitude, lng: longitude});
            if (marker) {
                marker.setMap(null);
            }
            marker = new google.maps.Marker({
                map: window.map,
                position: {lat: latitude, lng: longitude}
            });
        } else {
            alert("Please enter either an address or latitude/longitude.");
        }
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEPANUayr9c-j2jlX8duCCNqsv3Lm0WBg&callback=initMap">
</script>

</body>
</html>
