<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
 
	$miSesion = Sesion::singleton();
	
	$usuarioSoporte = $miSesion->getSesionUsuarioId(); 
	 
	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
	
	$this->cadena_sql = $this->sql->cadena_sql("inhabilitarProceso", $_REQUEST['proceso']);
	$resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{	
            $idProceso=$esteRecursoDB->ultimo_insertado();
            $this->funcion->redireccionar('inhabilito',$_REQUEST['proceso']);
	}else
	{
		$this->funcion->redireccionar('noInhabilito',$_REQUEST['proceso']);
	}



}
?>