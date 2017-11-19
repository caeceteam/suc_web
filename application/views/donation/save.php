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
			
			<?php $this->load->view($this->strategy_context->get_menu()); ?>
			
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2>Tratar Donación</h2>
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Apruebe o rechace la donación.</small>

                            <br/><br/>

                            <div class="row">
                                <div class="card-body card-padding">
								
									<form role="form" action="<?php echo $action; ?>" class="donation-form" method="POST" enctype="multipart/form-data">
										<div class="form-group fg-float col-xs-6" style="padding-left: 0;">
											<div class="fg-line" data-id="name">
												<input type="text" id="title" name="title" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('title', utf8_decode($this->form_data->title)); ?>">
												<label class="fg-label">Título</label>
											</div>
										</div>
										<div class="form-group fg-float col-xs-6" style="padding-left: 0;">
											<div class="fg-line" data-id="name">
												<input type="text" id="nameUserSender" name="nameUserSender" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('nameUserSender', utf8_decode($this->form_data->nameUserSender)); ?>">
												<label class="fg-label">Donado por</label>
											</div>
										</div>
										<br/>
										<div class="form-group fg-float col-xs-6" style="padding-left: 0;">
											<div class="fg-line" data-id="creationDate">
												<input type="text" id="creationDate" name="creationDate" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('creationDate', $this->form_data->creationDate); ?>">
												<label class="fg-label">Fecha de creación</label>
											</div>
										</div>
										<div class="form-group fg-float col-xs-6" style="padding-left: 0;">
											<div class="fg-line" data-id="creationTime">
												<input type="text" id="creationTime" name="creationTime" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('creationTime', $this->form_data->creationTime); ?>">
												<label class="fg-label">Hora de creación</label>
											</div>
										</div>
										<br/>
										<div class="form-group fg-float">
											<div class="fg-line" data-id="description">
												<textarea class="form-control auto-size" id="description" name="description"><?php echo ($reset) ? '' : set_value('description', utf8_decode($this->form_data->description)); ?></textarea>
												<label class="fg-label">Descripción</label>
											</div>
										</div>
										</br>
										<?php $this->load->view('templates/alerts'); ?>
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Aceptar</button>
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Rechazar</button>
										<a href="<?php echo site_url('donation'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
										<?php echo form_hidden('idUserSender', ($reset) ? '' : set_value('idUserSender',$this->form_data->idUserSender)); ?>
										<?php echo form_hidden('idDinerReceiver', ($reset) ? '' : set_value('idDinerReceiver',$this->form_data->idDinerReceiver)); ?>
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
		<script src="<?php echo base_url('js/inputTypeForm.js')?>"></script>
		<script src="<?php echo base_url('js/confirmDialogForm.js')?>"></script>
		
		<script>
			$('.donation-form').submit(function() {
				showConfirmDialog({
					title: "Se grabarán las acciones",
					text: "",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "Se ha aprobado/rechazado la donación.",
					failedText: "No se pudo aprobar/rechazar la donación.",
					redirectUrl: $("#redirect-url")[0].value
				});
				return false;
			}); 
			
        </script>
        
    </body>
</html>