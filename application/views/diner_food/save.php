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
                        <h2>Crear Alimento</h2>
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos para la creaciónn del alimento.</small>

                            <br/><br/>

                            <div class="row">
                                <div class="card-body card-padding">
								
									<form role="form" action="<?php echo $action; ?>" class="diner-food-form" method="POST">
									
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group">
													<div class="fg-line" data-id="idFoodType">
														<div class="select">
															<?php echo form_dropdown('idFoodType', $food_types, $food_type, 'class="form-control"'); ?>
														</div>
													</div>
												</div>
											</div>

											<div class="col-sm-4">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="name">
														<input type="text" id="name" name="name" class="input-sm form-control fg-input" <?php echo ($_ci_vars['request-action'] == "PUT") ? : ''; ?> value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>">
														<label class="fg-label">Nombre</label>
													</div>
												</div>
											</div>
	
											<div class="col-sm-4">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="expirationDate">
														<input type="text" id="expirationDate" name="expirationDate" class="form-control input-mask" data-mask="0000-00-00" value="<?php echo ($reset) ? '' : set_value('expirationDate',$this->form_data->expirationDate); ?>">
														<label class="fg-label">Vencimiento (año-mes-día)</label>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="quantity">
														<input type="text" id="quantity" name="quantity" class="form-control input-mask" data-mask="00000" value="<?php echo ($reset) ? '' : set_value('quantity',$this->form_data->quantity); ?>">
														<label class="fg-label">Cantidad</label>
													</div>
												</div>
											</div>
											
											<div class="col-sm-4">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="quantity">
														<input type="text" id="unity" name="unity" class="input-sm form-control fg-input" placeholder="" value="<?php echo ($reset) ? '' : set_value('unity',$this->form_data->unity); ?>">
														<label class="fg-label">Unidad de Med. (PACK / Gramos / Kg / Litros)</label>
													</div>
												</div>
											</div>
											
											<!-- 
											<div class="col-sm-4">
												<div class="form-group fg-float">
													<div class="fg-line" data-id="creationDate">
														<input type="text" id="creationDate" name="creationDate" class="form-control input-mask" data-mask="0000-00-00" disabled="" value="<?php echo ($reset) ? : set_value('creationDate',$this->form_data->creationDate); ?>">
														<label class="fg-label">Fecha de creación (año-mes-día)</label>
													</div>
												</div>
											</div>
											-->
										</div>
											
										<div class="form-group fg-float">
											<div class="fg-line" data-id="description">
												<textarea class="form-control auto-size" id="description" name="description"><?php echo ($reset) ? '' : set_value('description',$this->form_data->description); ?></textarea>
												<label class="fg-label">Descripción</label>
											</div>
										</div>
										
										<?php $this->load->view('templates/alerts'); ?>
										
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
										<a href="<?php echo site_url('diner_food'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
										<?php echo form_hidden('creationDate', ($reset) ? '' : set_value('creationDate',$this->form_data->creationDate)); ?>
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
			$('.diner-food-form').submit(function() {
				showConfirmDialog({
					title: "¿Está seguro grabar este alimento?",
					text: "El alimento se grabará en el sistema",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "El alimento se ha grabado en el sistema.",
					failedText: "El alimento no pudo ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value
				});
				return false;
			}); 
			
        </script>
    </body>
</html>