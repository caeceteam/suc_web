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
								
									<form role="form" action="<?php echo $action; ?>" method="POST">
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
        

    </body>
</html>