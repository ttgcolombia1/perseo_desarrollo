
$(function() {
    $("#contenedorResultados").hide();
});



	$(function() {
		$("#entradaElemento").submit(function() {
	
			var filasGrilla = $('#gridElementos').jqGrid('getRowData');
	
			var datos = JSON.stringify(filasGrilla);
	
			// Pasar la grilla a un control del formulario
	
			$("#grillaElementos").val(datos);
			
			$resultado=$("#entradaElemento").validationEngine("validate");
	
			if ($resultado) {
				// console.log(filasGrilla);
				return true;
			}
			
			return false;
		});
	});
	
	
	$(function() {
		$("button").button().click(function(event) {
			event.preventDefault();
		});
	});
	
	
	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	});

	
