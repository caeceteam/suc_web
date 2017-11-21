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
                        <h2 style="font-size: 25px;">Gestión de usuarios</h2> <!--TODO CC: Pass style inline to css class-->
                   		<!-- <?php $_SESSION['last_page'] = $_SERVER['PHP_SELF']?> -->
                    </div>

					<div class="card">
						<div class="card-body card-padding">
							<form class="row" role="form">
                                <div class="col-sm-4">
                                    <div style="position: relative;display: block;margin-top: 10px;margin-bottom: 10px;"> <!--TODO CC: Pass style inline to css class-->
                                        <label>
                                            ¿Desea dar de alta un nuevo usuario?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <a href="<?php echo base_url('user_diner/add');?>" class="btn btn-primary btn-sm m-t-5 waves-effect">Crear</a>
                                </div>
                            </form>			
						</div>
					</div>					
					
					<div class="card">
						<div class="card-body card-padding" style="padding-bottom:0"></div> <!--TODO CC: Pass style inline to css class-->
						<table id="data-table-command" class="table table-striped table-vmiddle bootgrid-table">
						    <thead>
						        <tr>
						            <th data-column-id="id"      data-visible="false">IdUser</th>
						            <th data-column-id="name"    data-order="desc">Nombre</th>
						            <th data-column-id="surname" data-order="desc">Apellido</th>
									<th data-column-id="phone">Telefono</th>
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
        		noResultText: "No hay usuarios cargados en el comedor",
        		infos: "Viendo {{ctx.start}} de {{ctx.end}} de {{ctx.total}} usuarios en comedor",
        		editUrl: 	"<?php echo site_url('user_diner/edit/') ?>",
        		deleteUrl: 	"<?php echo site_url('user_diner/delete/') ?>",
        		deleteDialogTitle: 	 "¿Está seguro de dar de baja al usuario en el comedor?",
        		deleteDialogText: 	 "El usuario sera dado de baja en el comedor",
        		deleteDialogSuccess: "El usuario fue dado de baja en el comedor .",
            	showDelete: true,
            	searchTxt: "Buscar por apellido"
            });

        </script>

	</body>
</html>