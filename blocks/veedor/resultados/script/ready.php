<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
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
	
	$(function() {
		$(document).tooltip();
	});
	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	});

	
<?php 
}
?>
