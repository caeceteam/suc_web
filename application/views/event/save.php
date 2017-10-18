<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SUC</title>
        
		<?php $this->load->view('templates/styles'); ?>

    </head>

    <body data-ma-header="teal">

		<?php $this->load->view('templates/header'); ?>
			
        <section id="main">
        
			<?php $this->load->view('templates/menu'); ?>
        
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2 style="font-size: 25px;">Alta de Evento</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>
					
					
                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos correspondientes al evento que desee dar de alta para el comedor</small>

                            <br/><br/>
                            
                                <div class="card-body card-padding">
									<form role="form" action="<?php echo $action; ?>" method="POST" class="event-form" enctype="multipart/form-data">
										<div class="row">
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>" type="text" name="name" class="input-sm form-control fg-input">
													<label class="fg-label">Nombre del evento</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input id="autocomplete" placeholder="" type="text" name="address" class="input-sm form-control fg-input">
													<label class="fg-label">Calle y n�mero</label>
													<input value="<?php echo ($reset) ? '' : set_value('street',$this->form_data->street); ?>" type="text" id="street" name="street" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('streetNumber',$this->form_data->streetNumber); ?>" type="text" id="streetNumber" name="streetNumber" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('latitude',$this->form_data->latitude); ?>" type="text" id="latitude" name="latitude" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('longitude',$this->form_data->longitude); ?>" type="text" id="longitude" name="longitude" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('zipCode',$this->form_data->zipCode); ?>" type="text" id="zipCode" name="zipCode" hidden>
												</div>
											</div>
											<div class="fg-float form-group col-xs-3" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('floor',$this->form_data->floor); ?>" type="text" name="floor" class="input-sm form-control fg-input">
													<label class="fg-label">Piso</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-3" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('door',$this->form_data->door); ?>" type="text" name="door" class="input-sm form-control fg-input">
													<label class="fg-label">Depto.</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->phone); ?>" type="text" name="phone" class="input-sm form-control fg-input">
													<label class="fg-label">Tel�fono de contacto</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-12" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('link',$this->form_data->link); ?>" type="text" name="link" class="input-sm form-control fg-input">
													<label class="fg-label">Sitio web del evento</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-12" style="padding-left: 0;padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<textarea class="form-control auto-size" name="description"><?php echo ($reset) ? '' : set_value('description',$this->form_data->description); ?></textarea>
													<label class="fg-label">Descripci�n del evento</label>
												</div>
											</div>
											
											<br/><br/>
				                            <p class="c-black f-500 m-b-5 m-t-20">Cu�ndo suceder� el evento?</p>
				                            <small>Ingrese fecha y hora del evento</small>
				                            <br/>
				                            <br/>
				                            <br/>
											<div class="col-sm-4">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="date">
														<input type="text" id="date" name="date" class="form-control input-mask" data-mask="0000-00-00" value="<?php echo ($reset) ? '' : set_value('date',$this->form_data->date); ?>">
														<label class="fg-label">Fecha (a�o-mes-d�a)</label>
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="time">
														<input type="text" id="time" name="time" class="form-control input-mask" data-mask="00:00" value="<?php echo ($reset) ? '' : set_value('time',$this->form_data->time); ?>">
														<label class="fg-label">Hora (hora:min)</label>
													</div>
												</div>
											</div>
										</div>
											<!--<div class="card-padding card-header">		-->									
										<p></p>
										<br/>
				                        <br/>
				                        <br/>										
										<p><b>Subir foto del Evento</b></p>
										<p>Seleccione la im�gen que desee subir del evento.</p>
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
												<div>
													<span class="btn btn-info btn-file">
														<span class="fileinput-new">Seleccionar archivo</span>
														<span class="fileinput-exists">Cambiar</span>
														<input type="file" name="photo" id="photo">
													</span>
													<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Quitar</a>
												</div>
										</div>

										<br/>
										<br/>
										<?php $this->load->view('templates/alerts'); ?>
											
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
										<a href="<?php echo site_url('event'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
									
									</form>		 
                                </div>
                        </div>
                    </div>
            		<br/>
                </div>
            </section>

			<?php $this->load->view('templates/footer'); ?>
			<input hidden id="redirect-url" value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
			<input hidden id="request-action" value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
        </section>

        <!-- Page Loader -->
        <div class="page-loader palette-Teal bg">
            <div class="preloader pl-xl pls-white">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20"/>
                </svg>
            </div>
        </div>

		<?php $this->load->view('templates/scripts'); ?>
		<script src="<?php echo base_url('js/confirmDialogForm.js')?>"></script>
		<script>
			$('.event-form').submit(function() {
				showConfirmDialog({
					title: "�Est� seguro grabar este evento?",
					text: "El evento se grabar� en el sistema",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "El evento se ha grabado en el sistema.",
					failedText: "El evento no pudo ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value,
					containImage: false,
				});
				return false;
			}); 
			
        </script>
        
		<script>
		  // This example displays an address form, using the autocomplete feature
		  // of the Google Places API to help users fill in the information.

		  // This example requires the Places library. Include the libraries=places
		  // parameter when you first load the API. For example:
		  // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

		  var placeSearch, autocomplete, geocoder;
		  var componentForm = {
			street_number: 'short_name',
			route: 'long_name',
			locality: 'long_name',
			administrative_area_level_1: 'short_name',
			country: 'long_name',
			postal_code: 'short_name'
		  };

		  function initAutocomplete() {
				geocoder = new google.maps.Geocoder;
				  
				// Create the autocomplete object, restricting the search to geographical
				// location types.
				autocomplete = new google.maps.places.Autocomplete(
					/** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
					{types: ['geocode']});
	
				// When the user selects an address from the dropdown, populate the address
				// fields in the form.
				autocomplete.addListener('place_changed', fillInAddress);

				getAddressDescription();
	      }

		  function fillInAddress() {
				// Get the place details from the autocomplete object.
				var place = autocomplete.getPlace();

				var addressComponentsByType = {};
				for (var i = 0; i < place.address_components.length; i++) {
				  var c = place.address_components[i];
				  addressComponentsByType[c.types[0]] = c;
				}
				$('input[name="street"]').val(addressComponentsByType["route"].short_name);
				$('input[name="streetNumber"]').val(addressComponentsByType["street_number"].short_name);
				if (addressComponentsByType["postal_code"])
				{
					$('input[name="zipCode"]').val(addressComponentsByType["postal_code"].short_name);
				}	
				$('input[name="longitude"]').val(place.geometry.location.lng());
				$('input[name="latitude"]').val(place.geometry.location.lat());
			}

		  // Bias the autocomplete object to the user's geographical location,
		  // as supplied by the browser's 'navigator.geolocation' object.
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
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQI7u6RI5Mtxh6FFqgPY9eMccFYmxLVzU&libraries=places&callback=initAutocomplete" async defer></script>
		
    </body>
</html>