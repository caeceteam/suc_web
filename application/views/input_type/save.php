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
        <header id="header" class="media">
            <div class="pull-left h-logo">
                <a href="index.html" class="hidden-xs">
                    SUC
                    <small>Sistema Ãnico de Comedores</small>
                </a>

                <div class="menu-collapse" data-ma-action="sidebar-open" data-ma-target="main-menu">
                    <div class="mc-wrap">
                        <div class="mcw-line top palette-White bg"></div>
                        <div class="mcw-line center palette-White bg"></div>
                        <div class="mcw-line bottom palette-White bg"></div>
                    </div>
                </div>
            </div>

		<?php $this->load->view('templates/header'); ?>

                    <ul class="dropdown-menu pull-right dm-icon">
                        <li>
                            <a href="profile-about.html"><i class="zmdi zmdi-account"></i> Mis Datos</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-settings"></i> Cambiar contraseÃ±a</a>
                        </li>
                    </ul>
                </li>
            </ul>

        </header>
        
        <section id="main">
            <aside id="s-user-alerts" class="sidebar">
                <ul class="tab-nav tn-justified tn-icon m-t-10" data-tab-color="teal">
                    <li><a class="sua-notifications" href="#sua-notifications" data-toggle="tab"><i class="zmdi zmdi-notifications"></i></a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade" id="sua-notifications">
                        <ul class="sua-menu list-inline list-unstyled palette-Orange bg">
                            <li><a href=""><i class="zmdi zmdi-volume-off"></i> Mute</a></li>
                            <li><a href=""><i class="zmdi zmdi-long-arrow-tab"></i> View all</a></li>
                            <li><a href="" data-ma-action="sidebar-close"><i class="zmdi zmdi-close"></i> Close</a></li>
                        </ul>

                        <div class="list-group lg-alt c-overflow">
                            <a href="" class="list-group-item media">
                                <div class="pull-left">
                                    <img class="avatar-img" src="http://uoetsylra.org/img/multimedia/Margarita-Barrientos-Retrato-2-e1378332345443.jpg" alt="">
                                </div>

                                <div class="media-body">
                                    <div class="lgi-heading">Comedor Los piletones</div>
                                    <small class="lgi-text">Solicitud de frazadas</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
			</aside>

            <aside id="s-main-menu" class="sidebar">
                <div class="smm-header">
                    <i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
                </div>

                <ul class="smm-alerts" style="margin: 30px 0 60px 120px; padding-left: 0px;"><!-- TODO CC: Add style to css class-->
                    <li data-user-alert="sua-notifications" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                        <i class="zmdi zmdi-notifications"></i>
                    </li>
                </ul>

                <ul class="main-menu">
                    <li>
                        <a href="index.html"><i class="zmdi zmdi-home"></i> Home</a>
                    </li>
                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-notifications-active"></i> Aprobaciones pendientes</a>

                        <ul>
                            <li><a href="alternative-header.html"> De comedores</a></li>
                            <li><a href="HU001.html"> De personas</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
						<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-local-dining"></i> Comedores</a>
						<ul>
                            <li><a href="index.html"> Eventos</a></li>
							<li><a href="index.html"> Personal</a></li>
                        </ul>
					</li>
                    
                    <li class="sub-menu">
                        <a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-swap-alt"></i> Mantenimiento SUC</a>
                        <ul>
                            <li><a href="colors.html">Insumos</a></li>
                            <li><a href="HU010.html">Tipo de Insumos</a></li>
							<li><a href="animations.html">AsignaciÃ³n de Roles</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
			
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2 style="font-size: 25px;">Crear tipo de Insumo</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos para la creaciÃ³n del tipo de insumo.</small>

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
												<label class="fg-label">CÃ³digo</label>
											</div>
										</div>
										</br>
										<div class="form-group fg-float">
											<div class="fg-line">
												<textarea class="form-control auto-size" id="description" name="description"><?php echo ($reset) ? '' : set_value('description',$this->form_data->description); ?></textarea>
												<label class="fg-label">DescripciÃ³n</label>
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
