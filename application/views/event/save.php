<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SUC</title>
	
        <?php $this->load->view('templates/styles'); ?>
        <link href="<?php echo base_url('vendors/bower_components/lightgallery/dist/css/lightgallery.min.css')?>" rel="stylesheet">
    </head>

    <body data-ma-header="teal">
    
        <?php $this->load->view('templates/header'); ?>
        
        <section id="main">
        
            <?php $this->load->view($this->strategy_context->get_menu()); ?>
        
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2 style="font-size: 25px;">Crear/Editar evento</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos correspondientes al evento que desee editar en el sistema SUC.</small>

                            <br/><br/>
                            
                                <div class="card-body card-padding">
									<form class="event-form" role="form" action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
										<div class="row">
											<div class="fg-float form-group col-xs-12" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line" data-id="name">
													<input type="text" name="name" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('name',utf8_decode($this->form_data->name)); ?>">
													<label class="fg-label">Nombre del evento</label>
												</div>
											</div>
											
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line" data-id="street">
													<input id="autocomplete" placeholder="" type="text" name="address" class="input-sm form-control fg-input">
													<label class="fg-label">Direcci�n del evento</label>
													<?php echo form_hidden('street', ($reset) ? '' : set_value('street',utf8_decode($this->form_data->street))); ?>
													<?php echo form_hidden('streetNumber', ($reset) ? '' : set_value('streetNumber',$this->form_data->streetNumber)); ?>
													<?php echo form_hidden('latitude', ($reset) ? '' : set_value('latitude',$this->form_data->latitude)); ?>
													<?php echo form_hidden('longitude', ($reset) ? '' : set_value('longitude',$this->form_data->longitude)); ?>
													<?php echo form_hidden('zipCode', ($reset) ? '' : set_value('zipCode',$this->form_data->zipCode)); ?>
												</div>
											</div>
											<div class="fg-float form-group col-xs-3" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input type="text" name="floor" class="input-sm form-control fg-input"  value="<?php echo ($reset) ? '' : set_value('floor',$this->form_data->floor); ?>">
													<label class="fg-label">Piso (opcional)</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-3" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input type="text" name="door" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('door',$this->form_data->door); ?>">
													<label class="fg-label">Dto. (opcional)</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line" data-id="phone">
													<input type="text" name="phone" class="input-sm form-control fg-input" value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->phone); ?>">
													<label class="fg-label">Tel�fono (opcional)</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input type="text" name="link" class="input-sm form-control fg-input"  value="<?php echo ($reset) ? '' : set_value('link',$this->form_data->link); ?>">
													<label class="fg-label">Link del evento (opcional)</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line" data-id="date">
													<input type="text" name="date" class="input-sm form-control fg-input input-mask" data-mask="0000-00-00" value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->date); ?>">
													<label class="fg-label">Fecha (a�o-mes-d�a) (opcional)</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-6" style="padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line" data-id="time">
													<input type="text" name="time" class="input-sm form-control fg-input input-mask" data-mask="00:00"  value="<?php echo ($reset) ? '' : set_value('link',$this->form_data->time); ?>">
													<label class="fg-label">Hora (hora:minutos) (opcional)</label>
												</div>
											</div>
											<div class="fg-float form-group col-xs-12" style="padding-left: 0;padding-right: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<textarea class="form-control auto-size" name="description"><?php echo ($reset) ? '' : set_value('description',utf8_decode($this->form_data->description)); ?></textarea>
													<label class="fg-label">Descripci�n del evento (opcional)</label>
												</div>
											</div>
											
											<p><b>Im�genes</b></p>
											<p>Galer�a</p>
											
											<div id="photo-gallery-container" class="row">
												<?php 
													if ( isset($this->form_data->photos) && count($this->form_data->photos) > 0)
													{
														echo '<div class="lightbox">';
														foreach($this->form_data->photos as $photo)
														{
															echo
															'<div data-src="' . $photo['url'] . '" data-idPhoto="' . $photo['idPhoto'] . '" class="image-item col-sm-2">
					                                   				<div class="lightbox-item">
					                                       				<img src="' . $photo['url'] . '" alt="" />
								                                   	</div>
	        														<div>
																		<a data-idPhoto="' . $photo['idPhoto'] . '" style="margin-bottom:10px; margin-top:3px;" class="btn remove-event-photo-btn btn-danger fileinput-exists waves-effect" data-dismiss="fileinput">Quitar</a>
																	</div>
	        													</div>';
														}
														echo '</div>';
													}
													else 
													{
														echo
														'<p class="col-xs-12" style="font-weight: bold;"> No hay im�genes cargadas </p>';
														
													}
												?>
				                            </div>
											<br/>
											<p>Seleccione la imagen que desee subir del evento.</p>
											<div class="fileinput fileinput-new" data-provides="fileinput">
												<div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
												<div>
													<span class="btn btn-info btn-file">
														<span class="fileinput-new">Seleccionar archivo</span>
														<span class="fileinput-exists">Cambiar</span>
														<input type="file" name="photo" id="photo">
													</span>
													<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Quitar</a>
												</div>
											</div>

											<br/>
											<br/>
											
											<div class="pmb-block">
												<?php echo form_hidden('id', ($reset) ? '' : set_value('id', $this->form_data->id)); ?>
												
												<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Guardar</button>
												<a href="<?php echo site_url('event'); ?>" class="btn btn-danger btn-sm m-t-10 waves-effect">Cancelar</a>	
											</div>

											</br>
											
											<?php $this->load->view('templates/alerts'); ?>
											
										</div>
									</form>
                                </div>
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
		<?php $this->load->view('templates/googleApiMap'); ?>		
		<script src="<?php echo base_url('vendors/bower_components/lightgallery/dist/js/lightgallery-all.min.js')?>"></script>
		<script src="<?php echo base_url('vendors/fileinput/fileinput.min.js')?>"></script>
		<script src="<?php echo base_url('vendors/farbtastic/farbtastic.min.js')?>"></script>
		<script src="<?php echo base_url('js/confirmDialogForm.js')?>"></script>
		
		<script>
			$(".remove-event-photo-btn").click(function() {
				var idPhoto = this.getAttribute("data-idphoto");
				swal({
					title: "�Est� seguro que desea borrarla imagen?",
					text: "La im�gen se borrar� del sistema",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Si",
					cancelButtonText: "No",
					closeOnConfirm: false,
				}, function(isConfirm){
					if (isConfirm) {
						$.ajax({
							type : 'POST',
							data: {
								idEvent: $("input[name='id']").val(),
								idDiner: $("input[name='idDiner']").val(),
								idPhoto: idPhoto
							},
					       	url: "<?php echo site_url('event/deleteEventImage/') ?>", // target element(s) to be updated with server response 
					       	cache : false,
					       	success : function(response){
						       	$("div.image-item[data-idPhoto=" + idPhoto + "]").remove();
						       	if ($("div.image-item").size() === 0) {
									$("#photo-gallery-container").append("<p class='col-xs-12' style='font-weight: bold;'> No hay im�genes cargadas </p>");
							    }
						       	 
					       	   	swal({
					       			title: "Borrado", 
					       			text: "La imagen fue borrada exitosamente", 
					       			type: "success"
					       		});
					       	},
					       	error : function(response){
					       		swal({
					       	   		title: "Error", 
					       	   		text: "Hubo un problema en el sistema", 
					       	   		type: "error"
					       	   	});		       
					       	}
						}); 
					}
				});
				$('.lightbox').data('lightGallery').destroy(false);
			});
		</script>
		
		<script>
			$('.event-form').submit(function() {
				var formData = new FormData($("form")[0]);
				showConfirmDialog({
					title: "�Est� seguro editar este evento?",
					text: "El evento se grabar� en el sistema",
					requestUrl: $("#request-action")[0].value === "POST" ? $("form")[0].action : $("form")[0].action + "/" + $("input[name='id']")[0].value,
					formData: formData,
					successText: "El evento se ha grabado en el sistema.",
					failedText: "El evento no pudo ser grabado en el sistema.",
					redirectUrl: $("#redirect-url")[0].value,
					containImage: true
				});
				return false;
			}); 
			
        </script>		
    </body>
</html>