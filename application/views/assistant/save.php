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
                        <h2>Crear concurrente</h2>
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos para la creación del concurrente.</small>

                            <br/><br/>

                            <div class="row">
                                <div class="card-body card-padding">
								
									<form role="form" action="<?php echo $action; ?>" class="assistant-form" method="POST">
										<div class="row">
											<div class="form-group fg-float col-sm-6">
												<div class="fg-line" data-id="name">
												<input type="text" id="name" name="name"
													class="input-sm form-control fg-input"
													value="<?php echo ($reset) ? '' : set_value('name', utf8_decode($this->form_data->name)); ?>">
												<label class="fg-label">Nombre</label>
												</div>
											</div>
											
											<div class="form-group fg-float col-sm-6">
												<div class="fg-line" data-id="surname">
													<input type="text" id="surname" name="surname" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('surname', utf8_decode($this->form_data->surname)); ?>">
													<label class="fg-label">Apellido</label>
												</div>
											</div>
											<br/>
											<div class="form-group fg-float col-sm-3">
												<div class="fg-line" data-id="bornDate">
													<input type="text" class="input-sm form-control input-mask fg-input" id="bornDate" name="bornDate" data-mask="0000-00-00" value="<?php echo ($reset) ? '' : set_value('bornDate', $this->form_data->bornDate); ?>">
													<label class="fg-label">Fecha de nacimiento (YYYY-MM-DD)</label>
												</div>
											</div>
											<div class="form-group fg-float col-sm-3">
												<div class="fg-line" data-id="document">
													<input type="text" id="document" name="document" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('document', utf8_decode($this->form_data->document)); ?>">
													<label class="fg-label">Nro. de documento</label>
												</div>
											</div>
											<div class="form-group fg-float col-sm-3">
												<div class="fg-line" data-id="scholarship">
													<input type="text" id="scholarship" name="scholarship" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('scholarship', utf8_decode($this->form_data->scholarship)); ?>">
													<label class="fg-label">Año escolar</label>
												</div>
											</div>
											<div class="form-group fg-float col-sm-3">
												<div class="fg-line" data-id="economicSituation">
													<input type="text" id="economicSituation" name="economicSituation" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('economicSituation', utf8_decode($this->form_data->economicSituation)); ?>">
													<label class="fg-label">Situación ecónimica familiar</label>
												</div>
											</div>
											<br/>
											<div class="fg-float form-group col-sm-6">
												<div class="fg-line">
													<input id="autocomplete" placeholder="" type="text" name="address" class="input-sm form-control fg-input">
													<label class="fg-label">Dirección</label>
													<?php echo form_hidden('street', ($reset) ? '' : set_value('street',$this->form_data->street)); ?>
													<?php echo form_hidden('streetNumber', ($reset) ? '' : set_value('streetNumber',$this->form_data->streetNumber)); ?>
													<?php echo form_hidden('latitude', ($reset) ? '' : set_value('latitude',$this->form_data->latitude)); ?>
													<?php echo form_hidden('longitude', ($reset) ? '' : set_value('longitude',$this->form_data->longitude)); ?>
													<?php echo form_hidden('zipCode', ($reset) ? '' : set_value('zipCode',$this->form_data->zipCode)); ?>
												</div>
											</div>
											<br/>
											<div class="form-group fg-float col-sm-9">
												<div class="fg-line" data-id="contactName">
													<input type="text" id="contactName" name="contactName" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('contactName', utf8_decode($this->form_data->contactName)); ?>">
													<label class="fg-label">Nombre del contacto</label>
												</div>
											</div>	
											<div class="form-group fg-float col-sm-3">
												<div class="fg-line" data-id="phone">
													<input type="text" id="phone" name="phone" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('phone', utf8_decode($this->form_data->phone)); ?>">
													<label class="fg-label">Télefono del contacto</label>
												</div>
											</div>										
											<br/>
											<div class="checkbox col-sm-12">
												<div class="first checkbox col-sm-3">
													<div class="checkbox-component" data-id="celiac">
														<input type="checkbox" id="celiac" name="celiac"
															class="input-sm form-control fg-input"
															value="<?php echo ($reset) ? '' : set_value('celiac',$this->form_data->celiac); ?>"
															<?php echo $this->form_data->celiac == 1? 'checked': '' ?>>
														<i class="input-helper"></i>
														<label for="celiac" class="fg-label">Es celiaco</label>
													</div>
												</div>
												<div class="checkbox col-sm-3">
													<div class="checkbox-component" data-id="diabetic">
														<input type="checkbox" id="diabetic" name="diabetic"
															class="input-sm form-control fg-input"
															value="<?php echo ($reset) ? '' : set_value('diabetic',$this->form_data->diabetic); ?>"
															<?php echo $this->form_data->diabetic == 1? 'checked': '' ?>>
														<i class="input-helper"></i>
														<label for="diabetic" class="fg-label">Es diábetico</label>
													</div>
												</div>
												<div class="checkbox col-sm-6">
													<div class="checkbox-component" data-id="eatAtOwnHouse">
														<input type="checkbox" id="eatAtOwnHouse" name="eatAtOwnHouse"
															class="input-sm form-control fg-input"
															value="<?php echo ($reset) ? '' : set_value('eatAtOwnHouse',$this->form_data->eatAtOwnHouse); ?>"
															<?php echo $this->form_data->eatAtOwnHouse == 1? 'checked': '' ?>>
														<i class="input-helper"></i>
														<label for="eatAtOwnHouse" class="fg-label">Come en la casa</label>
													</div>
												</div>												
											</div>
										</div>
																				
										<?php $this->load->view('templates/alerts'); ?>				                        
										
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
										<a href="<?php echo site_url('assistant') . '/' . $this->form_data->idDiner; ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
										<?php echo form_hidden('idDiner', ($reset) ? '' : set_value('id',$this->form_data->idDiner)); ?>
									</form>								
                                </div>
                            </div>
                        </div>
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
		<?php $this->load->view('templates/googleApiMap'); ?>
		<script src="<?php echo base_url('js/confirmDialogForm.js')?>"></script>
		
		<script>
			$('.assistant-form').submit(function() {
				showConfirmDialog({
					title: "¿Está seguro grabar este concurrente?",
					text: "El concurrente se grabará en el sistema",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action + "/" + $("input[name='idDiner']")[0].value : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: $("form").serializeArray(),
					successText: "El concurrente se ha grabado en el sistema.",
					failedText: "El concurrente no pudo ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value + "/" + $("input[name='idDiner']")[0].value
				});
				return false;
			}); 
			
        </script>
        
    </body>
</html>