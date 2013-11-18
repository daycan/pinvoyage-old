// Googlemaps functions

function makeAddressString() {
	var address = document.getElementById("placetitle").value + ", " 
		+ document.getElementById("street").value + ", "
		+ document.getElementById("city").value + ", "
		+ document.getElementById("country").value;
};

function geocodeLatLng() {
	makeAddressString;
	var geocoder = new google.maps.Geocoder();
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			  // do something with the geocoded result
			  //
			  // results[0].geometry.location.latitude
			  // results[0].geometry.location.longitude
		} else {
				alert("Geocode was not successful for the following reason: " + status);
		}
	});
}