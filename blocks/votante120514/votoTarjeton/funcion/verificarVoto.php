<?php

$this->sql = new SqlvotoTarjeton();

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$arregloEleccion = array($votaciones['eleccion'], $usuario);

$cadena_sql = $this->sql->cadena_sql("verificarVoto", $arregloEleccion);
$votoRegistrado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

return $votoRegistrado;
?>
