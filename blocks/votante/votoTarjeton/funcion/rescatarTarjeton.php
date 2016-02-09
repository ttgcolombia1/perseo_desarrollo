<?php

$this->sql = new SqlvotoTarjeton();

$conexion = "voto";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("rescatarTarjeton", $votaciones);
$tarjeton = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
?>
