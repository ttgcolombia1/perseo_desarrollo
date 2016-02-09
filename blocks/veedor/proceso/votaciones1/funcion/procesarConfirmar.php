<?
if(!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}else {
//Revisar si el identificador existe.
//Pasar de la tabla borrador a la tabla definitiva...
//Si han cancelado entonces borrar borrador y redireccionar al indice...
var_dump($_REQUEST);exit;

/**
 * La conexiòn que se debe utilizar es la principal de SARA
*/
$conexion="voto";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


$cadena_sql=$this->sql->cadena_sql("resultados",''); 
$resultadoVotoDecodificado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

if($resultadoVotoDecodificado)
{
	
}else
{
	//-------------Control texto-----------------------
	$esteCampo="mensajeVotacionesAbiertas";
	$atributos["tamanno"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["etiqueta"]="";
	$atributos["mensaje"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["columnas"]=""; //El control ocupa 47% del tamaño del formulario
	echo $this->miFormulario->campoMensaje($atributos);
	unset($atributos);
}
	
}   

?>