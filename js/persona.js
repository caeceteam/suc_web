/**
 * Funcion para dar alta asincronicamente con AJAX
 */
function ax_alta(){
	$('#submit').click(function() {
		var originalLocation;
		originalLocation = window.location.href;
		originalLocation = originalLocation.replace(/\/persona.*/g, "/persona/ax_alta");
		var nombre = $('#nombre').val();
		
		if (!nombre || nombre == 'Nombre') {
			alert('Por favor ingrese su nombre');
			return false;
		}
		
		var form_data = $('#persona_form').serialize();
		
		$.ajax({
			url: originalLocation,
			dataType: 'json',
			type: 'POST',
			data: form_data,
			success: function(msg) {
				if(msg.resultado =='OK')
				{
					$('#main_content').removeClass('hidden');
					$('#main_content').html('Alta por AJAX Ok!');
				}
				else
					$('#main_content').html('Error al dar de alta por AJAX!')
			},
			error: function(msg) {
				res = msg;
				$('#main_content').html('Error al dar de alta por AJAX');
			}
		});
		
		return false;
	});
}

$(document).ready(function() {
	ax_alta();
});