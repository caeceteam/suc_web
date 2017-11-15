<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQI7u6RI5Mtxh6FFqgPY9eMccFYmxLVzU&libraries=places&callback=initGoogleApiAutocomplete" async defer></script>

<script>
	$("#autocomplete").on('keyup keypress', function(e) {
		var keyCode = e.keyCode || e.which;
	  	if (keyCode === 13) { 
	    	e.preventDefault();
	    	return false;
	  	}
	});
</script>

<script>
	//This example displays an address form, using the autocomplete feature
	//of the Google Places API to help users fill in the information.
	
	//This example requires the Places library. Include the libraries=places
	//parameter when you first load the API. For example:
	//<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

	var placeSearch, autocomplete, geocoder;
	var componentForm = {
		street_number: 'short_name',
		route: 'long_name',
		locality: 'long_name',
		administrative_area_level_1: 'short_name',
		country: 'long_name',
		postal_code: 'short_name'
	};
	
	function initGoogleApiAutocomplete() {
		geocoder = new google.maps.Geocoder;
					  
		// Create the autocomplete object, restricting the search to geographical
		// location types.
		autocomplete = new google.maps.places.Autocomplete(
			(document.getElementById('autocomplete')),
			{types: ['geocode']}
		);
		autocomplete.setComponentRestrictions({'country': ['ar']});
		
		// When the user selects an address from the dropdown, populate the address
		// fields in the form.
		autocomplete.addListener('place_changed', fillInAddress);
		
		getAddressDescription();
	}
	
	function fillInAddress() {
		try {
			// Get the place details from the autocomplete object.
			var place = autocomplete.getPlace();
		
			var addressComponentsByType = {};
			for (var i = 0; i < place.address_components.length; i++) {
				var c = place.address_components[i];
				addressComponentsByType[c.types[0]] = c;
			}
			$('input[name="street"]').val(addressComponentsByType["route"].short_name);
			$('input[name="streetNumber"]').val(addressComponentsByType["street_number"].short_name);
			if (addressComponentsByType["postal_code"]){
				$('input[name="zipCode"]').val(addressComponentsByType["postal_code"].short_name);
			}	
			$('input[name="longitude"]').val(place.geometry.location.lng());
			$('input[name="latitude"]').val(place.geometry.location.lat());
		} catch (error) {
		   	swal({
		   		title: "Error", 
		   		text: "Ha habido un error al cargar la dirección, por favor carguela nuevamente", 
		   		type: "error"
		   	});
		}			
	}
	
	//Bias the autocomplete object to the user's geographical location,
	//as supplied by the browser's 'navigator.geolocation' object.
	<!-- function geolocate() { -->
		<!-- if (navigator.geolocation) { -->
			<!-- navigator.geolocation.getCurrentPosition(function(position) { -->
				<!-- var geolocation = { -->
					<!-- lat: position.coords.latitude, -->
					<!-- lng: position.coords.longitude -->
				<!-- }; -->
				<!-- var circle = new google.maps.Circle({ -->
					<!-- center: geolocation, -->
					<!-- radius: position.coords.accuracy -->
				<!-- }); -->
				<!-- autocomplete.setBounds(circle.getBounds()); -->
			<!-- }); -->
		<!-- } -->
	<!-- } -->
	
	function getAddressDescription() {
		latitude=$('input[name="latitude"]').val();               
		longitude=$('input[name="longitude"]').val();
		var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
	
		geocoder.geocode({'location': latlng}, function(results, status) {
			if (status === google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					$('#autocomplete').val(results[0].formatted_address);
					$($("#autocomplete")[0].parentNode).addClass("fg-toggled")
				}
			} 
		});
	};
</script>