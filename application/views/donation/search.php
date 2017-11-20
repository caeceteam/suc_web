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
			
			<?php $this->load->view($this->strategy_context->get_menu()); ?>
			
            <section id="content">
                <div class="container">
                    <div class="c-header">
                        <h2>Donaciones</h2>
                    </div>
					<div class="card">
						<div class="card-body card-padding" style="padding-bottom:0"></div>
						<table id="data-table-command" class="table table-striped table-vmiddle bootgrid-table">
						    <thead>
						        <tr>
						            <th data-column-id="title">Título</th>
						            <th data-column-id="nameUserSender" data-order="desc">Usuario</th>
									<th data-column-id="id" data-visible="false">id</th>
									<th data-column-id="creationDate">Fecha</th>
									<th data-column-id="state">Estado</th>
									<th data-column-id="commands" data-formatter="commands" data-sortable="false">Ir a solicitud</th>
						        </tr>
						    </thead>
						</table>
                    </div>
                </div>
                <input hidden id="data-request-url" value="<?php echo isset($_ci_vars['data-request-url']) ? $_ci_vars['data-request-url'] : '' ?>"></input>
                
            </section>

			<?php $this->load->view('templates/footer'); ?>
			
        </section>

		<?php $this->load->view('templates/scripts'); ?>
		<script src="<?php echo base_url('js/tableGrid.js')?>"></script>
		
		<!-- Data Table -->
        <script type="text/javascript">
        	loadBootgrid({
        		selector: "#data-table-command",
        		requestUrl: $("#data-request-url")[0].value,
        		noResultText: "No hay donaciones pendientes de aprobación",
        		infos: "Viendo {{ctx.start}} de {{ctx.end}} de {{ctx.total}} donaciones",
        		editUrl: "<?php echo site_url($this->strategy_context->get_url('donation/edit/')) ?>",
        		deleteUrl: "<?php echo site_url($this->strategy_context->get_url('donation/delete/')) ?>",
        		deleteDialogTitle: "¿Está seguro en borrar esta donación?",
        		deleteDialogText: "La donación se borrará permanentemente del sistema",
        		deleteDialogSuccess: "La donación se ha borrado del sistema.",
        		isDonationGrid: true,
        		searchTxt: "Buscar por título"
            });

        </script>

	</body>
</html>