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
                        <h2 style="font-size: 25px;">Tipos de Insumos</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

					<div class="card">
						<div class="card-body card-padding">
							<form class="row" role="form">
                                <div class="col-sm-4">
                                    <div style="position: relative;display: block;margin-top: 10px;margin-bottom: 10px;"> <!--TODO CC: Pass style inline to css class-->
                                        <label>
                                            ¿Desea crear un nuevo tipo de insumo?
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <a href="<?php echo base_url('input_type/add');?>" class="btn btn-primary btn-sm m-t-5 waves-effect">Crear</a>
                                </div>
                            </form>			
						</div>
					</div>					
                    <input hidden id="success-message" value="<?php echo isset($_ci_vars['success-message']) ? $_ci_vars['success-message'] : '' ?>"></input>
					
					<div class="card">
						<div class="card-body card-padding" style="padding-bottom:0"></div> <!--TODO CC: Pass style inline to css class-->
							<?php echo $table?> 
                    </div>
                </div>
                
            </section>

			<?php $this->load->view('templates/footer'); ?>

        </section>

		<?php $this->load->view('templates/scripts'); ?>
		<!-- Data Table -->
        <script type="text/javascript">
            $(document).ready(function(){

				//Command Buttons
                var grid = $("#data-table-command").bootgrid({
                	labels: {
                        noResults: "No hay tipos de insumos cargados",
                        search: "Buscar",
                        infos: "Viendo {{ctx.start}} de {{ctx.end}} de {{ctx.total}} tipos de insumo"
                    },
                    css: {
                        icon: 'zmdi icon',
                        iconColumns: 'zmdi-view-module',
                        iconDown: 'zmdi-expand-more',
                        iconRefresh: 'zmdi-refresh',
                        iconUp: 'zmdi-expand-less'
                    },
                    formatters: {
                        "commands": function(column, row) {
                            return "<a type=\"button\" href=\"" + "<?php echo site_url('input_type/edit/') ?>" + row.id + "\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></a> " + 
                                "<a id=\"sa-warning\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-delete\"></span></a>";
                        }
                    }
	                }).on("loaded.rs.jquery.bootgrid", function () {
	                	$(this).find(".command-delete").off();
	                	$(this).find(".command-edit").off();
    				/* Executes after data is loaded and rendered */
    				$(this).find(".command-delete").click(function (e) {
    					var deleteUrl = "<?php echo site_url('input_type/delete/') ?>" + this.getAttribute("data-row-id");
    					swal({
    						title: "¿Está seguro en borrar este tipo de insumo?",
    						text: "El tipo de insumo se borrará permanentemente del sistema",
    						type: "warning",
    						showCancelButton: true,
    						confirmButtonColor: "#DD6B55",
    						confirmButtonText: "Si",
    						cancelButtonText: "No",
    						closeOnConfirm: false,
    					}, function(isConfirm){
    						$('#data-table-command').bootgrid('reload');
    							if (isConfirm) {
    							  	$.ajax({ 
    								   type: "DELETE",
    								   url: deleteUrl,
    								   success: function(data){
    									   swal("¡Borrado!", "El tipo de insumo se ha borrado del sistema.", "success");
    								   }
    								});
    						  	}
    					});
    				});
    			});
            });
        </script>

        <script>
			if ($("#success-message").val() != "") {
		        $.growl({
		            title: 'Tipo de insumo: ',
		            message: $("#success-message").val(),
		            url: ''
		        },{
		            element: 'body',
		            type: 'success',
		            allow_dismiss: true,
		            placement: {
		                align: 'center'
		            },
		            offset: {
		                x: 30,
		                y: 30
		            },
		            spacing: 10,
		            z_index: 1031,
		            delay: 2500,
		            timer: 1000,
		            url_target: '_blank',
		            mouse_over: false,
		            icon_type: 'class',
		            template: '<div data-growl="container" class="alert" role="alert">' +
		            '<button type="button" class="close" data-growl="dismiss">' +
		            '<span aria-hidden="true">&times;</span>' +
		            '<span class="sr-only">Close</span>' +
		            '</button>' +
		            '<span data-growl="icon"></span>' +
		            '<span data-growl="title"></span>' +
		            '<span data-growl="message"></span>' +
		            '<a href="#" data-growl="url"></a>' +
		            '</div>'
		        });
			}
        </script>

    </body>
  </html>