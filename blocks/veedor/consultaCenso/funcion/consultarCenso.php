<?php

$conexion = "votocenso";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("consultarCenso", $_REQUEST["idUsuario"]);
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if ($resultado == true) {
    $resultado = urlencode(serialize($resultado));
    $resultado = $this->miConfigurador->fabricaConexiones->crypto->codificar($resultado);
    //$this->redireccionar("mostrarActualizacion",$resultado); // se comentarea para que no sepuedan actualizar datos
    $this->redireccionar("mostrarMensajeRegistro", $_REQUEST["idUsuario"]);
} else {
    $this->redireccionar("mostrarMensajeNoRegistro", $_REQUEST["idUsuario"]);
}

?>
