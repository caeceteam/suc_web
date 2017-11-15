<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
<!--<meta charset="utf-8">-->
<meta charset="ISO-8859-1">
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
					<h2>Comedores cercanos.</h2>
				</div>
				<div class="card">
					<div class="card-header">
						<h2>
								Comedores cercanos al comedor <?php echo $this->form_data->name ?> 
								<small><?php echo $this->form_data->description ?>  </small>
						</h2>
					</div>
					<div class="card-body card-padding">
						<div id="googleMap" class="card-body card-padding">
							<?php echo $map['js']; ?>
							<?php echo $map['html']; ?>
							
						</div>
					</div>
				</div>
				<div class="pmb-block">
							    <?php $this->load->view('templates/alerts'); ?>
							</div>
				<div class="pmb-block">
					<input hidden id="redirect-url"
						value="<?php echo isset($_ci_vars['redirect-url']) ? $_ci_vars['redirect-url'] : '' ?>"></input>
					<input hidden id="request-action"
						value="<?php echo isset($_ci_vars['request-action']) ? $_ci_vars['request-action'] : '' ?>"></input>
				</div>
			</div>
			</div>
			</div>
			<input hidden id="data-request-url"
				value="<?php echo isset($_ci_vars['data-request-url']) ? $_ci_vars['data-request-url'] : '' ?>"></input>
		</section>
			
			<?php $this->load->view('templates/footer'); ?>
	</section>

	<div class="page-loader palette-Teal bg">
		<div class="preloader pl-xl pls-white">
			<svg class="pl-circular" viewBox="25 25 50 50">
                <circle class="plc-path" cx="50" cy="50" r="20" />
            </svg>
		</div>
	</div>

		<?php $this->load->view('templates/scripts'); ?>
			<script src="<?php echo base_url('js/confirmDialogForm.js')?>"></script>
</body>
</html>