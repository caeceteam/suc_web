<header id="header" class="media" style="position: fixed; width: 100%; top: 0; height: 105px; padding-top: 15px;">
	<div class="pull-left h-logo">
		<a href="<?php echo base_url('');?>" class="hidden-xs">
        	 
            <!--  SUC <small>Sistema Úšnico de Comedores</small>-->
            <img src="<?php echo base_url('img/suc.svg')?>" alt="SUC" height="80" width="190" >
		</a>

		<div class="menu-collapse" data-ma-action="sidebar-open" data-ma-target="main-menu">
        	<div class="mc-wrap">
            	<div class="mcw-line top palette-White bg"></div>
				<div class="mcw-line center palette-White bg"></div>
				<div class="mcw-line bottom palette-White bg"></div>
            </div>
        </div>
	</div>

	<ul class="pull-right h-menu">
		<li class="hm-alerts" data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
			<a href=""><i class="hm-icon zmdi zmdi-notifications"></i></a>
		</li>
		<li class="dropdown hm-profile">
			<?php 	if (isset($this->session->userName)) {
						echo '	<a data-toggle="dropdown" href="">
        							<span class="user-name">' . $this->session->userName . ' - ' . $this->login->get_role_description($this->session->role) . '</span>
            						<img src="' . base_url("img/profile-pics/2.gif") . '?>" alt="">
            					</a>';
					} else {
						echo '	<a>
        							<span class="user-name">Invitado</span>
            						<img src="' . base_url("img/profile-pics/2.gif") . '?>" alt="">
            					</a>';						
					}?>

            <ul class="dropdown-menu pull-right dm-icon">
            	 <li>
					<?php $this->session->set_userdata('previous_page', uri_string());?>
                	<a href="<?php echo base_url('user_diner/edit/'.$this->session->userdata['idUser'] );?>"><i class="zmdi zmdi-account"></i> Mis Datos</a>
                </li>
                <li>
                	<a href="<?php echo base_url('password');?>"><i class="zmdi zmdi-settings"></i> Cambiar contraseña</a>
                </li>
                <li>
                	<a href="<?php echo base_url('login/logout');?>"><i class="zmdi zmdi-close"></i> Cerrar sesión</a>
                </li>
            </ul>
		</li>
    </ul>
</header>
<div id="header" class="media" style="top: 0; height: 105px; padding-top: 15px; position: inherit;"></div>