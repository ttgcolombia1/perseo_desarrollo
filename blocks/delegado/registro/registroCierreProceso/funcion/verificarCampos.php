<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}

/**
 * Realizar una comprobación de la validez de los datos al lado del servidor.
 */	
	
	if(!isset($_REQUEST['fraseSeguridad'])){
		$resultado=false;
	}elseif((strlen($_REQUEST['fraseSeguridad'])>255 || strlen($_REQUEST['fraseSeguridad'])<6)){
		$resultado=false;
	}else{
		$resultado=true;
	}
?>