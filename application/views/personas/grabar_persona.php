<form method="post" action="<?php echo $accion; ?>" role="form" id="persona_form">
  <div class="form-group">
    <label for="cuil"><?php echo lang('html_persona_label_cuil')?>:</label>
    <input type="text" class="form-control" name="cuil" value="<?php echo set_value('cuil',$this->datos_formulario->cuil); ?>">
    <label for="nombre"><?php echo lang('html_persona_label_nombre')?>:</label>
    <input type="text" class="form-control" name="nombre" value="<?php echo set_value('nombre',$this->datos_formulario->nombre); ?>" id="nombre">
    <label for="apellido"><?php echo lang('html_persona_label_apellido')?>:</label>
    <input type="text" class="form-control" name="apellido" value="<?php echo set_value('apellido',$this->datos_formulario->apellido); ?>">
    <label for="mail"><?php echo lang('html_persona_label_mail')?>:</label>
    <input type="text" class="form-control" name="mail" value="<?php echo set_value('mail',$this->datos_formulario->mail); ?>">
  </div>
  <button type="submit" class="btn btn-success"><?php echo lang('html_persona_button_grabar')?></button>
  <button type="submit" class="btn btn-primary" id="submit"><?php echo lang('html_persona_button_grabar_ax')?></button>
  <?php echo $cancelar; ?>
  <br/><br/>
  <?php echo $mensaje; ?>
   <div class="alert alert-success hidden" id="main_content"></div>
</form>