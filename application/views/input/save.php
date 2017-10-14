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
                        <h2 style="font-size: 25px;">Crear insumo</h2> <!--TODO CC: Pass style inline to css class-->
                    </div>

                    <div class="card">
                        <div class="card-body card-padding">
                            <small>Ingrese los datos correspondientes al insumo que desee dar de alta en el sistema SUC.</small>

                            <br/><br/>
                            
                                <div class="card-body card-padding">
									<form role="form">
										<div class="row">
											<div class="fg-float form-group col-sm-12" style="padding-left: 0; ">
												<div class="fg-line" style="border-bottom: 2px solid #2196f3">
													<select class="selectpicker" data-live-search="true">
														<option value="ROP">Ropa</option>
														<option value="AL">Alimento</option>
													</select>
													<label class="fg-label" style="top: -20px; font-size: 11px;">Seleccione un tipo de insumo</label>													
												</div>
											</div>
											
											<div class="fg-float form-group col-sm-6" style="padding-left: 0;"> <!--TODO CC: Pass style inline to css class-->
												<div class="fg-line">
													<input type="text" id="name" name="name" class="input-sm form-control fg-input">
													<label class="fg-label">Nombre</label>
												</div>
											</div>
											<div class="fg-float form-group col-sm-2"> 
												<div class="fg-line">
													<input type="text" name="amount" class="input-sm form-control fg-input">
													<label class="fg-label">Cantidad</label>
												</div>
											</div>
											<div class="fg-float form-group col-sm-2" style="width: 13%;"> 
												<div class="fg-line" style="border-bottom: 2px solid #2196f3">
													<select class="selectpicker" data-live-search="false">
														<option value="XS">XS</option>
														<option value="S">S</option>
														<option value="M">M</option>
														<option value="L">L</option>
														<option value="XL">XL</option>
														<option value="otro">Otro</option>
													</select>
													<label class="fg-label" style="top: -20px; font-size: 11px;">Talle</label>												
												</div>
											</div>
											<div class="fg-float form-group col-sm-2" style="width: 20%;"> 
												<div class="fg-line" style="border-bottom: 2px solid #2196f3">
													<select class="selectpicker" data-live-search="false">
														<option value="F">Femenino</option>
														<option value="M">Masculino</option>
														<option value="U">Unisex</option>
													</select>
													<label class="fg-label" style="top: -20px; font-size: 11px;">Genero</label>												
												</div>
											</div>											
											
											<div class="pmb-block">
												<button type="submit" class="btn btn-primary btn-sm m-t-10 waves-effect">Crear</button>
												<a href="HU007.lista.html" class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>	
											</div>

											</br>
											
											<div id=alerts" class="pmb-block" hidden>
												<div class="alert alert-success alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													Texto satisfactorio
												</div>
												<div class="alert alert-danger alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													Texto de error
												</div>
											</div>
											
										</div>
									</form>
                                </div>
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