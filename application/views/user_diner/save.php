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
						<h2 style="font-size: 25px;">Datos personales</h2> 
                    </div>
                    
                    <div class="card">
                    <div class="card" id="profile-main">
                        <div class="pm-overview c-overflow">
                            <div class="pmo-pic">
                                <div class= "animated fadeInDown"><!-- "p-relative"> -->
                                    <img class="img-responsive" src="<?php echo base_url('img/profile-pics/profile-pic-2.jpg')?>" alt="">
                                </div>

                                <div class="pmo-stat"> <!--pmo-stat-->
								<h2 class="m-0 c-white"><?php echo $this->form_data->name . ' ' . $this->form_data->surname; ?></h2> 
                                </div>
                            </div>
                        </div>
  
                        <div class="pm-body clearfix">
                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-account m-r-5"></i>Información Básica</h2>
								</div>
                                <div class="pmbb-body p-l-30">
									<div class="pmbb-view">
                                        <dl class="dl-horizontal">
                                            <dt>Nombre</dt>
                                            <dd>
                                            <!-- Genera la linea Azul en la selección -->
                                        	<div class="fg-line">
                                        	<input type="text" class="form-control input-sm" id="name"
												value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>">
											</div>
											</dd>	
                                        	</dl>
                                        <dl class="dl-horizontal">
                                            <dt>Apellido</dt>
                                            <dd>
                                        	<!-- Genera la linea Azul en la selección -->
                                        	<div class="fg-line">
                                        	<input type="text" class="form-control input-sm" id="surname"
												value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->surname); ?>">
											</div>
											</dd>	
											</dl>
										<dl class="dl-horizontal">
                                            <dt>Fecha nacimiento</dt>
                                            <dd>
                                            <!-- Genera la linea Azul en la selección -->
                                        	<div class="fg-line">
                                            <input type="text" class="form-control input-sm" id="bornDate"
												value="<?php echo ($reset) ? '' : set_value('bornDate',$this->form_data->bornDate); ?>" placeholder="DD/MM/AAAA">
                                            </div>
                                           <dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Número de documento</dt>
                                            <dd>
                                        	<div class="fg-line">
                                            <input type="text" class="form-control input-sm" id="docNum"
												value="<?php echo ($reset) ? '' : set_value('docNum',$this->form_data->docNum); ?>">
											</div>
											</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div> 


                            <div class="pmb-block">
                                <div class="pmbb-header">
                                    <h2><i class="zmdi zmdi-phone m-r-5"></i> Información de Contacto</h2>
								</div>
								
                                <div class="pmbb-body p-l-30">
                                    <div class="pmbb-view">
                                        <dl class="dl-horizontal">
                                            <dt>Teléfono particular</dt>
                                            <dd>
                                        	<div class="fg-line">
                                            <input type="text" class="form-control input-sm" id="phone"
												value="<?php echo ($reset) ? '' : set_value('phone',$this->form_data->phone); ?>">
											</div>
											</dd>
                                        </dl>
                                        <dl class="dl-horizontal">
                                            <dt>Email particular</dt>
                                                    <dd>
                                        	<div class="fg-line">
                                            <input type="text" class="form-control input-sm" id="mail"
												value="<?php echo ($reset) ? '' : set_value('mail',$this->form_data->mail); ?>">
											</div>
											</dd>
                                        </dl>
                                       <dl class="dl-horizontal">
                                            <dt>Dirección del comedor</dt>
                                            <dd>
                                        	<div class="fg-line">
                                            <input type="text" class="form-control input-sm" id="diner"
												value="<?php echo ($reset) ? '' : set_value('diner',($this->form_data->street . ' ' . $this->form_data->streetNumber . ' ' . (empty($this->form_data->floor) ? '' : $this->form_data->floor) . ' ' . (empty($this->form_data->door) ? '' : $this->form_data->door))); ?>">
											</div>
											</dd>
                                        </dl>
                                    </div>
								</div>
                            </div>		
							<form role="form" action="<?php echo $action; ?>"  method="POST">
							<div class="pmb-block" id="reject-reason-block" hidden>
										<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
										<a href="<?php echo site_url('user_diner'); ?>" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('idUser', ($reset) ? '' : set_value('idUser',$this->form_data->id)); ?>
							</div>
							</form>	
							</div>
                        </div>
                    </div>
                </div>
            </section>

            <?php $this->load->view('templates/footer'); ?>
        </section>

	<!-- Page Loader -->
	<div class="page-loader palette-Teal bg">
		<div class="preloader pl-xl pls-white">
			<svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>
		</div>
	</div>

		<?php $this->load->view('templates/scripts'); ?>
		<script src="vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    </body>
</html>