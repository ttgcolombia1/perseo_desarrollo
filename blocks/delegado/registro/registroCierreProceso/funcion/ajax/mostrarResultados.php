<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
/**
 * La conexiòn que se debe utilizar es la principal de SARA
*/
$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


$cadena_sql=$this->sql->cadena_sql("resultados",''); 

$resultadoVotoDecodificado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

if($resultadoVotoDecodificado)
{
	$cadena_sql=$this->sql->cadena_sql("resultadosDecodificados",''); 
	$registro=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
	//var_dump($registro);
	
	
}else
{
	
	
}

?>
