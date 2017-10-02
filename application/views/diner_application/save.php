<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SUC</title>

        <!-- Vendor CSS -->
        <link href="<?php echo base_url('vendors/bower_components/animate.css/animate.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/google-material-color/dist/palette.css')?>" rel="stylesheet">

        <link href="<?php echo base_url('vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/farbtastic/farbtastic.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/chosen/chosen.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/summernote/dist/summernote.css')?>" rel="stylesheet">

		<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
		
        <!-- CSS -->
        <link href="<?php echo base_url('css/app.min.1.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('css/app.min.2.css')?>" rel="stylesheet">
        
        <!-- Following CSS are used only for the Demp purposes thus you can remove this anytime. -->
        <style type="text/css">
            .toggle-switch .ts-label {
                min-width: 130px;
            }
        </style>
    </head>

    <body data-ma-header="teal">
        <header id="header" class="media">
            <div class="pull-left h-logo">
                <a href="index.refactor.html" class="hidden-xs">
                    SUC
                    <small>Sistema Único de Comedores</small>
                </a>

                <div class="menu-collapse" data-ma-action="sidebar-open" data-ma-target="main-menu">
                    <div class="mc-wrap">
                        <div class="mcw-line top palette-White bg"></div>
                        <div class="mcw-line center palette-White bg"></div>
                        <div class="mcw-line bottom palette-White bg"></div>
                    </div>
                </div>
            </div>

            <ul class="pull-right h-menu">
                <li class="hm-alerts" data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                    <a href=""><i class="hm-icon zmdi zmdi-notifications"></i></a>
                </li>
                <li class="dropdown hm-profile">
                    <a data-toggle="dropdown" href="">
                        <img src="<?php echo base_url('img/profile-pics/1.jpg')?>" alt="">
                    </a>

                    <ul class="dropdown-menu pull-right dm-icon">
                        <li>
                            <a href="profile-about.html"><i class="zmdi zmdi-account"></i> Mis Datos</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-settings"></i> Cambiar contraseña</a>
                        </li>
                    </ul>
                </li>
            </ul>
			
		</header>
        
        <section id="main">
            <aside id="s-user-alerts" class="sidebar">
                <ul class="tab-nav tn-justified tn-icon m-t-10" data-tab-color="teal">
                    <li><a class="sua-notifications" href="#sua-notifications" data-toggle="tab"><i class="zmdi zmdi-notifications"></i></a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade" id="sua-notifications">
                        <ul class="sua-menu list-inline list-unstyled palette-Orange bg">
                            <li><a href=""><i class="zmdi zmdi-volume-off"></i> Mute</a></li>
                            <li><a href=""><i class="zmdi zmdi-long-arrow-tab"></i> View all</a></li>
                            <li><a href="" data-ma-action="sidebar-close"><i class="zmdi zmdi-close"></i> Close</a></li>
                        </ul>

                        <div class="list-group lg-alt c-overflow">
                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img" src="http://uoetsylra.org/img/multimedia/Margarita-Barrientos-Retrato-2-e1378332345443.jpg" alt="">
                                </div>

                                <div class="media-body">
                                    <div class="lgi-heading">Comedor Los piletones</div>
                                    <small class="lgi-text">Solicitud de frazadas</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
			</aside>
			
            <aside id="s-main-menu" class="sidebar">
                <div class="smm-header">
                    <i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
                </div>

                <ul class="smm-alerts" style="margin: 30px 0 60px 120px; padding-left: 0px;"><!-- TODO CC: Add style to css class-->
                    <li data-user-alert="sua-notifications" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                        <i class="zmdi zmdi-notifications"></i>
                    </li>
                </ul>

                <ul class="main-menu">
                    <li>
                        <a href="index.refactor.html"><i class="zmdi zmdi-home"></i> Home</a>
                    </li>
                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-notifications-active"></i> Aprobaciones pendientes</a>

                        <ul>
                            <li><a href="HU001.lista.html"> De personas</a></li>
                        </ul>
                    </li>
                    <li>
						<a href="HU007.lista.html"><i class="zmdi zmdi-local-dining"></i> Comedores</a>
					</li>
                    
                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-swap-alt"></i> Mantenimiento SUC</a>
                        <ul>
                            <li><a href="HU010.lista.html">Tipos de Insumo</a></li>
							<li><a href="HU011.lista.html">Tipos de Alimento</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
        
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2 style="font-size: 25px;">Solicitud de Alta de Comedor</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos correspondientes al comedor que desee dar de alta en el sistema SUC.</small>

                            <br/><br/>
                            
                                <div class="card-body card-padding">
									<form role="form" action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
										<div class="row">
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>" type="text" name="name" class="input-sm form-control fg-input">
													<label class="fg-label">Nombre del comedor</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('mail',$this->form_data->mail); ?>" type="text" name="mail" class="input-sm form-control fg-input">
													<label class="fg-label">Mail del comedor</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input id="autocomplete" placeholder="" type="text" name="address" class="input-sm form-control fg-input">
													<label class="fg-label">Calle y número</label>
													<input value="<?php echo ($reset) ? '' : set_value('street',$this->form_data->street); ?>" type="text" id="street" name="street" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('streetNumber',$this->form_data->streetNumber); ?>" type="text" id="streetNumber" name="streetNumber" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('latitude',$this->form_data->latitude); ?>" type="text" id="latitude" name="latitude" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('longitude',$this->form_data->longitude); ?>" type="text" id="longitude" name="longitude" hidden>
													<input value="<?php echo ($reset) ? '' : set_value('zipCode',$this->form_data->zipCode); ?>" type="text" id="zipCode" name="zipCode" hidden>
												</div>
											</div>
											<br/>
											<div class="fg-float form-group col-xs-3" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('floor',$this->form_data->floor); ?>" type="text" name="floor" class="input-sm form-control fg-input">
													<label class="fg-label">Piso</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-3" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('door',$this->form_data->door); ?>" type="text" name="door" class="input-sm form-control fg-input">
													<label class="fg-label">Departamento</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->phone); ?>" type="text" name="phone" class="input-sm form-control fg-input">
													<label class="fg-label">Teléfono</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('link',$this->form_data->link); ?>" type="text" name="link" class="input-sm form-control fg-input">
													<label class="fg-label">Página del comedor</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-12" style="padding-left: 0;padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<textarea class="form-control auto-size" name="description"><?php echo ($reset) ? '' : set_value('description',$this->form_data->description); ?></textarea>
													<label class="fg-label">Descripción del comedor</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('user_name',$this->form_data->user_name); ?>" type="text" name="user_name" class="input-sm form-control fg-input">
													<label class="fg-label">Nombre del solicitante</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('surname',$this->form_data->surname); ?>" type="text" name="surname" class="input-sm form-control fg-input">
													<label class="fg-label">Apellido del solicitante</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('user_mail',$this->form_data->user_mail); ?>" type="text" name="user_mail" class="input-sm form-control fg-input">
													<label class="fg-label">Mail del solicitante</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input value="<?php echo ($reset) ? '' : set_value('alias',$this->form_data->alias); ?>" type="text" name="alias" class="input-sm form-control fg-input">
													<label class="fg-label">Nombre de usuario del solicitante</label>
												</div>
											</div>
											<p><b>Subir foto del Comedor</b></p>
											<p>Seleccione la imágen que desee subir del comedor.</p>
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
											<div class="pmb-block">
												<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Crear</button>
												<a href="<?php echo site_url('home'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>	
											</div>

											</br>
											
											<div id=alerts" class="pmb-block">
												<div class="alert alert-success alert-dismissible" role="alert" hidden>
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													Texto satisfactorio
												</div>
												<div class="alert alert-danger alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<?php echo $message?>
												</div>
											</div>
											
										</div>
									</form>
                                </div>
                            </div>
       
                        <br/>
                    </div>
                </div>
            </section>

            <footer id="footer">
                Copyright &copy; 2015 Material Admin

                <ul class="f-menu">
                    <li><a href="">Home</a></li>
                    <li><a href="">Dashboard</a></li>
                    <li><a href="">Reports</a></li>
                    <li><a href="">Support</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </footer>
        </section>

        <!-- Page Loader -->
        <div class="page-loader palette-Teal bg">
            <div class="preloader pl-xl pls-white">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20"/>
                </svg>
            </div>
        </div>


        <!-- Javascript Libraries -->
        <script src="<?php echo base_url('vendors/bower_components/jquery/dist/jquery.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
        
        <script src="<?php echo base_url('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/Waves/dist/waves.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bootstrap-growl/bootstrap-growl.min.js')?>"></script>

        <script src="<?php echo base_url('vendors/bower_components/moment/min/moment.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/summernote/dist/summernote-updated.min.js')?>"></script>
		<script src="<?php echo base_url('vendors/bower_components/autosize/dist/autosize.min.js')?>"></script>


        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->
        
        <script src="<?php echo base_url('vendors/bower_components/chosen/chosen.jquery.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/fileinput/fileinput.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/input-mask/input-mask.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/farbtastic/farbtastic.min.js')?>"></script>

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
/*
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
*/
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
		
        <script src="<?php echo base_url('js/functions.js')?>"></script>
        <script src="<?php echo base_url('js/actions.js')?>"></script>
        <script src="<?php echo base_url('js/demo.js')?>"></script>
    </body>
</html>