<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
<!--<meta charset="utf-8">-->
<meta charset="ISO-8859-1">
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

								Información personal.<small>Aquí­ se encuentran los datos
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
											value="<?php echo ($reset) ? '' : set_value('name', utf8_decode($this->form_data->name)); ?>">
									</div>
								</div>

								<!-- FILA 01- DATOS APELLIDO -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Apellido</label> <input type="text"
											class="form-control" id="surname" name="surname"
											value="<?php echo ($reset) ? '' : set_value('surname', utf8_decode($this->form_data->surname)); ?>">
									</div>
								</div>
								<!-- FILA 01 - ALIAS DE LA PERSONA -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Alias</label> <input type="text" class="form-control"
											id="alias" name="alias" placeholder="Alias en el sistema."
											value="<?php echo ($reset) ? '' : set_value('alias', utf8_decode($this->form_data->alias)); ?>">
									</div>
								</div>

								<!-- FILA 02- DOCUMENTO -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Número de documento</label> 
										<input min="1000000" max="999999999"
											class="form-control input-mask" data-mask="99.999.999" placeholder="ej. 99.99.999"
											id="docNum" name="docNum"
											value="<?php echo ($reset) ? '' : set_value('docNum', utf8_decode($this->form_data->docNum)); ?>">
									</div>
								</div>

								<!-- FILA 02- FECHA DE NACIMIENTO -->
								<div class="col-sm-4">
									<div class="form-group fg-line">
										<label>Fecha de naciomiento</label> <input type="text"
											class="form-control input-mask" data-mask="00-00-0000"
											placeholder="ej. 31-12-1900" id="bornDate" name="bornDate"
											value="<?php echo ($reset) ? '' : set_value('bornDate', utf8_decode($this->form_data->bornDate)); ?>">
									</div>
								</div>

								<!-- FINAL 03 - ROL DE LA PERSONA -->
								<div class="col-sm-4">
									<label>Rol</label> <select class="chosen"
										data-placeholder="<?php echo ($reset) ? 'Tareas en el comedor' : set_value('rol', utf8_decode($this->form_data->role)); ?>"
										id="role" name="role">
										<option value="99"></option>
										<option value="00"
											<?php if ($this->form_data->role == '00'){echo 'selected';} ?>>Administrador</option>
										<option value="01"
											<?php if ($this->form_data->role == '01'){echo 'selected';}; ?>>Portero</option>
										<option value="02"
											<?php if ($this->form_data->role == '02'){echo 'selected';}; ?>>Cocinero</option>
										<option value="03"
											<?php if ($this->form_data->role == '03'){echo 'selected';}; ?>>Docente</option>
										<option value="04"
											<?php if ($this->form_data->role == '04'){echo 'selected';}; ?>>Cereno</option>
										<option value="05"
											<?php if ($this->form_data->role == '05'){echo 'selected';}; ?>>Psicopedagogo</option>
										<option value="06"
											<?php if ($this->form_data->role == '06'){echo 'selected';}; ?>>Psicologo</option>
										<option value="07"
											<?php if ($this->form_data->role == '07'){echo 'selected';}; ?>>Acompañante</option>
										<option value="08"
											<?php if ($this->form_data->role == '08'){echo 'selected';}; ?>>Tareas
											Varias</option>
									</select>
								</div>

								<!-- FINAL 04 - MAIL -->
								<div class="col-sm-6">
									<div class="form-group fg-line">
										<label>Email particular</label> <input type="email"
											class="form-control" id="mail" name="mail"
											value="<?php echo ($reset) ? '' : set_value('mail', utf8_decode($this->form_data->mail)); ?>">
									</div>
								</div>

								<!-- FINAL 04 - TELEFONO PARTICULAR-->
								<div class="col-sm-6">
									<div class="form-group fg-line">
										<label>Telefono particular</label> <input type="text"

											class="form-control" id="phone" name="phone"
											value="<?php echo ($reset) ? '' : set_value('phone', utf8_decode($this->form_data->phone)); ?>">
									</div>
								</div>

								<!--FILA 05 CALLE LOCALIDAD-->
								<div class="col-sm-6">
									<div class="form-group fg-line">
										<label>Calle y localidad</label> <input type="text"
											class="form-control" id="street" name="street"
											value="<?php echo ($reset) ? '' : set_value('street', utf8_decode($this->form_data->street)); ?>">
									</div>
								</div>
								<!--FILA 05 ALTURA-->
								<div class="col-sm-2">
									<div class="form-group fg-line">
										<label>Altura</label> 
										<input class="form-control" id="streetNumber" name="streetNumber" type="nume"
											value="<?php echo ($reset) ? '' : set_value('streetNumber', utf8_decode($this->form_data->streetNumber)); ?>">
									</div>
								</div>
								
								<!--FILA Pisi-->
								<div class="col-sm-2">
									<div class="form-group fg-line">
										<label>Piso</label> 
										<input class="form-control" id="floor" name="floor"
											value="<?php echo ($reset) ? '' : set_value('floor', utf8_decode($this->form_data->floor)); ?>">
									</div>
								</div>
								<!--FILA Puerta-->
								<div class="col-sm-2">
									<div class="form-group fg-line">
										<label>Puerta</label> 
										<input class="form-control" id="door" name="door"
											value="<?php echo ($reset) ? '' : set_value('door', utf8_decode($this->form_data->door)); ?>">
									</div>
								</div>

							</div>
							<br />
							<div class="pmb-block">
								<button type="submit"
									class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
								<!-- <a href="<?php echo site_url('user_diner'); ?>"
									class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?> -->
								 
								 <a href="<?php echo site_url($this->form_data->redirect); ?>"
									class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?> 



							</div>
							<div class="pmb-block">
							    <?php $this->load->view('templates/alerts'); ?>
							</div>

							<div class="pmb-block">
								<input hidden id="redirect-url"
									value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
								<input hidden id="request-action"
									value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
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
</body>
</html>