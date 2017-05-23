<?php

// atributos
$variable['eleccion'] = $_REQUEST['eleccion'];
$variable['usuario'] = $_REQUEST['usuario'];
$variable['ip'] = $this->obtenerIP();
$variable['tiempo'] = time();
$variable['fecha'] = date('Y-m-d H:m:s');
$variable['textoEncriptado'] = $votoCodificado;


//Conexión a la base de datos
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

//Obtener el estamento del votante
$cadenaSql = $this->sql->cadena_sql("estamentoVotante", $variable);
$estamentoVotante = $esteRecursoDB->ejecutarAcceso($cadenaSql, "busqueda");

if ($estamentoVotante) {
    $variable['estamento'] = $estamentoVotante[0]['idtipo'];

    $transaccion[0] = $this->sql->cadena_sql("insertarVoto", $variable);
    $transaccion[1] = $this->sql->cadena_sql("insertarDatosCenso", $variable);
    $transaccion[2] = $this->sql->cadena_sql("insertarDatosVoto", $variable);
    $registroVoto = $esteRecursoDB->transaccion($transaccion, '');
    
    if ($registroVoto) {
        $respuesta = true;        
    } else {
        $error = 'ErrorIngresarDatoVoto';
        $respuesta = false;
    }
} else {
    $error = 'ErrorRescatarEstamento';
    $respuesta = false;
}

if ($respuesta == false) {
    error_log($error . ':' . $variable['eleccion'] . '|' . $variable['usuario'] . '|' . $variable['ip'] . '|' . $variable['fecha']);
}