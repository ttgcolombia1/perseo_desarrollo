<?php 
//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
//if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){

?>
    for(var i=0;i<100;i++)
        {
           
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

                    if ($resultado) 
                    {                           
                        return true;                           
                    }else
                    {
                        return false;
                    }                    
                });
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



