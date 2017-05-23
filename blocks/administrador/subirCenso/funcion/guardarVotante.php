<?php
if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

    $identificacionVotante =  $_REQUEST['identificacion'];
    $nombreCompleto = $_REQUEST['nombreCompleto'];
    $idEleccion = $_REQUEST['eleccion'];
    $estamento = $_REQUEST['tipoestamento'];
    $clave = hash("sha1", hash("md5", $identificacionVotante.'='));
    $segundaIdentificacion = 0;

    $conexion="estructura";
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

    $registro = array($identificacionVotante, $clave, $idEleccion, strtoupper($nombreCompleto), $estamento,$segundaIdentificacion);
    $cadena_sql = $this->sql->cadena_sql("insertarDatoCenso", $registro);
    $resultadoCenso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

    $this->funcion->redireccionar("votanteGuardado",array($idEleccion));




}

