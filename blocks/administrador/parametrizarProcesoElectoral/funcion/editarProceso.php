<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
    
    $rutaCandidatos= $this->miConfigurador->getVariableConfiguracion("rutaCandidatos");
    $proceso = $_REQUEST['proceso'];
    $fechaInicio = $_REQUEST['fechaInicio'];
    $fechaFin = $_REQUEST['fechaFin']; 
    $parametros=array( $fechaInicio,$fechaFin,$proceso);
    $conexion="estructura";
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $this->cadena_sql = $this->sql->cadena_sql("actualizarProceso", $parametros);
    $resultadoProceso = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
    if($resultadoProceso)
        {  $this->funcion->redireccionar('Actualiza',$proceso);}
    else
        {  $this->funcion->redireccionar('ErrorActualiza',$proceso); }
}
?>