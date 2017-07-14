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
                        <h2 style="font-size: 25px;">Crear tipo de Insumo</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos para la creación del tipo de insumo.</small>

                            <br/><br/>

                            <div class="row">
                                <div class="card-body card-padding">
								
									<form role="form" action="<?php echo $action; ?>" class="input-type-form" method="POST">
										<div class="form-group fg-float">
											<div class="fg-line <?php echo form_error('name') == '' ? '' : 'has-error'; ?>">
												<input type="text" id="name" name="name" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>">
												<label class="fg-label"><?php echo form_error('name') == '' ? 'Nombre' : 'El nombre es obligatorio'; ?></label>
											</div>
										</div>
										</br>
										<div class="form-group fg-float">
											<div class="fg-line <?php echo form_error('code') == '' ? '' : 'has-error'; ?>">
												<input type="text" id="code" name="code" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('code',$this->form_data->code); ?>">
												<label class="fg-label"><?php echo form_error('code') == '' ? 'Código' : 'El código es obligatorio'; ?></label>
											</div>
										</div>
										</br>
										<div class="form-group fg-float">
											<div class="fg-line">
												<textarea class="form-control auto-size" id="description" name="description"><?php echo ($reset) ? '' : set_value('description',$this->form_data->description); ?></textarea>
												<label class="fg-label">Descripción</label>
											</div>
										</div>
										
										<?php if ( isset($_ci_vars['failed-message']) && $_ci_vars['failed-message'] !== ''): ?>
										    <div class="alert alert-danger alert-dismissible" role="alert">
				                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				                                <?php echo $_ci_vars['failed-message'] ?>
				                            </div>
										<?php endif; ?>
										
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
										<a href="<?php echo site_url('input_type'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
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
			
			<input hidden id="success-message" value="<?php echo isset($_ci_vars['success-message']) ? $_ci_vars['success-message'] : '' ?>"></input>
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
		
		<script>
			$('.input-type-form').submit(function() { 
				debugger;
				swal({
					title: "¿Está seguro grabar este tipo de insumo?",
					text: "El tipo de insumo se grabará en el sistema",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Si",
					cancelButtonText: "No",
					closeOnConfirm: false,
				}, function(isConfirm){
					debugger;
						if (isConfirm) {
							$.ajax({ 
							       type : "POST",
							       //set the data type
							       dataType:'json',
							       data: $("form").serializeArray(),
							       url: $("form")[0].action, // target element(s) to be updated with server response 
							       cache : false,
							       //check this in Firefox browser
							       success : function(response){ 
							    	   swal("¡Grabado!", "El tipo de insumo se ha grabado en el sistema.", "success");
							       }
							   });        
					  	}
				});	
				return false;
			}); 
        </script>
        
    </body>
</html>