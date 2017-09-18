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
					<h2 style="font-size: 25px;">Usuarios comedor</h2>
				</div>

				<div class="card">
					<div class="card-body card-padding">
						<form class="row" role="form">
							<div class="col-sm-4">
								<div
									style="position: relative; display: block; margin-top: 10px; margin-bottom: 10px;">
									<!--TODO CC: Pass style inline to css class-->
									<label> ¿Desea crear un nuevo usuario? </label>
								</div>
							</div>

							<div class="col-sm-4">
								<a href="<?php echo base_url('user_diner/add');?>"
									class="btn btn-primary btn-sm m-t-5 waves-effect">Crear</a>
							</div>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-body card-padding" style="padding-bottom: 0"></div>
					<!--TODO CC: Pass style inline to css class-->
							<?php echo $table?> 
                    </div>
			</div>

		</section>

			<?php $this->load->view('templates/footer'); ?>

        </section>

		<?php $this->load->view('templates/scripts'); ?>
		<script src="<?php echo base_url('js/tableGrid.js')?>"></script>

	<!-- Data Table -->
	<script type="text/javascript">
            $(document).ready(function(){

				//Command Buttons
                var grid = $("#data-table-command").bootgrid({
                	labels: {
                        noResults: 	"No hay usuarios para la consulta",
                        search: 	"Buscar",
                        infos:  	"Viendo {{ctx.start}} de {{ctx.end}} de {{ctx.total}} usuarios en comedor"
                    },
                    css: {
                        icon: 		 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 	 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 	 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                        	return 	"<a type=\"button\" href=\"" + "<?php echo site_url('user_diner/view/') ?>" + row.idUser + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\""  + row.idUser + "\"><span class=\"zmdi zmdi-eye\"></span></a>"  +
                    		"<a type=\"button\" href=\"" + "<?php echo site_url('user_diner/edit/') ?>" + row.idUser + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\""  + row.idUser + "\"><span class=\"zmdi zmdi-edit\"></span></a>" + 
                           	"<a id=\"sa-warning\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.idUser + "\"><span class=\"zmdi zmdi-delete\"></span></a>";
                        }
                    }
	                }).on("loaded.rs.jquery.bootgrid", function () {
	                	$(this).find(".command-delete").off();
	                	$(this).find(".command-edit").off();
    				/* Executes after data is loaded and rendered */
    				$(this).find(".command-delete").click(function (e) {
    					var deleteUrl = "<?php echo site_url('user_diner/delete/') ?>" + this.getAttribute("data-row-id");
						swal({
        					title: "¿Está seguro en dar de baja a este usuario?",
    						text:  "El usuario sera dado de baja para este comedor",
    						type:  "warning",
    						showCancelButton:   true,
    						confirmButtonColor: "#DD6B55",
    						confirmButtonText:  "Si",
    						cancelButtonText:   "No",
    						closeOnConfirm:     false,
    					//Funcion de confirmacion del POP UP	
    					}, function(isConfirm){
    						$('#data-table-command').bootgrid('reload');
    							if (isConfirm) {
    							  	$.ajax({ 
    								   type: "DELETE",
    								   url: deleteUrl,
    								   success: function(data){
    									   swal("¡Borrado!", "El se ha dado de baja para el comedor.", "success");
    									  
    								   }
    								});
    						  	}
    					});
    				});
    			});
            });
        </script>

</body>
</html>