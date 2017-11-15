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
                
		    <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2 style="font-size: 25px;">Solicitud de Alta de Comedor</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos correspondientes al comedor que desee dar de alta en el sistema SUC.</small>
                            
                             <div class="card-body card-padding">
								<form class="diner-application-form" role="form" action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
									<div class="row">
										<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line" data-id="name">
												<input value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>" type="text" name="name" class="input-sm form-control fg-input">
												<label class="fg-label">Nombre del comedor</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line"  data-id="mail">
												<input value="<?php echo ($reset) ? '' : set_value('mail',$this->form_data->mail); ?>" type="text" name="mail" class="input-sm form-control fg-input">
												<label class="fg-label">Mail del comedor</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line" data-id="street">
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
										<div class="fg-float form-group col-xs-2" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line">
												<input value="<?php echo ($reset) ? '' : set_value('floor',$this->form_data->floor); ?>" type="text" name="floor" class="input-sm form-control fg-input">
												<label class="fg-label">Piso</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-2" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line">
												<input value="<?php echo ($reset) ? '' : set_value('door',$this->form_data->door); ?>" type="text" name="door" class="input-sm form-control fg-input">
												<label class="fg-label">Departamento</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-2" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line" data-id="phone">
												<input value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->phone); ?>" type="text" name="phone" class="input-sm form-control fg-input">
												<label class="fg-label">Teléfono</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line">
												<input value="<?php echo ($reset) ? '' : set_value('link',$this->form_data->link); ?>" type="text" name="link" class="input-sm form-control fg-input">
												<label class="fg-label">Página del comedor</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-right: 0;"></div>
										<div class="fg-float form-group col-xs-12" style="padding-left: 0;padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line">
												<textarea class="form-control auto-size" name="description"><?php echo ($reset) ? '' : set_value('description',$this->form_data->description); ?></textarea>
												<label class="fg-label">Descripción del comedor</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line" data-id="user_name">
												<input value="<?php echo ($reset) ? '' : set_value('user_name',$this->form_data->user_name); ?>" type="text" name="user_name" class="input-sm form-control fg-input">
												<label class="fg-label">Nombre del solicitante</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line" data-id="surname">
												<input value="<?php echo ($reset) ? '' : set_value('surname',$this->form_data->surname); ?>" type="text" name="surname" class="input-sm form-control fg-input">
												<label class="fg-label">Apellido del solicitante</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line" data-id="user_mail">
												<input value="<?php echo ($reset) ? '' : set_value('user_mail',$this->form_data->user_mail); ?>" type="text" name="user_mail" class="input-sm form-control fg-input">
												<label class="fg-label">Mail del solicitante</label>
											</div>
										</div>
										<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
											<div class="fg-line" data-id="alias">
												<input value="<?php echo ($reset) ? '' : set_value('alias',$this->form_data->alias); ?>" type="text" name="alias" class="input-sm form-control fg-input">
												<label class="fg-label">Nombre de usuario del solicitante</label>
											</div>
										</div>
										
										<div class="fg-float form-group col-xs-12" style="padding-left: 0;">
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
											<div class="pmb-block">
												<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Crear</button>
												<a href="<?php echo site_url('home'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>	
											</div>											
										</div>
										<br>
											
										<div class="col-xs-12">
											<?php $this->load->view('templates/alerts'); ?>
										</div>	
											
									</div>
								</form>
                              </div>
							</div>
       
							<br/>
						</div>
					</div>
				</section>

				<input hidden id="redirect-url" value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
				<input hidden id="request-action" value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
				<?php $this->load->view('templates/footer'); ?>

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
		<?php $this->load->view('templates/googleApiMap'); ?>	
		
		<script>
			$(".pmb-block button").click(function() {
				var formData = new FormData($("form")[0]);
				showConfirmDialog({
					title: "¿Está seguro crear este comedor?",
					text: "El comedor se grabará en el sistema",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: formData,
					successText: "Se envió un mail con su contraseña.",
					failedText: "El comedor no pudo ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value,
					containImage: true
				});
				return false;
			}); 
			
        </script>
		
    </body>
</html>