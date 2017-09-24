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
                    <!-- <div class="c-header">
                        <h2>Home</h2>
                    </div>
					 -->
					
                    <div id="c-grid" class="clearfix" data-columns>

                        
                        <!-- Todo Lists -->
                        <div class="card" id="todo-lists">
                            <div class="card-header ch-dark palette-Orange-400 bg">
                                <h2>Lista de aprobaciones pendientes <small>Existe un total de 5 aprobaciones pendientes	</small></h2>
                            </div>

                            <div class="card-body">
                                <div class="list-group lg-alt">
                                    <div class="list-group-item-header palette-Orange text">Notificaciones</div>

                                    <a href="<?php echo base_url('admin_application');?>" class="list-group-item media">
                                        <div class="pull-left">
                                            <img class="avatar-img" src="vendors/bower_components/material-design-iconic-font/svg/2.1/01 - web application/cutlery.svg" alt="">
                                        </div>

                                        <div class="media-body">
                                            <div class="lgi-heading">Aprobaciones de comedores</div>
                                            <small class="lgi-text"><?php echo $this->form_data->pending_approvals; ?></small>
                                        </div>
                                    </a>

                                    <a href="" class="list-group-item media">
                                        <div class="pull-left">
                                            <img class="avatar-img" src="vendors/bower_components/material-design-iconic-font/svg/google/action/account-circle.svg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <div class="lgi-heading">Aprobaciones de personas</div>
                                            <small class="lgi-text">1 aprobacion/es pendiente/s</small>
                                        </div>
                                    </a>
                                </div>                                
                            </div>
                        </div>
						<!-- Contact -->
                        <div class="card">
                            <!--<div class="card-header ch-alt">-->
                            <div class="card-header ch-dark palette-Blue-300 bg">
                                <h2>Comedor suscripto <small>Información relacionada</small></h2>
                            </div>
                            <div class="card-body card-padding">
                                <div class="pmo-contact">
                                    <ul>
                                    	<li class="ng-binding"><i class="zmdi zmdi-cutlery"></i> Comedor: Juventud</li>
                                        <li>
                                            <i class="zmdi zmdi-pin"></i>
                                            <address class="m-b-0 ng-binding">
                                                Dirección: Calle falsa 123
                                            </address>
                                        </li>
                                        <li class="ng-binding"><i class="zmdi zmdi-phone"></i> Teléfono: 1234567890</li>
                                        <li class="ng-binding"><i class="zmdi zmdi-calendar-check"></i> Cantidad de eventos actuales: 3</li>
                                        <li class="ng-binding"><i class="zmdi zmdi-account-circle"></i> Personas suscrpitas: 34</li>
										<li class="ng-binding"><i class="zmdi zmdi-comment-edit"></i> Solicitudes a comedores: 1</li>
										<li class="ng-binding"><i class="zmdi zmdi-walk"></i> Cantidad de concurrentes: 12</li>
                                    </ul>
                                </div>
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

		<!-- Javascript Libraries -->
        <?php $this->load->view('templates/scripts'); ?>
        
		<script src="<?php echo base_url('vendors/bower_components/flot/jquery.flot.js')?>"></script>
		<script src="<?php echo base_url('vendors/bower_components/flot/jquery.flot.resize.js')?>"></script>
		<script src="<?php echo base_url('vendors/bower_components/flot.curvedlines/curvedLines.js')?>"></script>
		<script src="<?php echo base_url('vendors/sparklines/jquery.sparkline.min.js')?>"></script>
		<script src="<?php echo base_url('vendors/bower_components/salvattore/dist/salvattore.min.js')?>"></script>
		
		<script src="<?php echo base_url('js/flot-charts/curved-line-chart.js')?>"></script>
		<script src="<?php echo base_url('js/flot-charts/bar-chart.js')?>"></script>
		<script src="<?php echo base_url('js/charts.js')?>"></script>

    </body>
  </html>