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
                        <h2 style="font-size: 25px;">Aprobaciones pendientes de comedores</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>
					
					<div class="card">
						<div class="card-body card-padding" style="padding-bottom:0"></div> <!--TODO CC: Pass style inline to css class-->
						<table id="data-table-command" class="table table-striped table-vmiddle bootgrid-table">
						    <thead>
						        <tr>
						            <th data-column-id="id" data-visible="false">ID</th>
						            <th data-column-id="name" data-order="desc">Nombre</th>
						           	<th data-column-id="address">Domicilio</th>
									<th data-column-id="mail">Mail</th>
									<th data-column-id="commands" data-formatter="commands" data-sortable="false">Ir a solicitud</th>
						        </tr>
						    </thead>
						</table>
                    </div>
                    <input hidden id="data-request-url" value="<?php echo isset($_ci_vars['data-request-url']) ? $_ci_vars['data-request-url'] : '' ?>"></input>
                    
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
		<script src="<?php echo base_url('js/tableGrid.js')?>"></script>
		
		<!-- Data Table -->
        <script type="text/javascript">
        	loadBootgrid({
        		selector: "#data-table-command",
        		requestUrl: $("#data-request-url")[0].value,
        		noResultText: "No hay concurrentes cargados",
        		infos: "Viendo {{ctx.start}} de {{ctx.end}} de {{ctx.total}} concurrentes",
        		editUrl: "<?php echo site_url('admin_application/edit/') ?>",
        		deleteUrl: "<?php echo site_url('admin_application/delete/') ?>",
        		deleteDialogTitle: "¿Está seguro en borrar al concurrente seleccionado?",
        		deleteDialogText: "El concurrente se borrará permanentemente del sistema",
        		deleteDialogSuccess: "El concurrente se ha borrado del sistema.",
            	showDelete: false,
            	searchTxt: "Buscar por nombre"
            });
        </script>
    </body>
  </html>