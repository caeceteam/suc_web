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
		<form role="form" action="<?php echo $action; ?>" class="user-diner-form" method="POST">
							
            <section id="content">
			<div class="container">
				<div class="c-header">
					<h2>Datos usuario.</h2>
				</div>

				<div class="card">
					<div class="card-body card-padding">
						<small>Información personal.</small> <br />
						<br />

						<div class="row">
							<div class="card-body card-padding">
									<div class="pmbb-header">
										<h2>
											<i class="zmdi zmdi-account m-r-5"></i> Información personal
										</h2>
										<br /> <br />
									</div>

									<!-- DATOS NOMBRE -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="name">
											<input type="text" class="form-control input-sm" id="name" name="name"
												value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>">
											<label class="fg-label">Nombre</label>
										</div>
									</div>
									<br />

									<!-- DATOS APELLIDO -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="surname">
											<input type="text" id="surname" name="surname"
												class="input-sm form-control fg-input"
												value="<?php echo ($reset) ? '' : set_value('surname',$this->form_data->surname); ?>">
											<label class="fg-label">Apellido</label>
										</div>
									</div>
									<br />

									<!-- ALIAS DE LA PERSONA -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="alias">
											<input type="text" class="form-control input-sm" id="alias" name="alias"
												value="<?php echo ($reset) ? '' : set_value('alias',$this->form_data->alias); ?>">
											<label class="fg-label">Alias</label>
										</div>
									</div>
									<br />

                                    <!-- ROL DE LA PERSONA -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="alias">
											<input type="text" class="form-control input-sm" id="role" name="role"
												value="<?php echo ($reset) ? '' : set_value('rol',$this->form_data->role); ?>">
											<label class="fg-label">Rol</label>
										</div>
									</div>
									<br />


									<!-- FECHA DE NACIMIENTO DD/MM/AAAA -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="bornDate">
											<!--  <textarea class="form-control auto-size" id="bornDate" 
												name="bornDate"><?php echo ($reset) ? '' : set_value('bornDate',$this->form_data->bornDate); ?></textarea>-->
											<input type="text" class="form-control input-sm" id="bornDate" name="bornDate"
												value="<?php echo ($reset) ? '' : set_value('bornDate',$this->form_data->bornDate); ?>">
										
											<label class="fg-label">Fecha nacimiento</label>
										</div>
									</div>
									<br />

									<!-- FECHA DE NACIMIENTO DD/MM/AAAA -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="docNum">
											<textarea class="form-control auto-size" id="docNum"
												name="docNum"><?php echo ($reset) ? '' : set_value('docNum',$this->form_data->docNum); ?></textarea>
											<label class="fg-label">Número de documento</label>
										</div>
									</div>
									<br />
							
								<!-- BLOQUE DATOS DE CONTACTO -->
									<div class="pmbb-header">
										<h2>
											<i class="zmdi zmdi-phone m-r-5"></i> Información de Contacto
										</h2>
										<br />
										<br />
									</div>

									<!-- TELEFONO DE CONATCTO -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="phone">
											<input type="text" class="form-control input-sm" id="phone" name="phone"
												value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->phone); ?>">
											<label class="fg-label">Teléfono particular</label>
										</div>
									</div>
									<br />

									<!-- CORREO ELECTRONICO -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="mail">
											<input type="text" class="form-control input-sm" id="mail" name="mail"
												value="<?php echo ($reset) ? '' : set_value('mail',$this->form_data->mail); ?>">
											<label class="fg-label">Email particular</label>
										</div>
									</div>
									<br />

									<!-- DOMICIOLIO -->
									<div class="form-group fg-float">
										<div class="fg-line" data-id="address">
											<input id="address" type="text" name="address"
												class="input-sm form-control fg-input"> <label
												class="fg-label">Calle y número</label> <input
												value="<?php echo ($reset) ? '' : set_value('street',      $this->form_data->street); ?>"
												type="text" id="street" name="street" hidden> <input
												value="<?php echo ($reset) ? '' : set_value('streetNumber',$this->form_data->streetNumber); ?>"
												type="text" id="streetNumber" name="streetNumber" hidden> <input
												value="<?php echo ($reset) ? '' : set_value('floor',       $this->form_data->floor); ?>"
												type="text" id="floor" name="floor" hidden>
										</div>
									</div>
							    <!-- GESTION DE CLAVE PARA EL CASO DE MODIFICACIÓN -->
								<div class="pmbb-header" style= "<?php echo $this->new_pass; ?>" >
							                                    	<div class="pmbb-header" >
                                    		<h2>
                                    			<i class="zmdi zmdi-lock-open m-r-5"></i> Cambiar contraseña
                                    		</h2>
                                    	</div>
                                    	<br /> <br />
                                    	
                                    	<div class="form-group fg-float" >
                                    		<div class="fg-line" data-id="oldPass">
                                    			<input type="password" class="form-control input-sm" id="oldPass"
                                    				value= "">
                                    				<label class="fg-label">Clave actual</label>
                                    		</div>
                                    	</div>
                                    	<br />
                                    
                                    	<div class="form-group fg-float">
                                    		<div class="fg-line" data-id="newPass">
                                    			<input type="password" class="form-control input-sm" id="newPass"
                                    				value="<?php echo ($reset); ?>">
                                    			<label class="fg-label">Nueva clave</label>
                                    		</div>
                                    	</div>
                                    	<br />
                                    
                                    	<div class="form-group fg-float">
                                    		<div class="fg-line" data-id="newPassConf">
                                    			<input type="password" class="form-control input-sm" id="newPassConf"
                                    				value="<?php echo ($reset); ?>">
                                    			<label class="fg-label">Repetir clave</label>
                                    		</div>
                                    	</div>

                                    	<br />
                            	</div>

								<div id="unique-error-alert"
									class="alert alert-danger alert-dismissible hide-alert"
									role="alert">
									<button type="button" class="close" data-dismiss="alert"
										aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									Error en la carga del Usuario
								</div>

								<div id="empty-error-alert"
									class="alert alert-danger alert-dismissible hide-alert"
									role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									Por favor ingrese datos en los campos marcados
								</div>

								<button type="submit"
									class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
								<a href="<?php echo site_url('user_diner'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
						    </div>
						</div>

						<br /> <br />
					</div>

					<br />
				</div>
			</div>
		</section>

			<?php $this->load->view('templates/footer'); ?>
			
			<input hidden id="redirect-url"
			value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
		<input hidden id="request-action"
			value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
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
				showConfirmDialog({
					title: "¿Está seguro de grabar los cambios?",
					text: "Los datos de usuario serán modificados en el sistema",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "Los cambios se han grabado en el sistema.",
					failedText:  "Los datos de usuario no pudieron ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value
				});
				return false;
			}); 
		</script>

</body>
</html>