<?php

/**
 * * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 */
include_once("core/builder/FormularioHtml.class.php");

$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
$this->miFormulario=new formularioHtml();

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}

switch($_REQUEST["funcion"]){

	case "#divContadores":
		include_once 'ajax/contadores.php';
		break;
		
		case "#divUsuariosAplicativo":
			include_once 'ajax/usuariosAplicativo.php';
			break;


}


?>