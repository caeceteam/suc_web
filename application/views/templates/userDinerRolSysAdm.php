<div class="col-sm-4">
	<label>Rol</label> <select class="chosen"
		data-placeholder="<?php echo ($reset) ? 'Tareas en el comedor' : set_value('rol', utf8_decode($this->form_data->role)); ?>"
		id="role" name="role">
		<option value=SYS_ADMIN
			<?php if ($this->form_data->role == SYS_ADMIN || $this->form_data->role == '' ){echo 'selected';} ?>>Administrador de Sistema</option>
		<option value=GUEST
			<?php if ($this->form_data->role == GUEST){echo 'selected';}; ?>>Invitado</option>
	</select>
</div>

