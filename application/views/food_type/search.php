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
        <link href="<?php echo base_url('vendors/bootgrid/jquery.bootgrid.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/google-material-color/dist/palette.css')?>" rel="stylesheet">

        <!-- CSS -->
        <link href="<?php echo base_url('css/app.min.1.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('css/app.min.2.css')?>" rel="stylesheet">
    </head>

    <body data-ma-header="teal">
        <header id="header" class="media">
            <div class="pull-left h-logo">
                <a href="index.html" class="hidden-xs">
                    SUC
                    <small>Sistema Único de Comedores</small>
                </a>

                <div class="menu-collapse" data-ma-action="sidebar-open" data-ma-target="main-menu">
                    <div class="mc-wrap">
                        <div class="mcw-line top palette-White bg"></div>
                        <div class="mcw-line center palette-White bg"></div>
                        <div class="mcw-line bottom palette-White bg"></div>
                    </div>
                </div>
            </div>

            <ul class="pull-right h-menu">
                <li class="hm-alerts" data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                    <a href=""><i class="hm-icon zmdi zmdi-notifications"></i></a>
                </li>
                <li class="dropdown hm-profile">
                    <a data-toggle="dropdown" href="">
                        <img src="<?php echo base_url('img/profile-pics/1.jpg')?>" alt="">
                    </a>

                    <ul class="dropdown-menu pull-right dm-icon">
                        <li>
                            <a href="profile-about.html"><i class="zmdi zmdi-account"></i> Mis Datos</a>
                        </li>
                        <li>
                            <a href=""><i class="zmdi zmdi-settings"></i> Cambiar contraseña</a>
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
                            <li><a href="animations.html">Tipo de Insumos</a></li>
  							<li><a href="animations.html">Asignación de Roles</a></li>
                        </ul>
                    </li>
                </ul>
            </aside>
			
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2 style="font-size: 25px;">Tipos de alimento</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

					<div class="card">
						<div class="card-body card-padding">
							<form class="row" role="form">
                                <div class="col-sm-4">
                                    <div style="position: relative;display: block;margin-top: 10px;margin-bottom: 10px;"> <!--TODO CC: Pass style inline to css class-->
                                        <label>
                                            ¿Desea crear un nuevo tipo de alimento?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <a href="<?php echo base_url('Food_type/add');?>" class="btn btn-primary btn-sm m-t-5 waves-effect">Crear</a>
                                </div>
                            </form>			
						</div>
					</div>					
			        <div class="card">
						<div class="card-body card-padding" style="padding-bottom:0"></div> <!--TODO CC: Pass style inline to css class-->
							<?php echo $table?>
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
        <script src="<?php echo base_url('vendors/bootgrid/jquery.bootgrid.updated.min.js')?>"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="<?php echo base_url('vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js')?>"></script>
        <![endif]-->
        
        <script src="<?php echo base_url('js/functions.js')?>"></script>
        <script src="<?php echo base_url('js/actions.js')?>"></script>
        <script src="<?php echo base_url('js/demo.js')?>"></script>

        <!-- Data Table -->
        <script type="text/javascript">
            $(document).ready(function(){
                //Basic Example
                $("#data-table-basic").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                });
                
                //Selection
                $("#data-table-selection").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    selection: true,
                    multiSelect: true,
                    rowSelect: true,
                    keepSelection: true
                });
                
                //Command Buttons
                $("#data-table-command").bootgrid({
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<a type=\"button\" href=\"" + "<?php echo site_url('food_type/edit/') ?>" + row.id + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></a> " + 
                                "<a href=\"" + "<?php echo site_url('food_type/delete/') ?>" + row.id + "\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></a>";
                        }
                    }
                });
            });
        </script>
    </body>
  </html>