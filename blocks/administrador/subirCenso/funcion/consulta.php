<?php
if(!isset($GLOBALS["autorizado"]))
{
    include("index.php");
    exit;

}else {

    $miSesion = Sesion::singleton();
    $usuarioSoporte = $miSesion->getSesionUsuarioId();
    $identificacionVotante =  $_REQUEST['identificacionVotante'];
    $idProceso = $_REQUEST['proceso'];
    $conexion="estructura";
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $consulta = array($identificacionVotante,"",$idProceso);
    $cadena_sql = $this->sql->cadena_sql("validarDatoCenso", $consulta);
    $resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    if($resultadoProcesos){

        // Redireccionar a la vista de listado
        $votante = array($resultadoProcesos[0]['identificacion'],$resultadoProcesos[0]['procesoelectoral_idprocesoelectoral']);
        $this->funcion->redireccionar("votanteEncontrado",$votante);

    }else{

        $this->funcion->redireccionar("votanteNoEncontrado");

    }



}