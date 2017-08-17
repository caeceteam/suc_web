<aside id="s-user-alerts" class="sidebar">
	<ul class="tab-nav tn-justified tn-icon m-t-10" data-tab-color="teal">
    	<li><a class="sua-notifications" href="#sua-notifications" data-toggle="tab"><i class="zmdi zmdi-notifications"></i></a></li>
	</ul>

    <div class="tab-content">
    	<div class="tab-pane fade" id="sua-notifications">
        	<ul class="sua-menu list-inline list-unstyled palette-Orange bg">
            	<li><a href=""><i class="zmdi zmdi-volume-off"></i> Mute</a></li>
               	<li><a href=""><i class="zmdi zmdi-long-arrow-tab"></i> View all</a></li>
                <li><a href="" data-ma-action="sidebar-close"><i class="zmdi zmdi-close"></i> Close</a></li>
            </ul>

            <div class="list-group lg-alt c-overflow">
            	<a href="" class="list-group-item media">
                	<div class="pull-left">
                    	<img class="avatar-img"  alt="">
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
	<div class="smm-header">
    	<i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
	</div>

    <ul class="smm-alerts" style="margin: 30px 0 60px 120px; padding-left: 0px;"><!-- TODO CC: Add style to css class-->
    	<li data-user-alert="sua-notifications" data-ma-action="sidebar-open" data-ma-target="user-alerts">
        	<i class="zmdi zmdi-notifications"></i>
        </li>
	</ul>

    <ul class="main-menu">
    	<li>
        	<a href="<?php echo base_url('');?>"><i class="zmdi zmdi-home"></i> Inicio</a>
        </li>
        <li>
        	<a href="<?php echo base_url('diner');?>"><i class="zmdi zmdi-local-dining"></i> Comedores</a>
        </li>
        
		<!--<li class="sub-menu">
        	<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-notifications-active"></i> Aprobaciones pendientes</a>
			<ul>
            	<li><a href="alternative-header.html"> De comedores</a></li>
				<li><a href="HU001.html"> De personas</a></li>
            </ul>
        </li>-->
		<!--<li class="sub-menu">
			<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-local-dining"></i> Comedores</a>
			<ul>
            	<li><a href="index.html"> Eventos</a></li>
				<li><a href="index.html"> Personal</a></li>
	        </ul>
		</li>-->
                    
        <li class="sub-menu">
        	<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-swap-alt"></i> Mantenimiento SUC</a>
            <ul>
            	<!--<li><a href="colors.html">Insumos</a></li>-->
				<li><a href="<?php echo base_url('input_type');?>">Tipo de Insumos</a></li>
			</ul>
        </li>
	</ul>
</aside>