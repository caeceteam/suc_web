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
                        <h2 style="font-size: 25px;">Eventos</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>
                    
					<div class="card">
						<div class="card-body card-padding">
							<form class="row" role="form">
                                <div class="col-sm-4">
                                    <div style="position: relative;display: block;margin-top: 10px;margin-bottom: 10px;"> <!--TODO CC: Pass style inline to css class-->
                                        <label>
                                            ¿Desea crear un nuevo evento?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <a href="<?php echo base_url('event/add');?>" class="btn btn-primary btn-sm m-t-5 waves-effect">Crear</a>
                                </div>
                            </form>			
						</div>
					</div>					
					
					<div class="card">
						<div class="card-body card-padding" style="padding-bottom:0"></div> <!--TODO CC: Pass style inline to css class-->
						<table id="data-table-command" class="table table-striped table-vmiddle bootgrid-table">
						    <thead>
						        <tr>
						            <th data-column-id="name" data-order="desc">Nombre</th>
						            <th data-column-id="date" data-order="desc">Fecha y Hora</th>
						            <th data-column-id="street" data-order="desc">Dirección</th>
						            <th data-column-id="phone" data-order="desc">Teléfono</th>
									<th data-column-id="commands" data-formatter="commands" data-sortable="false">Modificar/Borrar</th>
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
        		noResultText: "No hay eventos creados todavía para este comedor",
        		infos: "Viendo {{ctx.start}} de {{ctx.end}} de {{ctx.total}} eventos",
        		editUrl: "<?php echo site_url($this->strategy_context->get_url('event/edit/')) ?>",
        		deleteUrl: "<?php echo site_url($this->strategy_context->get_url('event/delete/')) ?>",
        		deleteDialogTitle: "¿Está seguro en borrar este evento?",
        		deleteDialogText: "El evento se borrará permanentemente del sistema",
        		deleteDialogSuccess: "El evento se ha borrado del sistema.",
        		searchTxt: "Buscar por nombre",
        		showDelete: true
            });

        </script>

	</body>
</html>