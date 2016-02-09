<?php

if ($_REQUEST["contrasena"] == $_REQUEST["contrasenaConfirm"]) {

    $_REQUEST['usuario'] = $this->funcion->rescatarSesion();
    $_REQUEST['contrasena'] = $this->miConfigurador->fabricaConexiones->crypto->codificar($_REQUEST['contrasena']);
    

    $conexion = "oracleLocal";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("modificaClaveOracle", "");
    $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

    if ($resultado == true) {

        $cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("modificaClaveMySQL", "");
        $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

        if ($resultado == true) {
            
            $cadena_sql = trim($this->cadena_sql = $this->sql->cadena_sql("finalizarTransaccion", $datos));
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "");
            
            $conexion = "mysql";
            $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
            $cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("modificaClaveMySQL", "");
            
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

            if ($resultado == true) {
                $mensaje = " <p><b>...Su contraseña ha sido modificada exitosamente...</b></p>";
                $error = "exito";
            } else {
                $mensaje = "...Oops, se ha presentado un error, por favor intente nuevamente o contacte al administrador del sistema... ";
                $error = "error";
            }
            
        } else {
            $cadena_sql = trim($this->cadena_sql = $this->sql->cadena_sql("cancelarTransaccion", $datos));
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "");            
            $mensaje = "...Oops, se ha presentado un error, por favor intente nuevamente o contacte al administrador del sistema... ";
            $error = "error";
        }
    } else {
        $error = "error";
        $mensaje = "...Oops, se ha presentado un error, por favor contacte al administrador del sistema... ";
    }
} else {
    $mensaje = "...Las contraseñas deben ser iguales... ";
    $error = "error";
}

$datos = array("mensaje" => $mensaje, "error" => $error);
$this->redireccionar("mostrarMensaje", $datos);

//hay que mirar que tabla es la que se afecta en mysql
//
//INSERT INTO gearbox_dbms(
//            nombre, dbms, servidor, puerto, conexionssh, db, usuario, password)
//    VALUES ('mysql', 'mysql', '10.20.0.38', 3306, '', '', ?, ?);
?>
