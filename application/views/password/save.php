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
                        <h2>Cambiar contraseña</h2>
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos para cambiar su contraseña.</small>

                            <br/><br/>

                            <div class="row">
                                <div class="card-body card-padding">
								
									<form role="form" action="<?php echo $action; ?>" class="diner-input-form" method="POST">
																			
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="quantity">
														<input type="text" id="oldPassword" name="oldPassword" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('oldPassword',$this->form_data->oldPassword); ?>">
														<label class="fg-label">Contraseña actual</label>
													</div>
												</div>
											</div>
											
											<div class="col-sm-6">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="quantity">
														<input type="text" id="newPassword" name="newPassword" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('newPassword',$this->form_data->newPassword); ?>">
														<label class="fg-label">Nueva contraseña</label>
													</div>
												</div>
											</div>
										</div>								
										
										<?php $this->load->view('templates/alerts'); ?>
										
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
										<a href="<?php echo site_url('home'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
									</form>								
                                </div>
                            </div>
							
                            <br/>
							<br/>
                        </div>

                        <br/>
                    </div>
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
			$('.diner-input-form').submit(function() {
				showConfirmDialog({
					title: "¿Esta seguro?",
					text: "Su contraseña sera modificada",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "La contraseña se ha modificado.",
					failedText: "La contraseña no pudo ser modificada.",
					redirectUrl: $("#redirect-url")[0].value
				});
				return false;
			}); 
			
        </script>
        
    </body>
</html>