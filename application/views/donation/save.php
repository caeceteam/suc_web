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
                        <h2>Solicitud de donación</h2>
                    </div>

                    <div class="card">
                    	<div class="pm-body clearfix">
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h4 style="margin-left: 30px;margin-top: 20px;margin-bottom: 25px;"><i class="zmdi zmdi-info m-r-5"></i>Información de la donación</h4>
								</div>
                                <div class="pmbb-body p-l-30" style="padding-left: 50px !important;padding-right: 40px !important;">
									<div class="pmbb-view" style="width: 40%; float:left">
                                        <dl class="dl-horizontal" >
                                            <dt>Título</dt>
                                            <dd style="margin-left: 150px;"><?php echo utf8_decode($this->form_data->title); ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Donado por</dt>
                                            <dd style="margin-left: 150px;"><?php echo utf8_decode($this->form_data->nameUserSender); ?></dd>
                                        </dl>
                                    </div>
                                    <div class="pmbb-view" style="width: 60%; float:right">
                                        <dl class="dl-horizontal">
                                            <dt>Fecha de creación</dt>
                                            <dd style="margin-left: 150px;"><?php echo $this->form_data->creationDate.' '.$this->form_data->creationTime; ?></dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Descripción</dt>
                                            <dd style="margin-left: 160px;"><?php echo utf8_decode($this->form_data->description); ?></dd>
                                        </dl>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    	<div class="pm-body clearfix">
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h4 style="margin-left: 30px;margin-top: 20px;margin-bottom: 25px;"><i class="zmdi zmdi-format-list-bulleted m-r-5"></i>Items de la donación</h4>
								</div>
								
								<div class="pmbb-body p-l-30" style="padding-left: 50px !important;padding-right: 40px !important;">
									<div class="table-responsive">
		                            	<table class="table table-hover">
			                            	<thead>
			                                    <tr>
			                                        <th>Descripción</th>
			                                        <th>Cantidad</th>
			                                    </tr>
			                                </thead>
		                                	<tbody>
		                                    	<?php 
													foreach($this->form_data->items as $donation_item)
													{
														echo '<tr>
		        											<td>' . $donation_item['description'] . '</td>
		        											<td>' . $donation_item['quantity'] . '</td>
		        										</tr>';
													}
												?>
		                                    </tbody>
		                            	</table>
		                            	
		                            	<form class="donation-form" role="form" action="<?php echo $action; ?>" method="POST">
											<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
											<?php echo form_hidden('idUserSender', ($reset) ? '' : set_value('idUserSender',$this->form_data->idUserSender)); ?>
											<?php echo form_hidden('idDinerReceiver', ($reset) ? '' : set_value('idDinerReceiver',$this->form_data->idDinerReceiver)); ?>
											<?php echo form_hidden('title', ($reset) ? '' : set_value('title',$this->form_data->title)); ?>
											<?php echo form_hidden('description', ($reset) ? '' : set_value('description',$this->form_data->description)); ?>
											<?php echo form_hidden('creationDate', ($reset) ? '' : set_value('creationDate',$this->form_data->creationDate)); ?>
										
											<div class="pmb-block" id="reject-reason-block" hidden style="margin-top: 65px; margin-bottom: 30px;">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="reject_reason">
														<textarea name="reject_reason" id="reject-reason-textarea" class="form-control auto-size"></textarea>
														<label class="fg-label">Motivo de rechazo</label>
													</div>
												</div>
					
												<a name="rechazar" value="rechazar" id="reject-reason-accept-button" class="btn palette-Green bg">Aceptar</a>
												<a id="reject-reason-cancel-button" class="btn palette-Red bg">Cancelar</a>	
											</div>
												
					                        <div class="pmb-block" id="buttons-block" style="margin-top: 65px; margin-bottom: 30px;">
												<div class="btn-colors btn-demo">
													<button type="submit" name="aprobar" value="aprobar" id="approve-button" class="btn palette-Green bg">Aprobar</button>
													<a id="reject-button" class="btn palette-Red bg">Rechazar</a>
													<a id="cancel-button" href="<?php echo site_url('donation')?>" class="btn btn-primary">Cancelar</a>
												</div>
					                        </div>
										</form> 
										
										<?php $this->load->view('templates/alerts'); ?>
									</div>										
								
								</div>
														
                    		</div>
                    	</div>

						
                    </div>
                </div>
            </section>

			<?php $this->load->view('templates/footer'); ?>
			
			<input hidden id="redirect-url" value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
			<input hidden id="request-action" value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
			<input hidden id="reject-url" value="<?php echo isset($_ci_vars['reject-url']) ? $_ci_vars['reject-url'] : '' ?>"></input>

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

			$(".donation-form").submit(function() {
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