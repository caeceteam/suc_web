<!DOCTYPE html>
    <!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema único de comedores</title>
        
        <!-- Vendor CSS -->
        <link href="<?php echo base_url('vendors/bower_components/animate.css/animate.min.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/google-material-color/dist/palette.css')?>" rel="stylesheet">
        <link href="<?php echo base_url('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')?>" rel="stylesheet">
            
        <!-- CSS -->
		<link href="<?php echo base_url('css/app.min.1.css')?>" rel="stylesheet">
		<link href="<?php echo base_url('css/app.min.2.css')?>" rel="stylesheet">
    </head>
    
    <body>
        <form role="form" action="<?php echo $action; ?>" method="POST">
        	<div class="login" data-lbg="purple">
				<!-- Forgot Password -->
	            <div class="l-block toggled" id="l-forget-password">
	                <div class="lb-header palette-Purple bg">
	                    <i class="zmdi zmdi-account-circle"></i>
	                    ¿Olvidó su contraseña?
	                </div>
	
	                <div class="lb-body">
	                    <p class="m-b-30">Ingrese su email y le enviaremos una nueva contraseña.</p>
	
	                    <div class="form-group fg-float">
	                        <div class="fg-line">
	                            <input name="userName" type="text" <?php echo set_value('name',$this->form_data->userName); ?> class="input-sm form-control fg-input">
	                            <label class="fg-label">Email</label>
	                        </div>
	                    </div>
	                    
	                    <?php echo $message?>
	
	                    <button class="btn palette-Purple bg">Enviar</button>
	
	                    <div class="m-t-30">
	                    	<a data-bg="blue" class="palette-Teal text d-block m-b-5" href="<?php echo base_url('diner_application')?>">Dar de alta un comedor</a>
	                        <a data-bg="teal" class="palette-Purple text d-block m-b-5" href="<?php echo base_url('login')?>">¿Ya tenés una cuenta?</a>
	                        <a data-block="#l-register" data-bg="blue" href="" class="palette-Purple text">Crear una cuenta</a>
	                    </div>
	                </div>
	            </div>
	            
	            <div class="l-block" id="l-register">
	                <div class="lb-header palette-Blue bg">
	                    <i class="zmdi zmdi-account-circle"></i>
	                    Crear una cuenta
	                </div>
	
	                <div class="lb-body">
						<div class="alert alert-warning" role="alert">
						Si sos administrador de un comedor y todavía no tenes cuenta, ingresá a la opción "Dar de alta un comedor".
						De lo contrario, deberás solicitar una cuenta al administrador de tu comedor. 
						</div>
	
	                    <div class="m-t-30">
	                        <a data-bg="blue" class="palette-Teal text d-block m-b-5" href="<?php echo base_url('diner_application')?>">Dar de alta un comedor</a>
	                        <a data-block="#l-login" data-bg="teal" class="palette-Blue text d-block m-b-5" href="">¿Ya tenés una cuenta?</a>
	                        <a data-block="#l-forget-password" data-bg="purple" href="" class="palette-Blue text">¿Olvidó su contraseña?</a>
	                    </div>
	                </div>
	            </div>
	            
        	</div>
        </form>

        <!-- Older IE warning message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

        <!-- Javascript Libraries -->
        <script src="<?php echo base_url('vendors/bower_components/jquery/dist/jquery.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo base_url('vendors/bower_components/Waves/dist/waves.min.js')?>"></script>

        <!-- Placeholder for IE9 -->
        <!--[if IE 9 ]>
            <script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url('js/functions.js')?>"></script>
        
    </body>
</html>