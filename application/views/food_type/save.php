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
                        <h2>Crear tipo de Alimento</h2>
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos para la creación del tipo de alimento.</small>

                            <br/><br/>

                            <div class="row">
                                <div class="card-body card-padding">
								
									<form role="form" action="<?php echo $action; ?>" class="food-type-form" method="POST" enctype="multipart/form-data">
										<div class="form-group fg-float">
											<div class="fg-line" data-id="name">
												<input type="text" id="name" name="name" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('name', utf8_decode($this->form_data->name)); ?>">
												<label class="fg-label">Nombre</label>
											</div>
										</div>
										<br/>
										<div class="form-group fg-float">
											<div class="fg-line" data-id="code">
												<input type="text" id="code" name="code" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('code', utf8_decode($this->form_data->code)); ?>">
												<label class="fg-label">Código</label>
											</div>
										</div>
										<br/>
										<div class="form-group fg-float">
											<div class="fg-line" data-id="description">
												<textarea class="form-control auto-size" id="description" name="description"><?php echo ($reset) ? '' : set_value('description', utf8_decode($this->form_data->description)); ?></textarea>
												<label class="fg-label">Descripción</label>
											</div>
										</div>
										<div class="checkbox" id="perishable" name="perishable">
											<?php echo form_checkbox('perishable',  $this->form_data->perishable, $this->form_data->perishable == 1 );?>
											<i class="input-helper"></i> <label class="fg-label"> Alimento con fecha de expiración.  </label>	
											</div>
										</br>
										<div class="checkbox" id="celiac" name="celiac">
											<?php echo form_checkbox('celiac',  $this->form_data->celiac, $this->form_data->celiac == 1 );?>
											<i class="input-helper"></i> <label class="fg-label"> Alimento apto para celíacos. </label>	
										</div>
										</br>
										<div class="checkbox" id="diabetic" name="diabetic">
											<?php echo form_checkbox('diabetic',  $this->form_data->diabetic, $this->form_data->diabetic == 1 );?>
											<i class="input-helper"></i> <label class="fg-label"> Alimento apto para diabéticos. </label>
	
										</div>
										</br>
										
										<?php $this->load->view('templates/alerts'); ?>			                        
										
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
										<a href="<?php echo site_url('food_type'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
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
			$('.food-type-form').submit(function() {
				showConfirmDialog({
					title: "¿Está seguro grabar este tipo de alimento?",
					text: "El tipo de alimento se grabará en el sistema",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "El tipo de alimento se ha grabado en el sistema.",
					failedText: "El tipo de alimento no pudo ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value
				});
				return false;
			}); 
			
        </script>
        
    </body>
</html>