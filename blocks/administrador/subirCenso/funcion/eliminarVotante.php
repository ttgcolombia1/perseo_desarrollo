<?php
if (!isset($GLOBALS["autorizado"])) {
include("index.php");
exit;
} else {

    $identificacion = $_REQUEST['identificacion'];
    $idEleccion = $_REQUEST['eleccion'];
    $conexion="estructura";
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $consulta = array($identificacion,$idEleccion);
    $cadena_sql = $this->sql->cadena_sql("eliminarDatoCenso", $consulta);
    $resultado= $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

    header('Content-Type: application/json');


    if($resultado){
        $resultado = array("resultado"=>"ok");
    }else{
        $resultado = array("resultado"=>"failed");
    }
    echo json_encode($resultado);


}

