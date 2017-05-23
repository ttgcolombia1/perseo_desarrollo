<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
    $rutaCandidatos= $this->miConfigurador->getVariableConfiguracion("rutaCandidatos");
    $nombre = $_REQUEST['nombre'];
    $apellidos = $_REQUEST['apellido'];
    $identificacion = $_REQUEST['identificacion'];
    $proceso = $_REQUEST['proceso'];
    $renglon = $_REQUEST['renglon'];
    $lista = $_REQUEST['lista']; 
    $eleccion = $_REQUEST['ideleccion']; 
    $Idcandidato = $_REQUEST['idcandidato'];
    $parametros=array($Idcandidato,$nombre,$apellidos,$identificacion,$renglon,$lista);
    $conexion="estructura";
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $this->cadena_sql = $this->sql->cadena_sql("actualizaCandidatoLista", $parametros);
   // echo $this->cadena_sql;
    $resultadoCandidato = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
    if($resultadoCandidato)
        {  $this->funcion->redireccionar('Actualiza',$proceso);}
    else
        {  $this->funcion->redireccionar('ErrorActualiza',$proceso); }
}
?>