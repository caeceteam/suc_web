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
		<form role="form" action="<?php echo $action; ?>"
			class="user-diner-form" method="POST">
			<section id="content">
				<div class="container">
					<div class="c-header">
						<h2>Datos usuario.</h2>
					</div>

					<div class="card">
						<div class="card-header">
							<h2>
								Información personal.<small>Aquí se encuentran los datos
									personales del colaborador.</small>
							</h2>
						</div>
						<div class="card-body card-padding">
							<div class="row">
								<!-- FILA 01 - DATOS NOMBRE -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Nombre</label> <input type="text" class="form-control"
											id="name" name="name"
											value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>">
									</div>
								</div>

								<!-- FILA 01- DATOS APELLIDO -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Apellido</label> <input type="text"
											class="form-control" id="surname" name="surname"
											value="<?php echo ($reset) ? '' : set_value('surname',$this->form_data->surname); ?>">
									</div>
								</div>

								<!-- FILA 01 - ALIAS DE LA PERSONA -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Alias</label> <input type="text" class="form-control"
											id="alias" name="alias" placeholder="Alias en el sistema."
											value="<?php echo ($reset) ? '' : set_value('alias',$this->form_data->alias); ?>">
									</div>
								</div>

								<!-- FILA 02- DOCUMENTO -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Número de documento</label> <input type="number"
											class="form-control" min="1000000" max="999999999"
											id="docNum" name="docNum"
											value="<?php echo ($reset) ? '' : set_value('docNum',$this->form_data->docNum); ?>">
									</div>
								</div>

								<!-- FILA 02- FECHA DE NACIMIENTO -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Fecha de naciomiento</label> <input type="text"
											class="form-control input-mask" data-mask="00-00-0000"
											placeholder="ej. 31-12-1900" id="bornDate" name="bornDate"
											value="<?php echo ($reset) ? '' : set_value('bornDate',$this->form_data->bornDate); ?>">
									</div>
								</div>

								<!-- FINAL 03 - ROL DE LA PERSONA -->
								<div class="col-sm-4">
									<label>Rol</label> <select class="chosen"
										data-placeholder="<?php echo ($reset) ? 'Tareas en el comedor' : set_value('rol',$this->form_data->role); ?>"
										id="role" name="role" >
										<option value="99" "></option>
										<option value="00" <?php if ($this->form_data->role == '00'){echo 'selected';} ?>>Administrador</option>
										<option value="01" <?php if ($this->form_data->role == '01'){echo 'selected';}; ?>>Portero</option>
										<option value="02" <?php if ($this->form_data->role == '02'){echo 'selected';}; ?>>Cocinero</option>
										<option value="03" <?php if ($this->form_data->role == '03'){echo 'selected';}; ?>>Docente</option>
										<option value="04" <?php if ($this->form_data->role == '04'){echo 'selected';}; ?>>Cereno</option>
										<option value="05" <?php if ($this->form_data->role == '05'){echo 'selected';}; ?>>Psicopedagogo</option>
										<option value="06" <?php if ($this->form_data->role == '06'){echo 'selected';}; ?>>Psicologo</option>
										<option value="07" <?php if ($this->form_data->role == '07'){echo 'selected';}; ?>>Acompañante</option>
										<option value="08" <?php if ($this->form_data->role == '08'){echo 'selected';}; ?>>Tareas Varias</option>
									</select>
								</div>

								<!-- FINAL 04 - MAIL -->
								<div class="col-sm-6">
									<div class="form-group fg-line">
										<label>Email particular</label> <input type="email"
											class="form-control" id="mail" name="mail"
											value="<?php echo ($reset) ? '' : set_value('mail',$this->form_data->mail); ?>">
									</div>
								</div>

								<!-- FINAL 04 - TELEFONO PARTICULAR-->
								<div class="col-sm-6">
									<div class="form-group fg-line">
										<label>Teléfono particular</label> 
											<input type="text"
											class="form-control" id="phone" name="phone"
											value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->phone); ?>">
									</div>
								</div>
								<div class="col-sm-10"> 
									<div class="form-group fg-line"> 
										<label class="fg-label">Calle y número</label>
										<input id="autocomplete" placeholder="" type="text"
											name="address" class="form-control"><!--  class="input-sm form-control fg-input" >--> 
										
										<!-- Calle -->
										<input type="hidden" class="form-control" id="street"
											name="street"
											value="<?php echo ($reset) ? '' : set_value('street',$this->form_data->street); ?>" >
										<!-- Numero de casa -->
										<input type="hidden" class="form-control" id="streetNumber"
											name="streetNumber"
											value="<?php echo ($reset) ? '' : set_value('streetNumber',$this->form_data->streetNumber); ?>" > 
										<!-- Latitud geo localización --> 
										<input type="hidden" id="latitude" name="latitude"
											value="<?php echo ($reset) ? '' : set_value('latitude',$this->form_data->latitude); ?>" > 
										<!-- Longitud geo localización -->
										<input type="hidden" id="longitude" name="longitude"
											value="<?php echo ($reset) ? '' : set_value('longitude',$this->form_data->longitude); ?>"> 
										<!-- Codigo postal -->
										<input type="hidden" id="zipCode" name="zipCode"
											value="<?php echo ($reset) ? '' : set_value('zipCode',$this->form_data->zipCode); ?>"> 
									</div> 
								</div> 
							</div>
							<br /> 
							<div class="pmb-block">
									<button type="submit"
										class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
									<a href="<?php echo site_url('user_diner'); ?>"
										class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>

							</div>
							<div class="pmb-block">
							    <?php $this->load->view('templates/alerts'); ?>
							</div>
			
							<div class="pmb-block">
							     <input hidden id="redirect-url"   value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
						         <input hidden id="request-action" value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
							</div>
			
						</div>
					</div>
				</div>
			</section>
			
			<?php $this->load->view('templates/footer'); ?>
			
		</form>
	</section>

	<!-- Page Loader -->
	<div class="page-loader palette-Teal bg">
		<div class="preloader pl-xl pls-white">
			<svg class="pl-circular" viewBox="25 25 50 50">
                <circle class="plc-path" cx="50" cy="50" r="20" />
            </svg>
		</div>
	</div>

		<?php $this->load->view('templates/scripts'); ?>
		<script src="<?php echo base_url('js/confirmDialogForm.js')?>"></script>

	<script>
			$('.user-diner-form').submit(function() {
				debugger;
				showConfirmDialog({
		     		title: "¿Está seguro de grabar los cambios?",
					text: "Los datos de usuario serán grabados",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "Se han grabado los datos de Usuario.",
					failedText:  "Los datos de usuario no pudieron ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value
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

</body>
</html>