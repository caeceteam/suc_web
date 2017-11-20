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
						<h2 style="font-size: 25px;">Solicitud de alta</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>  

                    <div class="card" id="profile-main">
                        <div class="pm-overview c-overflow">
                            <div class="pmo-pic">
                                <div class= "animated fadeInDown"><!-- "p-relative"> -->
                                    <img class="img-responsive" src="<?php echo $this->form_data->photo; ?>" alt="">
                                </div>

                                <div class="pmo-stat"> <!--pmo-stat-->
									<h2 class="m-0 c-white"><?php echo $this->form_data->user_name . ' ' . $this->form_data->surname; ?></h2>
                                </div>
                            </div>
                        </div>
  
                        <div class="pm-body clearfix">
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-account m-r-5"></i>Información del solicitante</h2>
								</div>
                                <div class="pmbb-body p-l-30">
									<div class="pmbb-view">
                                        <dl class="dl-horizontal">
                                            <dt>Nombre Completo</dt>
                                            <dd><?php echo $this->form_data->user_name . ' ' . $this->form_data->surname; ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Email</dt>
                                            <dd><?php echo $this->form_data->user_mail; ?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div> 


                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-phone m-r-5"></i> Información del comedor</h2>
								</div>
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                        <dl class="dl-horizontal">
                                            <dt>Nombre</dt>
                                            <dd><?php echo $this->form_data->diner_name; ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Dirección</dt>
                                            <dd><?php echo $this->form_data->street . ' ' . $this->form_data->streetNumber . ' ' . (empty($this->form_data->floor) ? '' : $this->form_data->floor) . ' ' . (empty($this->form_data->door) ? '' : $this->form_data->door); ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Teléfono</dt>
                                            <dd><?php echo $this->form_data->diner_phone; ?></dd>
                                        </dl>
                                    </div>
								</div>
                            </div>		
							<form class="diner-application-form" role="form" action="<?php echo $action; ?>" method="POST">
								<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
								<?php echo form_hidden('diner_name', ($reset) ? '' : set_value('id',$this->form_data->diner_name)); ?>
								<?php echo form_hidden('id_user', ($reset) ? '' : set_value('id_user',$this->form_data->id_user)); ?>
								<?php echo form_hidden('alias', ($reset) ? '' : set_value('alias',$this->form_data->alias)); ?>
								<?php echo form_hidden('user_mail', ($reset) ? '' : set_value('user_mail',$this->form_data->user_mail)); ?>
								
								<div class="pmb-block" id="reject-reason-block" hidden>
										<div class="form-group fg-float">
											<div class="fg-line" data-id="reject_reason">
												<textarea name="reject_reason" id="reject-reason-textarea" class="form-control auto-size"></textarea>
												<label class="fg-label">Motivo de rechazo</label>
											</div>
										</div>
	
										<a name="rechazar" value="rechazar" id="reject-reason-accept-button" class="btn palette-Green bg">Aceptar</a>
										<a id="reject-reason-cancel-button" class="btn palette-Red bg">Cancelar</a>	
								</div>
								
	                            <div class="pmb-block" id="buttons-block">
									<div class="btn-colors btn-demo">
										<button type="submit" name="aprobar" value="aprobar" id="approve-button" class="btn palette-Green bg">Aprobar</button>
										<a id="reject-button" class="btn palette-Red bg">Rechazar</a>
										<a id="cancel-button" href="<?php echo site_url('admin_application')?>" class="btn btn-primary">Cancelar</a>
									</div>
	                            </div>
                           </form> 
                           
                           <?php $this->load->view('templates/alerts'); ?>
                        </div>
                    </div>
                </div>
                
                <input hidden id="redirect-url" value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
                <input hidden id="request-action" value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
				<input hidden id="reject-url" value="<?php echo isset($_ci_vars['reject-url']) ? $_ci_vars['reject-url'] : '' ?>"></input>
                
            </section>

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
		
		<script type="text/javascript">
			$("#reject-button").click(function() {
				$("#buttons-block").hide();
				$("#reject-reason-block").show();
			});
		
			$("#reject-reason-cancel-button").click(function() {
				$("#buttons-block").show();
				$("#reject-reason-block").hide();
				$("#reject-reason-textarea").val("");
				$("#reject-reason-textarea").attr("style", "overflow: hidden; word-wrap: break-word;")
			});

			$(".diner-application-form").submit(function() {
				showConfirmDialog({
					title: "¿Está seguro que desea aprobar esta solicitud?",
					text: "La solicitud será aprobada en el sistema",
					requestUrl: $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "La solicitud ha sido aprobada.",
					failedText: "Hubo un error al aprobar la solicitud.",
					redirectUrl: $("#redirect-url")[0].value,
					successTitle: "Aprobado"
				});
				return false;
			});

			$("#reject-reason-accept-button").click(function() {
				showConfirmDialog({
					title: "¿Está seguro que desea rechazar esta solicitud?",
					text: "La solicitud será rechazada en el sistema",
					requestUrl: $("#reject-url")[0].value,
					formData: $("form").serializeArray(),
					successText: "La solicitud ha sido rechazada.",
					failedText: "Hubo un error al rechazar la solicitud.",
					redirectUrl: $("#redirect-url")[0].value,
					successTitle: "Rechazado"
				});
				return false;
			});
		</script>
    </body>
</html>