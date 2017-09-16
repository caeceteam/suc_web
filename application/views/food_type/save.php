<!DOCTYPE html>

<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SUC</title>

<!-- Vendor CSS -->
<link
	href="<?php echo base_url('vendors/bower_components/animate.css/animate.min.css')?>"
	rel="stylesheet">
<link
	href="<?php echo base_url('vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css')?>"
	rel="stylesheet">
<link
	href="<?php echo base_url('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')?>"
	rel="stylesheet">
<link
	href="<?php echo base_url('vendors/bower_components/google-material-color/dist/palette.css')?>"
	rel="stylesheet">

<!-- CSS -->
<link href="<?php echo base_url('css/app.min.1.css" rel="stylesheet')?>">
<link href="<?php echo base_url('css/app.min.2.css" rel="stylesheet')?>">
</head>

<body data-ma-header="teal">

	<?php $this->load->view('templates/header'); ?>

    <section id="main">
			
			<?php $this->load->view('templates/menu'); ?>
			
		<section id="content">
			<div class="container">
				<div class="c-header">
					<h2 style="font-size: 25px;">Crear tipo de Alimento</h2>
					<!--TODO CC: Pass style inline to css class-->
				</div>

				<div class="card">
					<div class="card-body card-padding">
						<small>Ingrese los datos para la creación del nuevo tipo de
							alimento.</small> <br /> <br />

						<div class="row">
							<div class="card-body card-padding">

								<form role="form" action="<?php echo $action; ?>" method="POST">
									<div class="form-group fg-float">
										<div class="fg-line">
											<input type="text" id="name" name="name"
												class="input-sm form-control fg-input"
												value="<?php echo ($reset) ? '' : set_value('name',$this->form_data->name); ?>">
											<label class="fg-label">Nombre</label>
										</div>
									</div>
									</br>

									<div class="form-group fg-float">
										<div class="fg-line">
											<input type="text" id="code" name="code"
												class="input-sm form-control fg-input"
												value="<?php echo ($reset) ? '' : set_value('code',$this->form_data->code); ?>">
											<label class="fg-label">Código</label>
										</div>
									</div>
									</br>

									<div class="form-group fg-float">
										<div class="fg-line">
											<textarea class="form-control auto-size" id="description"
												name="description"><?php echo ($reset) ? '' : set_value('description',$this->form_data->description); ?></textarea>
											<label class="fg-label">Descripción</label>
										</div>
									</div>
									</br>

									<div class="checkbox" id="perishable" name="perishable">
										<input type="checkbox" id="perishable" name="perishable"
											class="input-sm form-control fg-input"
											value="<?php echo ($reset) ? '' : set_value('perishable',$this->form_data->perishable); ?>"
											<?php echo $this->form_data->perishable == 1? 'checked': '' ?>><i
											class="input-helper"></i> <label class="fg-label"> Alimento
											con fecha de expiración. </label>
									</div>
									</br>
									<div class="checkbox" id="celiac" name="celiac">
										<input type="checkbox" id="celiac" name="celiac"
											class="input-sm form-control fg-input"
											value="<?php echo ($reset) ? '' : set_value('celiac',$this->form_data->celiac); ?>"
											<?php echo $this->form_data->celiac == 1? 'checked': '' ?>><i
											class="input-helper"></i> <label class="fg-label"> Alimento
											apto para celiacos. </label>

									</div>
									</br>
									<div class="checkbox" id="diabetic" name="diabetic">
										<?php echo form_checkbox('diabetic',  $this->form_data->diabetic, $this->form_data->diabetic == 1 );?>
										
										<!--  <input type="checkbox" id="diabetic" name="diabetic"
											class="input-sm form-control fg-input"
											value="<?php echo ($reset) ? '' : set_value('diabetic',$this->form_data->diabetic); ?>"
											<?php echo $this->form_data->perishable == 1? 'checked': '' ?>>  -->

										<i class="input-helper"></i> <label class="fg-label"> Alimento
											apto para diabéticos. </label>

									</div>
									</br>

									<button type="submit"
										class="btn btn-primary btn-sm m-t-10 waves-effect">Grabar</button>
									<a href="<?php echo site_url('food_type'); ?>"
										class="btn btn-primary btn-sm m-t-10 waves-effect">Cancelar</a>
										<?php echo form_hidden('id', ($reset) ? '' : set_value('id',$this->form_data->id)); ?>
									</form>
							</div>
						</div>

						<br /> <br />
					</div>

					<br />
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
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>
		</div>
	</div>

	<!-- Javascript Libraries -->
	<script
		src="<?php echo base_url('vendors/bower_components/jquery/dist/jquery.min.js')?>"></script>
	<script
		src="<?php echo base_url('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>

	<script
		src="<?php echo base_url('vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>
	<script
		src="<?php echo base_url('vendors/bower_components/Waves/dist/waves.min.js')?>"></script>
	<script
		src="<?php echo base_url('vendors/bootstrap-growl/bootstrap-growl.min.js')?>"></script>
	<script
		src="<?php echo base_url('vendors/bower_components/autosize/dist/autosize.min.js')?>"></script>

	<!-- Placeholder for IE9 -->
	<!--[if IE 9 ]>
            <script src="<?php echo base_url('vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js')?>"></script>
        <![endif]-->

	<script src="<?php echo base_url('js/functions.js')?>"></script>
	<script src="<?php echo base_url('js/actions.js')?>"></script>
	<script src="<?php echo base_url('js/demo.js')?>"></script>
	<script src="<?php echo base_url('js/inputTypeForm.js')?>"></script>


</body>
</html>