<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
    
    $rutaCandidatos= $this->miConfigurador->getVariableConfiguracion("rutaCandidatos");
    $proceso = $_REQUEST['proceso'];
    $idEleccion = $_REQUEST['idEleccion'];
    $fechaInicio = $_REQUEST['fechaInicio'.$idEleccion];
    $fechaFin = $_REQUEST['fechaFin'.$idEleccion]; 
    $parametros=array( $fechaInicio,$fechaFin,$idEleccion);
    $conexion="estructura";
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $this->cadena_sql = $this->sql->cadena_sql("actualizarFechaEleccion", $parametros);
    $resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
   
    if($resultadoEleccion)
        {  $this->funcion->redireccionar('Actualiza',$proceso);}
    else
        {  $this->funcion->redireccionar('ErrorActualiza',$proceso); }
}
?>