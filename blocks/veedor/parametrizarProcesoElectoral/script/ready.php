<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
        // Asociar el widget de validación al formulario
        $("#parametrizarProcesoElectoral").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#parametrizarProcesoElectoral").submit(function() {
                $resultado=$("#parametrizarProcesoElectoral").validationEngine("validate");
                if ($resultado) {
                    // console.log(filasGrilla);
                    return true;
                }
                return false;
            });
        });

        $("#tipoestamento").select2();
        
        $('#tablaProcesos').dataTable( {
                "sPaginationType": "full_numbers"
        } );
        
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
        
                
        $(function() {
		$(document).tooltip();
	});
	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	});

        <?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
                
        for(var i=0;i<100;i++)
        {
            $("#segundaClave" + i).switchButton({
                on_label: 'SI',
                off_label: 'NO',
                width: 70,
                height: 20,
                button_width: 25
              });
        
            // Asociar el widget de validación al formulario
            $("#Eleccion" + i).validationEngine({
                promptPosition : "centerRight", 
                scroll: false
            });

            $(function() {
                $("#Eleccion" + i).submit(function() {
                    $resultado=$("#Eleccion" + i).validationEngine("validate");
                    if ($resultado) {
                        return true;
                    }
                    return false;
                });
            });
        
            $("#tipoestamento" + i).select2();
            $("#tipovotacion" + i).select2();
            $("#restricciones" + i).select2();

            $('#fechaInicio' + i).datetimepicker({
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

            $('#fechaFin' + i).datetimepicker({
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
        }
                
        $(function() {
		$(document).tooltip();
	});
	
	// Asociar el widget tabs a la división cuyo id es tabs
	$(function() {
		$("#tabs").tabs();
	}); 
        
        

	
<?php 
//}
?>



