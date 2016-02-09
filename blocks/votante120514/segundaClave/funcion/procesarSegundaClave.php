<?php

$miSesion = Sesion::singleton();

$resultado = $this->funcion->validarFormulario();

if ($resultado != "") {
    $error = "error";
    $datos = array("mensaje" => $resultado, "error" => $error);
    $this->redireccionar("mostrarMensaje", $datos);
} else {

    $_REQUEST["pregunta1"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["pregunta1"]);
    $_REQUEST["respuesta1"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["respuesta1"]);
    $_REQUEST["clave"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["clave"]);

    $validacion = ctype_digit($_REQUEST["clave"]);

    $preguntas = array(
        'pregunta1' => $_REQUEST["pregunta1"],
        'respuesta1' => $_REQUEST["respuesta1"]
    );
    
    $preguntas = serialize($preguntas['respuesta1']);      
    $preguntas = $this->miConfigurador->fabricaConexiones->crypto->codificar($preguntas);

    $datos = array(
        'identificacion' => $miSesion->getSesionUsuarioId(),
        'idpregunta' => $_REQUEST["pregunta1"],
        'respuesta' => $preguntas,
        'segundaclave' => $this->miConfigurador->fabricaConexiones->crypto->codificar($_REQUEST["clave"])
    );

    $conexion = 'estructura';
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

    if ($esteRecursoDB == false) {
        $mensaje = "...No se pudo establecer conexión con la base de datos, por favor contacte al administrador del sistema...";
        $error = "error";
        $datos = array("mensaje" => $mensaje, "error" => $error);
    } else {

        if ($validacion == true) {
            
            if (isset($_REQUEST['opcion1']) == "actualizarSegundaClave") {
                $cadena_sql = trim($this->sql->cadena_sql("actualizarSegundaClave", $datos));
            } else {
                $cadena_sql = trim($this->sql->cadena_sql("registrarSegundaClave", $datos));
            }

            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

            if ($resultado == true) {

                //Esta sentencia se deshabilita mientras pasan los datos a mysql
                /* $cadena_sql = $this->sql->cadena_sql("obtenerDatosEgresado", $miSesion->getSesionUsuarioId());
                  $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                  $resultado = $resultado[0];

                  if ($resultado != false) {
                  if ($resultado['CORREO'] != null && strlen($resultado['CORREO']) > 0) {
                  if ($this->validar->validarCorreo($resultado['CORREO']) == true) {
                  $msj = $this->funcion->enviarCorreo(trim($resultado['NOMBRE']), trim($resultado['CORREO']));
                  }
                  }
                  } */

                $mensaje = "La segunda clave se ha actualizado exitosamente, por favor no olvide esta clave ya que con ella podrá participar en las próximas votaciones.";
                $error = "exito";
                $datos = array("mensaje" => $mensaje, "error" => $error);
            } else {

                $cadena_sql = trim($this->sql->cadena_sql("cancelarTransaccion", $datos));
                $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "");
                $mensaje = "...Oops, se ha presentado un error, por favor contacte al administrador del sistema...";
                $error = "error";
                $datos = array("mensaje" => $mensaje, "error" => $error);
            }
        } else {
            $mensaje = "Usted ha proporcionado un valor no válido, por favor intente de nuevo. ";
            $error = "error";
            $datos = array("mensaje" => $mensaje, "error" => $error);
        }
    }

    $this->redireccionar("mostrarMensaje", $datos);
}
?>
