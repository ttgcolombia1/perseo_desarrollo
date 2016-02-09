<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#procesoElectoral").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#procesoElectoral").submit(function() {
                $resultado=$("#procesoElectoral").validationEngine("validate");
                if ($resultado) {
                                
                    if($("#fechaInicio").val() > $("#fechaFin").val())
                    {
                        alert('La fecha de inicio del proceso electoral es mayor a la de finalización');
                        return false;
                    }else
                    {
                        return true;
                    }                    
                }
                return false;
            });
        });
 
        var depe = $("#dependenciasSelect").val();

        $("#dependencias").val([depe]).select2();

        $("#tipovotacion").select2();
        $("#tiporesultados").select2();
        $("#tipoacto").select2();
        
        $('#fechaInicio').datetimepicker({
	timeFormat: 'HH:mm:ss',
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
        $('#fechaFin').datetimepicker({
	timeFormat: 'HH:mm:ss',
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
        $('#fechaacto').datepicker({
        dateFormat: 'yy-mm-dd',
        maxDate: 0,
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
	'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
	monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
	dayNames: ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
	dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa']
        });
        
        $(function() {
		$(document).tooltip();
	});
	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	});

        $(function() {
            $("button").button().click(function(event) {
                    event.preventDefault();
            });
        });
	
<?php 
//}
?>



