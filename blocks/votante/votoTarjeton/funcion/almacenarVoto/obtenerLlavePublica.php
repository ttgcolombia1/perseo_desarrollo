<?php

//Conexión a la base de datos
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

//Obtener los datos de la elección
$cadenaSql = $this->sql->cadena_sql("datosEleccion", $_REQUEST['eleccion']);
$estaEleccion = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

if ($estaEleccion) {

    //Obtener la ruta de la carpeta donde se almacenan las llaves
    $cadenaSql = $this->sql->cadena_sql("rutaLlavePublica", '');
    $rutaLlavePublica = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

    if ($rutaLlavePublica) {
        //Rescatar la llave pública para el proceso electoral  
        $cadenaSql = $this->sql->cadena_sql("llavePublica", $estaEleccion[0]['idproceso']);
        
        $llavePublica = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");
        if ($llavePublica) {
            $resultado = $rutaLlavePublica[0]['valor'].'/'.$llavePublica[0]['nombrellave'];
        }else{
            error_log('No se pudo obtener la llave publica');
            $resultado=false;
        }
    }
}