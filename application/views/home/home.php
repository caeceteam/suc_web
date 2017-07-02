<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SUC</title>

<!-- Vendor CSS -->
<link href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
<link href="vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
<link href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
<link href="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">
<link href="vendors/bower_components/google-material-color/dist/palette.css" rel="stylesheet">

<!-- CSS -->
<link href="css/app.min.1.css" rel="stylesheet">
<link href="css/app.min.2.css" rel="stylesheet">

</head>
<body data-ma-header="teal">
<header id="header" class="media">
<div class="pull-left h-logo">
<a href="index.html" class="hidden-xs">
SUC
<!-- <small>Sistema �nico de Comedores</small> -->
<small>Sistema �nico de Comedores</small>

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
<li class="hm-search-trigger">
<a href="" data-ma-action="search-open">
<i class="hm-icon zmdi zmdi-search"></i>
</a>
</li>

<li class="dropdown hidden-xs hidden-sm h-apps">
<a data-toggle="dropdown" href="">
<i class="hm-icon zmdi zmdi-apps"></i>
</a>
<ul class="dropdown-menu pull-right">
<li>
<a href="">
<i class="palette-Red-400 bg zmdi zmdi-calendar"></i>
<small>Calendar</small>
</a>
</li>

<li>
<a href="">
<i class="palette-Green-400 bg zmdi zmdi-file-text"></i>
<small>Files</small>
</a>
</li>
<li>
<a href="">
<i class="palette-Light-Blue bg zmdi zmdi-email"></i>
<small>Mail</small>
</a>
</li>
<li>
<a href="">
<i class="palette-Orange-400 bg zmdi zmdi-trending-up"></i>
<small>Analytics</small>
</a>
</li>
<li>
<a href="">
<i class="palette-Purple-300 bg zmdi zmdi-view-headline"></i>
<small>News</small>
</a>
</li>
<li>
<a href="">
<i class="palette-Blue-Grey bg zmdi zmdi-image"></i>
<small>Gallery</small>
</a>
</li>
</ul>
</li>
<li class="dropdown hidden-xs">
<a data-toggle="dropdown" href=""><i class="hm-icon zmdi zmdi-more-vert"></i></a>
<ul class="dropdown-menu dm-icon pull-right">
<li class="hidden-xs">
<a data-action="fullscreen" href=""><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
</li>
<li>
<a data-action="clear-localstorage" href=""><i class="zmdi zmdi-delete"></i> Clear Local Storage</a>
</li>
<li>
<a href=""><i class="zmdi zmdi-face"></i> Privacy Settings</a>
</li>
<li>
<a href=""><i class="zmdi zmdi-settings"></i> Other Settings</a>
</li>
</ul>
</li>
<li class="hm-alerts" data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
<a href=""><i class="hm-icon zmdi zmdi-notifications"></i></a>
</li>
<li class="dropdown hm-profile">
<a data-toggle="dropdown" href="">
<img src="img/profile-pics/1.jpg" alt="">
</a>

<ul class="dropdown-menu pull-right dm-icon">
<li>
<a href="profile-about.html"><i class="zmdi zmdi-account"></i> View Profile</a>
</li>
<li>
<a href=""><i class="zmdi zmdi-input-antenna"></i> Privacy Settings</a>
</li>
<li>
<a href=""><i class="zmdi zmdi-settings"></i> Settings</a>
</li>
<li>
<a href=""><i class="zmdi zmdi-time-restore"></i> Logout</a>
</li>
</ul>
</li>
</ul>

<div class="media-body h-search">
<form class="p-relative">
<input type="text" class="hs-input" placeholder="Search for people, files & reports">
<i class="zmdi zmdi-search hs-reset" data-ma-action="search-clear"></i>
</form>
</div>

</header>

<section id="main">
<aside id="s-user-alerts" class="sidebar">
<ul class="tab-nav tn-justified tn-icon m-t-10" data-tab-color="teal">
<li><a class="sua-messages" href="#sua-messages" data-toggle="tab"><i class="zmdi zmdi-email"></i></a></li>
<li><a class="sua-notifications" href="#sua-notifications" data-toggle="tab"><i class="zmdi zmdi-notifications"></i></a></li>
<li><a class="sua-tasks" href="#sua-tasks" data-toggle="tab"><i class="zmdi zmdi-view-list-alt"></i></a></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade" id="sua-messages">
<ul class="sua-menu list-inline list-unstyled palette-Light-Blue bg">
<li><a href=""><i class="zmdi zmdi-check-all"></i> Mark all</a></li>
<li><a href=""><i class="zmdi zmdi-long-arrow-tab"></i> View all</a></li>
<li><a href="" data-ma-action="sidebar-close"><i class="zmdi zmdi-close"></i> Close</a></li>
</ul>

<div class="list-group lg-alt c-overflow">
<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/1.jpg" alt="">
</div>

<div class="media-body">
<div class="lgi-heading">David Villa Jacobs</div>
<small class="lgi-text">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis lobortis sapien non posuere</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/5.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Candice Barnes</div>
<small class="lgi-text">Quisque non tortor ultricies, posuere elit id, lacinia purus curabitur.</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/3.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Jeannette Lawson</div>
<small class="lgi-text">Donec congue tempus ligula, varius hendrerit mi hendrerit sit amet. Duis ac quam sit amet leo feugiat iaculis</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/4.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Darla Mckinney</div>
<small class="lgi-text">Duis tincidunt augue nec sem dignissim scelerisque. Vestibulum rhoncus sapien sed nulla aliquam lacinia</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/2.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Rudolph Perez</div>
<small class="lgi-text">Phasellus a ullamcorper lectus, sit amet viverra quam. In luctus tortor vel nulla pharetra bibendum</small>
</div>
</a>
</div>

<a href="" class="btn btn-float btn-danger m-btn">
<i class="zmdi zmdi-plus"></i>
</a>
</div>
<div class="tab-pane fade" id="sua-notifications">
<ul class="sua-menu list-inline list-unstyled palette-Orange bg">
<li><a href=""><i class="zmdi zmdi-volume-off"></i> Mute</a></li>
<li><a href=""><i class="zmdi zmdi-long-arrow-tab"></i> View all</a></li>
<li><a href="" data-ma-action="sidebar-close"><i class="zmdi zmdi-close"></i> Close</a></li>
</ul>

<div class="list-group lg-alt c-overflow">
<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/1.jpg" alt="">
</div>

<div class="media-body">
<div class="lgi-heading">David Villa Jacobs</div>
<small class="lgi-text">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis lobortis sapien non posuere</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/5.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Candice Barnes</div>
<small class="lgi-text">Quisque non tortor ultricies, posuere elit id, lacinia purus curabitur.</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/3.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Jeannette Lawson</div>
<small class="lgi-text">Donec congue tempus ligula, varius hendrerit mi hendrerit sit amet. Duis ac quam sit amet leo feugiat iaculis</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/4.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Darla Mckinney</div>
<small class="lgi-text">Duis tincidunt augue nec sem dignissim scelerisque. Vestibulum rhoncus sapien sed nulla aliquam lacinia</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/2.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Rudolph Perez</div>
<small class="lgi-text">Phasellus a ullamcorper lectus, sit amet viverra quam. In luctus tortor vel nulla pharetra bibendum</small>
</div>
</a>
</div>
</div>
<div class="tab-pane fade" id="sua-tasks">
<ul class="sua-menu list-inline list-unstyled palette-Green-400 bg">
<li><a href=""><i class="zmdi zmdi-time"></i> Archived</a></li>
<li><a href=""><i class="zmdi zmdi-check-all"></i> Mark all</a></li>
<li><a href="" data-ma-action="sidebar-close"><i class="zmdi zmdi-close"></i> Close</a></li>
</ul>

<div class="list-group lg-alt c-overflow">
<div class="list-group-item">
<div class="lgi-heading m-b-5">HTML5 Validation Report</div>

<div class="progress">
<div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width: 95%">
<span class="sr-only">95% Complete (success)</span>
</div>
</div>
</div>
<div class="list-group-item">
<div class="lgi-heading m-b-5">Google Chrome Extension</div>

<div class="progress">
<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
<span class="sr-only">80% Complete (success)</span>
</div>
</div>
</div>
<div class="list-group-item">
<div class="lgi-heading m-b-5">Social Intranet Projects</div>

<div class="progress">
<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
<span class="sr-only">20% Complete</span>
</div>
</div>
</div>
<div class="list-group-item">
<div class="lgi-heading m-b-5">Bootstrap Admin Template</div>

<div class="progress">
<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
<span class="sr-only">60% Complete (warning)</span>
</div>
</div>
</div>
<div class="list-group-item">
<div class="lgi-heading m-b-5">Youtube Client App</div>

<div class="progress">
<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
<span class="sr-only">80% Complete (danger)</span>
</div>
</div>
</div>
</div>

<a href="" class="btn btn-float btn-danger m-btn">
<i class="zmdi zmdi-plus"></i>
</a>
</div>
</div>
</aside>

<aside id="s-main-menu" class="sidebar">
<div class="smm-header">
<i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
</div>

<ul class="smm-alerts">
<li data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
<i class="zmdi zmdi-email"></i>
</li>
<li data-user-alert="sua-notifications" data-ma-action="sidebar-open" data-ma-target="user-alerts">
<i class="zmdi zmdi-notifications"></i>
</li>
<li data-user-alert="sua-tasks" data-ma-action="sidebar-open" data-ma-target="user-alerts">
<i class="zmdi zmdi-view-list-alt"></i>
</li>
</ul>

<ul class="main-menu">
<li>
<a href="index.html"><i class="zmdi zmdi-home"></i> Home</a>
</li>
<li class="sub-menu">
<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-notifications-active"></i> Aprobaciones pendientes</a>

<ul>
<li><a href="alternative-header.html"> De comedores</a></li>
<li><a href="HU001.html"> De personas</a></li>
</ul>
</li>
<li class="sub-menu">
<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-local-dining"></i> Comedores</a>
<ul>
<li><a href="index.html"> Eventos</a></li>
<li><a href="index.html"> Personal</a></li>
</ul>
</li>

<li class="sub-menu">
<a href="" data-ma-action="submenu-toggle"><i class="zmdi zmdi-swap-alt"></i> Mantenimiento SUC</a>
<ul>
<li><a href="colors.html">Insumos</a></li>
<li><a href="input_type/search">Tipo de Insumos</a></li>
<li><a href="food_type/search">Tipo de Alimento</a></li>
<li><a href="animations.html">Asignaci�n de Roles</a></li>
</ul>
</li>
</ul>
</aside>

<section id="content">
<div class="container">
<div class="card">
<div class="card-header">
<h2>Sales Statistics <small>Vestibulum purus quam scelerisque, mollis nonummy metus</small></h2>

<ul class="actions">
<li>
<a href="">
<i class="zmdi zmdi-check-all"></i>
</a>
</li>
<li>
<a href="">
<i class="zmdi zmdi-trending-up"></i>
</a>
</li>
<li class="dropdown">
<a href="" data-toggle="dropdown">
<i class="zmdi zmdi-more-vert"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right">
<li>
<a href="">Change Date Range</a>
</li>
<li>
<a href="">Change Graph Type</a>
</li>
<li>
<a href="">Other Settings</a>
</li>
</ul>
</li>
</ul>
</div>

<div class="card-body">
<div class="chart-edge">
<div id="curved-line-chart" class="flot-chart "></div>
</div>
</div>
</div>

<div id="c-grid" class="clearfix" data-columns>
<div class="card c-dark palette-Light-Blue bg">
<div class="card-header">
<h2>Website Impressions <small>Consectetur Ultricies Porta Fringilla</small></h2>

<ul class="actions a-alt">
<li class="dropdown">
<a href="" data-toggle="dropdown">
<i class="zmdi zmdi-more-vert"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right">
<li>
<a href="">Change Date Range</a>
</li>
<li>
<a href="">Change Graph Type</a>
</li>
<li>
<a href="">Other Settings</a>
</li>
</ul>
</li>
</ul>
</div>
<div class="card-body card-padding">
<h2 class="m-t-0 m-b-15 c-white">
<i class="zmdi zmdi-caret-up-circle m-r-5"></i>
987,453
</h2>

<div class="sparkline-1 text-center"></div>
</div>
</div>

<div class="card c-dark palette-Green-A700 bg">
<div class="card-header">
<h2>Website Traffics <small>Nullam Adipiscing Pellentesque</small></h2>

<ul class="actions a-alt">
<li class="dropdown">
<a href="" data-toggle="dropdown">
<i class="zmdi zmdi-more-vert"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right">
<li>
<a href="">Change Date Range</a>
</li>
<li>
<a href="">Change Graph Type</a>
</li>
<li>
<a href="">Other Settings</a>
</li>
</ul>
</li>
</ul>
</div>
<div class="card-body card-padding">
<h2 class="m-t-0 m-b-15 c-white">
<i class="zmdi zmdi-caret-up-circle m-r-5"></i>
356,785K
</h2>
<div class="sparkline-2 text-center"></div>
</div>
</div>

<div class="card c-dark palette-Blue-Grey bg">
<div class="card-header">
<h2>Total Sales <small>Purus Malesuada Consectetur</small></h2>

<ul class="actions a-alt">
<li class="dropdown">
<a href="" data-toggle="dropdown">
<i class="zmdi zmdi-more-vert"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right">
<li>
<a href="">Change Date Range</a>
</li>
<li>
<a href="">Change Graph Type</a>
</li>
<li>
<a href="">Other Settings</a>
</li>
</ul>
</li>
</ul>
</div>
<div class="card-body card-padding">
<h2 class="m-t-0 m-b-15 c-white">
<i class="zmdi zmdi-caret-down-circle m-r-5"></i>
$458,778
</h2>
<div class="sparkline-3 text-center"></div>
</div>
</div>

<div class="card palette-Red-400 bg">
<div class="pie-grid clearfix text-center">
<div class="col-xs-4 col-sm-6 col-md-4 pg-item">
<div class="easy-pie-2 easy-pie" data-percent="92">
<span class="ep-value">92</span>
</div>
<div class="pgi-title">Email<br> Scheduled</div>
</div>
<div class="col-xs-4 col-sm-6 col-md-4 pg-item">
<div class="easy-pie-3 easy-pie" data-percent="11">
<span class="ep-value">11</span>
</div>
<div class="pgi-title">Email<br> Bounced</div>
</div>
<div class="col-xs-4 col-sm-6 col-md-4 pg-item">
<div class="easy-pie-4 easy-pie" data-percent="52">
<span class="ep-value">52</span>
</div>
<div class="pgi-title">Email<br> Opened</div>
</div>
<div class="col-xs-4 col-sm-6 col-md-4 pg-item">
<div class="easy-pie-2 easy-pie" data-percent="44">
<span class="ep-value">44</span>
</div>
<div class="pgi-title">Storage<br>Remaining</div>
</div>
<div class="col-xs-4 col-sm-6 col-md-4 pg-item">
<div class="easy-pie-3 easy-pie" data-percent="78">
<span class="ep-value">78</span>
</div>
<div class="pgi-title">Web Page<br> Views</div>
</div>
<div class="col-xs-4 col-sm-6 col-md-4 pg-item">
<div class="easy-pie-4 easy-pie" data-percent="32">
<span class="ep-value">32</span>
</div>
<div class="pgi-title">Server<br> Processing</div>
</div>
</div>
</div>

<div class="card popular-post">
<div class="card-header ch-img" style="background-image: url(img/headers/4.png); height: 150px;">
<h2>Recent Posts <small>Venenatis Sollicitudin Ipsum</small></h2>

<button class="btn palette-Light-Green bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></button>
</div>
<div class="card-body m-t-20">
<div class="list-group lg-alt">
<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/1.jpg" alt="">
</div>

<div class="media-body">
<div class="lgi-heading">David Villa Jacobs</div>
<small class="lgi-text">Sorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis lobortis sapien non posuere</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/5.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Candice Barnes</div>
<small class="lgi-text">Quisque non tortor ultricies, posuere elit id, lacinia purus curabitur.</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/3.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Jeannette Lawson</div>
<small class="lgi-text">Donec congue tempus ligula, varius hendrerit mi hendrerit sit amet. Duis ac quam sit amet leo feugiat iaculis</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/4.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Darla Mckinney</div>
<small class="lgi-text">Duis tincidunt augue nec sem dignissim scelerisque. Vestibulum rhoncus sapien sed nulla aliquam lacinia</small>
</div>
</a>

<a href="" class="list-group-item media">
<div class="pull-left">
<img class="avatar-img" src="img/profile-pics/2.jpg" alt="">
</div>
<div class="media-body">
<div class="lgi-heading">Rudolph Perez</div>
<small class="lgi-text">Phasellus a ullamcorper lectus, sit amet viverra quam. In luctus tortor vel nulla pharetra bibendum</small>
</div>
</a>

<a href="" class="list-group-item view-more">
<i class="zmdi zmdi-long-arrow-right"></i> View all
</a>
</div>
</div>
</div>

<div class="card c-dark palette-Amber bg">
<div class="card-header p-b-0">
<h2>For the past 30 days <small>Tortor Magna Parturient</small></h2>
<ul class="actions a-alt">
<li class="dropdown">
<a href="" data-toggle="dropdown">
<i class="zmdi zmdi-more-vert"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right">
<li>
<a href="">Change Date Range</a>
</li>
<li>
<a href="">Change Graph Type</a>
</li>
<li>
<a href="">Other Settings</a>
</li>
</ul>
</li>
</ul>
</div>
<div class="card-body">
<div class="chart-edge">
<div class="ns-chart flot-chart m-b-20" id="number-stats-chart"></div>
</div>

<div class="list-group lg-alt lg-even-white">
<div class="list-group-item media">
<div class="pull-right hidden-sm">
<div class="sparkline-bar-1"></div>
</div>

<div class="media-body ns-item">
<small>Page Views</small>
<h3>47,896,536</h3>
</div>
</div>

<div class="list-group-item media">
<div class="pull-right hidden-sm">
<div class="sparkline-bar-2"></div>
</div>

<div class="media-body ns-item">
<small>Site Visitors</small>
<h3>24,456,799</h3>
</div>
</div>

<div class="list-group-item media">
<div class="pull-right hidden-sm">
<div class="sparkline-bar-3"></div>
</div>

<div class="media-body ns-item">
<small>Total Clicks</small>
<h3>13,965</h3>
</div>
</div>
</div>

<div class="p-5"></div>
</div>
</div>

<div class="card c-dark palette-Grey bg recent-signups">
<div class="card-header p-b-0">
<h2>Most Recent Signups <small>Magna Cursus Malesuada</small></h2>
<ul class="actions a-alt">
<li class="dropdown">
<a href="" data-toggle="dropdown">
<i class="zmdi zmdi-more-vert"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right">
<li>
<a href="">Change Date Range</a>
</li>
<li>
<a href="">Change Graph Type</a>
</li>
<li>
<a href="">Other Settings</a>
</li>
</ul>
</li>
</ul>
</div>

<div class="card-body">
<div class="sparkline-1 p-30"></div>

<ul class="rs-list">
<li>
<a href="">
<div class="avatar-char">B</div>
</a>
</li>
<li>
<a href="">
<img class="avatar-img" src="img/profile-pics/5.jpg" alt="">
</a>
</li>
<li>
<a href="">
<div class="avatar-char">L</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">A</div>
</a>
</li>
<li>
<a href="">
<img class="avatar-img" src="img/profile-pics/4.jpg" alt="">
</a>
</li>
<li>
<a href="">
<div class="avatar-char">Z</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">I</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">S</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">C</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">W</div>
</a>
</li>
<li>
<a href="">
<img class="avatar-img" src="img/profile-pics/3.jpg" alt="">
</a>
</li>
<li>
<a href="">
<div class="avatar-char">A</div>
</a>
</li>
<li>
<a href="">
<img class="avatar-img" src="img/profile-pics/9.jpg" alt="">
</a>
</li>
<li>
<a href="">
<div class="avatar-char">N</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">X</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">V</div>
</a>
</li>
<li>
<a href="">
<img class="avatar-img" src="img/profile-pics/7.jpg" alt="">
</a>
</li>
<li>
<a href="">
<img class="avatar-img" src="img/profile-pics/6.jpg" alt="">
</a>
</li>
<li>
<a href="">
<img class="avatar-img" src="img/profile-pics/8.jpg" alt="">
</a>
</li>
<li>
<a href="">
<div class="avatar-char">F</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">E</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">A</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">A</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">M</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">O</div>
</a>
</li>
<li>
<a href="">
<div class="avatar-char">I</div>
</a>
</li>
</ul>
</div>
</div>

<div class="card" id="todo-lists">
<div class="card-header ch-dark palette-Purple-300 bg">
<h2>Todo lists <small>Mattis Malesuada Risus</small></h2>

<ul class="actions a-alt">
<li class="dropdown">
<a href="" data-toggle="dropdown">
<i class="zmdi zmdi-more-vert"></i>
</a>

<ul class="dropdown-menu dropdown-menu-right">
<li>
<a href="">Change Date Range</a>
</li>
<li>
<a href="">Change Graph Type</a>
</li>
<li>
<a href="">Other Settings</a>
</li>
</ul>
</li>
</ul>
</div>

<div class="card-body">
<div class="list-group lg-alt">
<div class="list-group-item-header palette-Purple text">Today</div>

<div class="list-group-item media">
<div class="pull-left">
<div class="avatar-char ac-check">
<input class="acc-check" type="checkbox" checked>

<span class="acc-helper palette-Purple-300 bg">C</span>
</div>
</div>

<div class="media-body">
<div class="lgi-heading">Consectetur Sem Sollicitudin</div>
<small class="lgi-text">08:55 AM</small>
</div>
</div>

<div class="list-group-item media">
<div class="pull-left">
<div class="avatar-char ac-check">
<input class="acc-check" type="checkbox" checked>

<span class="acc-helper palette-Purple-300 bg">E</span>
</div>
</div>
<div class="media-body">
<div class="lgi-heading">Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</div>
<small class="lgi-text">07:32 AM</small>
</div>
</div>

<div class="list-group-item-header palette-Light-Blue text">Tomorrow</div>

<div class="list-group-item media">
<div class="pull-left">
<div class="avatar-char ac-check">
<input class="acc-check" type="checkbox">

<span class="acc-helper palette-Light-Blue bg">P</span>
</div>
</div>
<div class="media-body">
<div class="lgi-heading">Porta Venenatis Quam</div>
<small class="lgi-text">10:30 P</small>
</div>
</div>

<div class="list-group-item media">
<div class="pull-left">
<div class="avatar-char ac-check">
<input class="acc-check" type="checkbox">

<span class="acc-helper palette-Light-Blue bg">N</span>
</div>
</div>
<div class="media-body">
<div class="lgi-heading">Nullam quis risus eget urna mollis ornare vel eu leo</div>
<small class="lgi-text">11:02 PM</small>
</div>
</div>

<a href="" class="list-group-item view-more">
<i class="zmdi zmdi-long-arrow-right"></i> View all
</a>
</div>

<button class="btn palette-Purple-300 bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></button>
</div>
</div>

<div class="card" id="calendar-widget">
<div class="card-header cw-header palette-Teal-400 bg">
<div class="cwh-year"></div>
<div class="cwh-day"></div>

<button class="btn palette-Light-Green bg btn-float waves-effect waves-circle waves-float"><i class="zmdi zmdi-plus"></i></button>
</div>

<div class="card-body card-padding-sm">
<div id="cw-body"></div>
</div>
</div>

<div class="card">
<div class="card-header ch-img" style="background-image: url(img/demo/note.png); height: 250px;"></div>
<div class="card-header">
<h2>
Pellentesque Ligula Fringilla

<small>by Malinda Hollaway on 19th June 2015 at 09:10 AM</small>
</h2>
</div>
<div class="card-body card-padding">
<p>Donec ullamcorper nulla non metus auctor fringilla. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Vestibulum id ligula porta felis euismod semper. Nulla vitae elit libero, a pharetra </p>

<a href="" class="view-more"><i class="zmdi zmdi-long-arrow-right"></i> View Article...</a>
</div>
</div>
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
<circle class="plc-path" cx="50" cy="50" r="20"/>
</svg>
</div>
</div>

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
<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="vendors/bower_components/Waves/dist/waves.min.js"></script>
<script src="vendors/bootstrap-growl/bootstrap-growl.min.js"></script>
<script src="vendors/bower_components/moment/min/moment.min.js"></script>
<script src="vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script src="vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
<script src="vendors/bower_components/salvattore/dist/salvattore.min.js"></script>

<script src="vendors/bower_components/flot/jquery.flot.js"></script>
<script src="vendors/bower_components/flot/jquery.flot.resize.js"></script>
<script src="vendors/bower_components/flot.curvedlines/curvedLines.js"></script>
<script src="vendors/sparklines/jquery.sparkline.min.js"></script>
<script src="vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="js/flot-charts/curved-line-chart.js"></script>
<script src="js/flot-charts/line-chart.js"></script>

<!-- Placeholder for IE9 -->
<!--[if IE 9 ]>
<script src="vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
<![endif]-->

<script src="js/charts.js"></script>

<script src="js/functions.js"></script>
<script src="js/actions.js"></script>
<script src="js/demo.js"></script>

</body>
</html>