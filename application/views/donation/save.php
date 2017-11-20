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
                        <h2>Solicitud de donación</h2>
                    </div>

                    <div class="card">
                    	<div class="pm-body clearfix">
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h4 style="margin-left: 30px;margin-top: 20px;margin-bottom: 25px;"><i class="zmdi zmdi-account m-r-5"></i>Información de la donación</h4>
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
                                    <h4 style="margin-left: 30px;margin-top: 20px;margin-bottom: 25px;"><i class="zmdi zmdi-account m-r-5"></i>Items de la donación</h4>
								</div>
                    		</div>
                    		
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
							</div>
                    	</div>
                    
                        <div class="card-body card-padding">
                            <div class="row">
                                <div class="card-body card-padding">
								
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