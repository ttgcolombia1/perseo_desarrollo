<?php

/**
 * * Importante: Si se desean los datos del bloque estos se encuentran en el arreglo $esteBloque
 */
// Buscar proveedores
$miSesion= Sesion::singleton();

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if (!$esteRecursoDB) {
    //Este se considera un error fatal
    exit;
}
var_dump($_REQUEST);exit;

switch($_REQUEST["funcion"]){    
    
    case "#aceptaTerminos":
		
		$idUsuario = $_REQUEST['idUsuario'];
		$telefono = $_REQUEST['telefono'];
		$celular = $_REQUEST['celular'];
		$direccion = $_REQUEST['direccion'];
		
		$arreglo = array($idUsuario, $telefono, $celular, $direccion);
		
		$cadena_sql = $this->sql->cadena_sql("aceptaTerminosUser", $arreglo);var_dump($cadena_sql) ;
		$registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
		
		if($registro)
		{
			$respuesta = 'ok';
		}else
		{
			$respuesta = 'no';
		}
        
        break;
    
	case "#noAceptaTerminos":
		
		$cadena_sql = $this->sql->cadena_sql("noAceptaTerminosUser", $_REQUEST["idUsuario"]);
		$registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
		
		$miSesion->terminarSesion($miSesion->getSesionId());
		
		
		if($registro)
		{
			$respuesta = 'ok';
		}else
		{
			$respuesta = 'no';
		}
        
        break;
		
		
}
echo $respuesta;


