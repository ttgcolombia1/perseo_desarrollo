<?php

//Conexión a la base de datos
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


// atributos
$variable['eleccion'] = $_REQUEST['eleccion'];
$variable['usuario'] = $_REQUEST['usuario'];

//Verificar si el usuario no tiene registrada una participación en una elección

$cadenaSql = $this->sql->cadena_sql("infoElecciones", $variable);
$horaEleccion = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

if($horaEleccion[0][5] < date('Y-m-d H:i:s'))
    {
        $respuesta=false;
    }else{
        $respuesta=true; 
    }
?>
