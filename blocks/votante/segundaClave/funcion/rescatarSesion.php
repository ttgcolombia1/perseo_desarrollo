<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $cadena_sql = "SELECT sesionid, variable, valor, expiracion FROM gearbox_valor_sesion"; //$this->sql->cadena_sql("rescatarValorSesion", "");
    $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    if ($resultado != null) {
        $id_usuario = trim($resultado[0]['valor']);
    }
}
?>
