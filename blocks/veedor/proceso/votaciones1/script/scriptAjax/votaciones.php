<?php
/**
 * @todo Cuando se carga este archivo aún no se tiene ningún ejemplar de las clases del bloque.
 * Esto impide que se puedan datos de las etiquetas desde el archivo locale. Se debe
 *
 */


 
$valor="#totalVotaciones";
$cadenaFinal=$cadenaACodificar."&funcion=".$valor;
$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
$estaUrl=$url. $this->miConfigurador->fabricaConexiones->crypto->codificar_url($cadenaFinal,$enlace);

?>
<script type='text/javascript'>
function getVotaciones(){
				$.ajax({
					url: "<?php echo $estaUrl?>",
					type: "GET",
					dataType: "json",
					success: function(data)
					{
						onDataReceived(data);
					}
				});

			
}


</script>