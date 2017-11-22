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
                        <h2>Concurrentes</h2>
                    </div>

					<div class="card">
						<div class="card-body card-padding">
							<form class="row" role="form">
                                <div class="col-sm-4">
                                    <div style="position: relative;display: block;margin-top: 10px;margin-bottom: 10px;"> <!--TODO CC: Pass style inline to css class-->
                                        <label>
                                            ¿Desea crear un nuevo concurrente?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <a href="<?php echo base_url('assistant/add/') . $this->form_data->idDiner;?>" class="btn btn-primary btn-sm m-t-5 waves-effect">Crear</a>
                                </div>
                            </form>			
						</div>
					</div>					
					
					<div class="card">
						<div class="card-body card-padding" style="padding-bottom:0"></div> <!--TODO CC: Pass style inline to css class-->
						<table id="data-table-command" class="table table-striped table-vmiddle bootgrid-table">
						    <thead>
						        <tr>
						            <th data-column-id="idAssistant" data-visible="false">ID</th>
						            <th data-column-id="name" data-order="desc">Nombre</th>
						            <th data-column-id="surname" data-order="desc">Apellido</th>
									<th data-column-id="address">Domicilio</th>
									<th data-column-id="phone">Teléfono</th>
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
        		noResultText: "No hay concurrentes cargados",
        		infos: "Viendo {{ctx.start}} de {{ctx.end}} de {{ctx.total}} concurrentes",
        		editUrl: "<?php echo site_url('assistant/edit/') ?>",
        		deleteUrl: "<?php echo site_url('assistant/delete/') ?>",
        		deleteDialogTitle: "¿Está seguro en borrar al concurrente seleccionado?",
        		deleteDialogText: "El concurrente se borrará permanentemente del sistema",
        		deleteDialogSuccess: "El concurrente se ha borrado del sistema.",
        		searchTxt: "Buscar por apellido"
            });

        </script>

	</body>
</html>