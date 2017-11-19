<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SUC</title>
    
        <!-- Vendor CSS -->
        <link href="<?php echo base_url('vendors/bower_components/animate.css/animate.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/google-material-color/dist/palette.css')?>" rel="stylesheet">

        <!-- CSS -->
        <link href="<?php echo base_url('css/app.min.1.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('css/app.min.2.css')?>" rel="stylesheet">
    </head>

    <body data-ma-header="teal">
		<?php $this->load->view('templates/header'); ?>

        <section id="main">
			
			<?php $this->load->view($this->strategy_context->get_menu()); ?>
			
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
							<form role="form" action="<?php echo $action; ?>" method="POST">
							<div class="pmb-block" id="reject-reason-block" hidden>
									<div class="form-group fg-float">
										<div class="fg-line">
											<textarea name="reject_reason" id="reject-reason-textarea" class="form-control auto-size"></textarea>
											<label class="fg-label">Motivo de rechazo</label>
										</div>
									</div>

									<button type="submit" name="rechazar" value="rechazar" id="reject-reason-accept-button" class="btn palette-Green bg">Aceptar</button>
									<a id="reject-reason-cancel-button" class="btn palette-Red bg">Cancelar</a>	
							</div>
							
                            <div class="pmb-block" id="buttons-block">
								<div class="btn-colors btn-demo">
									<button type="submit" name="aprobar" value="aprobar" id="approve-button" class="btn palette-Green bg">Aprobar</button>
									<a id="reject-button" class="btn palette-Red bg">Rechazar</a>
								</div>
                            </div>
                           </form> 
                        </div>
                    </div>
                </div>
            </section>

            <footer id="footer">
                Copyright &copy; 2015 Material Admin

                <ul class="f-menu">
                    <li><a href="">Home</a></li>
                    <li><a href="">Dashboard</a></li>
                    <li><a href="">Reports</a></li>
                    <li><a href="">Support</a></li>
                    <li><a href="">Contact</a></li>
                </ul>
            </footer>
        </section>

        <!-- Page Loader -->
        <div class="page-loader palette-Teal bg">
            <div class="preloader pl-xl pls-white">
                <svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20"/>
                </svg>
            </div>
        </div>
    
        <!-- Javascript Libraries -->
        <script src="<?php echo base_url('vendors/bower_components/jquery/dist/jquery.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
        
		<script src="<?php echo base_url('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/Waves/dist/waves.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bootstrap-growl/bootstrap-growl.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/moment/min/moment.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/autosize/dist/autosize.min.js')?>"></script>
		
        <script src="<?php echo base_url('js/functions.js')?>"></script>
        <script src="<?php echo base_url('js/actions.js')?>"></script>
        <script src="<?php echo base_url('js/demo.js')?>"></script>
		
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
		</script>
    </body>
</html>