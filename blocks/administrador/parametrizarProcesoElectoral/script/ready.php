<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
 $("#nombreLista").select2();

 $(function() {
    $( "#accordion" )
        .accordion({
            header: "> div > h3"
            })
            .sortable({
            axis: "y",
            handle: "h3",
            stop: function( event, ui ) {
            // IE doesn't register the blur when sorting
            // so trigger focusout handlers to remove .ui-state-focus
            ui.item.children( "h3" ).triggerHandler( "focusout" );
        }
    });
});

        // Asociar el widget de validación al formulario
        $("#parametrizarProcesoElectoral").validationEngine({
            promptPosition : "centerRight", 
            scroll: false
        });

        $(function() {
            $("#parametrizarProcesoElectoral").submit(function() {
                $resultado=$("#parametrizarProcesoElectoral").validationEngine("validate");
                
                if ($resultado) {
                
                    return true;
                }
                return false;
            });
        });

        $("#tipoestamento").select2();
        
       
        
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
                promptPosition : "bottomLeft", 
                scroll: false,
                autoHidePrompt: true,
                autoHideDelay: 3000
            });
            
            $(function() {
                $("#Eleccion" + i).submit(function() {
                    $resultado=$("#Eleccion" + i).validationEngine("validate");

                    if ($resultado) {
                            if($("#fechaInicio" + i).val() > $("#fechaFin" + i).val())
                            {
                                alert('La fecha de inicio de la elección es mayor a la de finalización');
                                return false;
                            }else
                            {                                
                                if($("#nombreLista" + i).val() == '' || $("#posicionLista" + i).val() == '' || $("#identificacion" + i).val() == '' || $("#nombres" + i).val() == '' || $("#apellidos" + i).val() == '')
                                {
                                    alert('Debe agregar información de los candidatos');
                                    return false;
                                }else
                                {
                                    return true;
                                }                            
                            }
                    }else
                    {
                        return false;
                    }                    
                });
            });
            
            $( "#tiporesultados" + i).change(function() {
                
                if($(this).val() == 2)
                {
                    $("#resultados").css("display","block");
                }else
                {
                    $("#resultados").css("display","none");
                }
            });
            
            $("#tipoestamento" + i).select2();
            $("#tiporesultados" + i).select2();
            $("#tipovotacion" + i).select2();
            $("#restricciones" + i).select2();

            $('#fechaInicio' + i).datetimepicker({
            timeFormat: 'HH:mm:ss',
            dateFormat: 'yy-mm-dd',
            minDate: new Date($('#fechainiProceso' + i).val()),
            maxDate: new Date($('#fechafinProceso' + i).val()),
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
            minDate: new Date($('#fechainiProceso' + i).val()),
            maxDate: new Date($('#fechafinProceso' + i).val()),
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
        
        $(function() {
            $("button").button().click(function(event) {
                    event.preventDefault();
            });
        });
        
	
<?php 
//}
?>



