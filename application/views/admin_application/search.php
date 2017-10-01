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

		<?php $this->load->view('templates/header'); ?>

        <section id="main">
			
			<?php $this->load->view('templates/menu'); ?>
			
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2 style="font-size: 25px;">Aprobaciones pendientes de comedores</h2> <!--TODO CC: Pass style inline to css class-->
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
                            return "<a type=\"button\" href=\"" + "<?php echo site_url('admin_application/edit/') ?>" + row.id + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></a> ";
                        }
                    }
                });
            });
        </script>
    </body>
  </html>