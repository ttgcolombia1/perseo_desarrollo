<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
/**
 * @todo Cuando se carga este archivo aún no se tiene ningún ejemplar de las clases del bloque.
 * Esto impide que se puedan datos de las etiquetas desde el archivo locale. Se debe
 *
 */


$valor="#divContadores";
$cadenaFinal=$cadenaACodificar."&funcion=".$valor;
$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl=$url. $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal,$enlace);

?><script type='text/javascript'>
function contadores(){

	var respuesta=$.ajax({
				url: "<?php echo $estaUrl?>",
				dataType: "html",
				data: {
					idElemento:	$("#idElemento").val()	
				}	 
		})
	 .done(function(data) { 
		 $('<?php echo $valor?>').empty().html(data);
		  
		 })
	 .fail(function() { alert("error"); });

}
</script>