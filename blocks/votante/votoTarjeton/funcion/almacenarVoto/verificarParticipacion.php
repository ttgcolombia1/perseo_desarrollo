<?php

//Conexión a la base de datos
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


// atributos
$variable['eleccion'] = $_REQUEST['eleccion'];
$variable['usuario'] = $_REQUEST['usuario'];

//Verificar si el usuario no tiene registrada una participación en una elección

$cadenaSql = $this->sql->cadena_sql("datosVotoRegistrado", $variable);
$votoAnterior = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

if (!$votoAnterior) {

    $respuesta=true;    
    
}else{
    
    $respuesta=false;
}

?>
