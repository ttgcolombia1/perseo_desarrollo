<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}	


//1. Cerrar proceso de votación

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}

$cadena_sql = $this->sql->cadena_sql('cerrarProceso');

$resultado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"acceso");
if($resultado==true){
	$this->funcion->redireccionar('exitoCierre','' );
}else{
	$this->funcion->redireccionar('errorCierre','' );
}




?>