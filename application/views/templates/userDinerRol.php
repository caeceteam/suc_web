<div class="col-sm-4">
	<label >Rol</label> <select class="chosen"
		data-placeholder="<?php echo ($reset) ? 'Tareas en el comedor' : set_value('rol', utf8_decode($this->form_data->role)); ?>"
		id="role" name="role" >
		<option value="99"></option>
		<option value= <?php echo(DINER_ADMIN)?>
			<?php if ($this->form_data->role == DINER_ADMIN || $this->form_data->role == '' ){echo 'selected';} ?>>Administrador</option>
		<option value=<?php echo(EMPLOYEE) ?>
			<?php if ($this->form_data->role == EMPLOYEE){echo 'selected';}; ?>>Colaborador
			del comedor</option>
	</select>
</div>