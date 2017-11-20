<aside id="s-main-menu" class="sidebar">
    <ul class="smm-alerts" style="margin: 15px 0 15px 120px; padding-left: 0px;">
    	<li data-user-alert="sua-notifications" data-ma-action="sidebar-open" data-ma-target="user-alerts">
        	<i class="zmdi zmdi-notifications"></i>
        </li>
	</ul>

    <ul class="main-menu">
    	<li>
        	<a href="<?php echo base_url('');?>"><i class="zmdi zmdi-home"></i> Inicio</a>
        </li>

		<li class="sub-menu">
        	<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-notifications-active"></i> Aprobaciones pendientes</a>

			<ul>
            	<li><a href="<?php echo base_url('admin_application');?>"> De comedores</a></li>
				<li><a href="<?php echo base_url('donation');?>"> De donaciones</a></li>
            </ul>
        </li>
		<li class="sub-menu">
			<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-local-dining"></i> Comedores</a>
			<ul>

				<li><a href="<?php echo base_url('diner');?>"> Editar</a></li>
				<li class="sub-menu">
                	<a href="" data-ma-action="submenu-toggle"> Administrar</a>

                    <ul>
                        <li><a href="<?php echo base_url('diner_food');?>"> Almacén </a></li>
                        <li><a href="<?php echo base_url('diner_input');?>"> Insumos </a></li>
            			<li><a href="<?php echo base_url('event');?>"> Eventos</a></li>
						<li><a href="<?php echo base_url('user_diner');?>"> Alta de personal</a></li>
                        <li><a href="<?php echo base_url('assistant');?>"> Concurrentes</a></li>
                	</ul>
                </li>
				<li><a href=""> Eventos</a></li>
				<li><a href=""> Comedores Cercanos</a></li>
			</ul></li>

		<li class="sub-menu"><a href="" data-ma-action="submenu-toggle"><i
				class="zmdi zmdi-swap-alt"></i> Mantenimiento SUC</a>
			<ul>
				<!--<li><a href="colors.html">Insumos</a></li>-->
				<li><a href="<?php echo base_url('input_type');?>">Tipo de Insumos</a></li>
				<li><a href="<?php echo base_url('food_type');?>">Tipo de Alimento</a></li>
			</ul>
        </li>
	</ul>
</aside>
