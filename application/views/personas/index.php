<br/>	
	<h1>Alta de Personas</h1>
	<br/>
	<form id="persona_form">
    <?php
	echo form_input('cuil', 'CUIL', 'id="cuil"');
	echo form_input('nombre', 'Nombre', 'id="nombre"');
	echo form_input('apellido', 'Apellido', 'id="apellido"');
	echo form_input('mail', 'Mail', 'id="mail"');
	?>
	<button type="submit" id="submit">Submit</button>
	</form>
<br/>
<div id="main_content" style="color: red">

</div>
<br/>
<?php foreach ($personas as $personas_item): ?>

        <h3><?php echo $personas_item['Nombre']; ?></h3>
        <div class="main">
                <?php echo $personas_item['Apellido']; ?>
        </div>
        <p><a href="<?php echo site_url('persona/view/'.$personas_item['CUIL']); ?>">Ver persona</a></p>
        <p><a href="<?php echo site_url('persona/delete/'.$personas_item['CUIL']); ?>">Baja persona</a></p>
		<br/>
<?php endforeach; ?>
<!-- <p><a href="<?php echo site_url('persona/update'); ?>">Modificar persona</a></p> -->