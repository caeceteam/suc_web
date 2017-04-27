<form method="post" action="<?php echo $accion; ?>" role="form">
  <div class="form-group">
    <label for="cuil"><?php echo lang('html_persona_label_cuil')?>:</label>
    <input type="text" class="form-control" name="cuil">
  </div>
  <button type="submit" class="btn btn-default"><?php echo lang('html_persona_button_buscar')?></button>
  <a href="<?php echo base_url("persona/alta");?>" class="btn btn-success" role="button"><?php echo lang('html_persona_button_alta')?></a>
</form>

<?php
if (!empty($tabla)) {
	echo $tabla;
}
?>