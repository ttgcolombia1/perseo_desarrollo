<?php

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$parametros['idUsuario']=$_REQUEST["idUsuario"];
$cadena_sql =  $this->sql->cadena_sql("consultarVotante", $parametros);
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
//var_dump($resultado);

if ($resultado == true)
{
    $resultado = urlencode(serialize($resultado));
    $resultado = $this->miConfigurador->fabricaConexiones->crypto->codificar($resultado);
    $this->redireccionar("mostrarMensajeRegistro", $_REQUEST["idUsuario"]);
} else {
    $this->redireccionar("mostrarMensajeNoRegistro", $_REQUEST["idUsuario"]);
}

?>
