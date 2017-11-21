<aside id="s-user-alerts" class="sidebar">
	<ul class="tab-nav tn-justified tn-icon m-t-10" data-tab-color="teal">
		<li><a class="sua-notifications" href="#sua-notifications"
			data-toggle="tab"><i class="zmdi zmdi-notifications"></i></a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane fade" id="sua-notifications">
			<ul class="sua-menu list-inline list-unstyled palette-Orange bg">
				<li><a href=""><i class="zmdi zmdi-volume-off"></i> Mute</a></li>
				<li><a href=""><i class="zmdi zmdi-long-arrow-tab"></i> View all</a></li>
				<li><a href="" data-ma-action="sidebar-close"><i
						class="zmdi zmdi-close"></i> Close</a></li>
			</ul>

			<div class="list-group lg-alt c-overflow">
				<a href="" class="list-group-item media">
					<div class="pull-left">
						<img class="avatar-img" alt="">
					</div>

					<div class="media-body">
						<div class="lgi-heading">Comedor Los piletones</div>
						<small class="lgi-text">Solicitud de frazadas</small>
					</div>
				</a>
			</div>
		</div>
	</div>
</aside>
<aside id="s-main-menu" class="sidebar">
	<ul class="main-menu">
		<li><a href="<?php echo base_url('');?>"><i class="zmdi zmdi-home"></i>
				Inicio</a>
		</li>
		<li class="sub-menu"><a href="" data-ma-action="submenu-toggle"><i
				class="zmdi zmdi-notifications-active"></i> Aprobaciones pendientes</a>
			<ul>
				<li><a href="<?php echo base_url('admin_application');?>"> De
						comedores</a></li>
				<li><a href=""> De personas</a></li>
			</ul></li>
		<li class="sub-menu"><a href="" data-ma-action="submenu-toggle"><i
				class="zmdi zmdi-local-dining"></i> Comedores</a>
			<ul>
				<li><a href="<?php echo base_url('diner');?>"> Listado</a></li>
				<li class="sub-menu"><a href="" data-ma-action="submenu-toggle">Administración</a>

					<ul>
						<li><a href="<?php echo base_url('diner_food');?>"> Almacen </a></li>
						<li><a href="<?php echo base_url('diner_input');?>"> Insumos </a></li>
						<li><a href="<?php echo base_url('event');?>"> Eventos</a></li>
						<li><a href="<?php echo base_url('diner');?>"> Personal</a></li>
						<li><a href="<?php echo base_url('diner');?>"> Concurrentes</a></li>
					</ul></li>
				<li><a href=""> Eventos</a></li>
				<li><a href=""> Comedores Cercanos</a></li>
			</ul></li>

		<li class="sub-menu"><a href="" data-ma-action="submenu-toggle"><i
				class="zmdi zmdi-swap-alt"></i> Mantenimiento SUC</a>
			<ul>
				<!--<li><a href="colors.html">Insumos</a></li>-->
				<li><a href="<?php echo base_url('input_type');?>">Tipo de Insumos</a></li>
				<li><a href="<?php echo base_url('food_type');?>">Tipo de Alimento</a></li>
				<li><a href="">Asignación de Roles</a></li>
			</ul></li>

		<li class="sub-menu"><a href="" data-ma-action="submenu-toggle"><i
				class="zmdi zmdi-account"></i> Personal</a>
			<ul>
				<li><a href="<?php echo base_url('user_diner'); ?>">Alta personal</a></li>
			</ul></li>
	</ul>
</aside>