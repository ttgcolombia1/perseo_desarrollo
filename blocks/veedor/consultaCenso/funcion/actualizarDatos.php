<?php

ini_set('display_errors', 0);

$resultado = $this->funcion->validarDatos();

if ($resultado != null) {
    $error = "error";
    $datos = array("mensaje" => $resultado, "error" => $error);
    $this->redireccionar("mostrarMensaje", $datos);
} else {
    if ($_REQUEST['nombre'] == null && $_REQUEST['tipoDocAnterior'] == null && $_REQUEST['numeroDocAnterior'] == null &&
            $_REQUEST['tipoDocNuevo'] == null && $_REQUEST['numeroDocNuevo'] == null && $_REQUEST['correoPrincipal'] == null &&
            $_REQUEST['correoInstitucional'] == null && $_REQUEST['telefonoFijo'] == null && $_REQUEST['telefonoCelular'] == null &&
            $_REQUEST['direccion'] == null && $_REQUEST['codigo'] == null && $_REQUEST['facultad'] == null && $_REQUEST['carrera'] == null &&
            $_REQUEST['anoGraduado'] == null && $_REQUEST['periodoGraduado'] == null && $_REQUEST['botonAceptar'] == null) {
        $mensaje = "Todos los campos marcados con asterísco son obligatorios.";
        $error = "error";
        $datos = array("mensaje" => $mensaje, "error" => $error);
        $this->redireccionar("mostrarMensaje", $datos);
    }

    if ($_REQUEST['tipoCenso'] != "egresado") {
        if ($_REQUEST['codigo'] == null && $_REQUEST['facultad'] == null && $_REQUEST['carrera'] == null && $_REQUEST['anoGraduado'] == null &&
                $_REQUEST['periodoGraduado'] == null) {
            $_REQUEST['codigo'] = null;
            $_REQUEST['facultad'] = '';
            $_REQUEST['carrera'] = '';
            $_REQUEST['anoGraduado'] = null;
            $_REQUEST['periodoGraduado'] = null;
        }
    }

    if ($_REQUEST['telefonoFijo'] == null || $_REQUEST['telefonoFijo'] == "" || strlen($_REQUEST['telefonoFijo']) == 0) {
        $_REQUEST['telefonoFijo'] = 0;
    }

    if ($_REQUEST['telefonoCelular'] == null || $_REQUEST['telefonoCelular'] == "" || strlen($_REQUEST['telefonoCelular']) == 0) {
        $_REQUEST['telefonoCelular'] = 0;
    }

    if ($_REQUEST['codigo'] == null || $_REQUEST['codigo'] == "" || strlen($_REQUEST['codigo']) == 0) {
        $_REQUEST['codigo'] = 0;
    }
    
    if ($_REQUEST['anoGraduado'] == null || $_REQUEST['anoGraduado'] == "" || strlen($_REQUEST['anoGraduado']) == 0) {
        $_REQUEST['anoGraduado'] = 0;
    }

    if ($_REQUEST['periodoGraduado'] == null || $_REQUEST['periodoGraduado'] == "" || strlen($_REQUEST['periodoGraduado']) == 0) {
        $_REQUEST['periodoGraduado'] = 0;
    }
    
//    if ($_REQUEST['acta'] == null || $_REQUEST['acta'] == "" || strlen($_REQUEST['acta']) == 0) {
//        $_REQUEST['acta'] = null;
//    }
//    
//    if ($_REQUEST['folio'] == null || $_REQUEST['folio'] == "" || strlen($_REQUEST['folio']) == 0) {
//        $_REQUEST['folio'] = null;
//    }


//Generar contraseña
    $_REQUEST['clave'] = $this->randomString();

    $conexion = "votocenso";
    try {

        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if ($_REQUEST['idRegistro'] === "noRegistrado") {

            $cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("insertarCensoNoRegistrado", "");
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
            

            if ($resultado == true) {
                $mensaje = "La información se ha actualizado exitosamente, vamos a verificar su registro y en los próximos días se notificará a su correo electrónico el proceso a seguir.";
                $error = "exito";
                $datos = array("mensaje" => $mensaje, "error" => $error);
                $this->redireccionar("mostrarMensaje", $datos);
            } else {
                $mensaje = "...Oops, se ha presentado un error, por favor contacte al administrador del sistema...";
                $error = "error";
                $datos = array("mensaje" => $mensaje, "error" => $error);
                $this->redireccionar("mostrarMensaje", $datos);
            }
        } else {
            $cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("actualizarCenso", $_REQUEST);
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

            if ($resultado == true) {

                $msj = $this->funcion->enviarCorreoClave($_REQUEST['idRegistro'], $_REQUEST['correoPrincipal'], $_REQUEST['numeroDocNuevo'], $_REQUEST['clave']);
                $mensaje = $_REQUEST['votacionMensaje'] . "<br>" . $msj;

                $error = "exito";
                $datos = array("mensaje" => $mensaje, "error" => $error);
                $this->redireccionar("mostrarMensaje", $datos);
            } else {
                $mensaje = "...Oops, se ha presentado un error, por favor contacte al administrador del sistema...";
                $error = "error";
                $datos = array("mensaje" => $mensaje, "error" => $error);
                $this->redireccionar("mostrarMensaje", $datos);
            }
        }
    } catch (Exception $e) {
        $mensaje = "...Oops, se ha presentado un error, por favor contacte al administrador del sistema... " . $e;
        $error = "error";
        $datos = array("mensaje" => $mensaje, "error" => $error);
        $this->redireccionar("mostrarMensaje", $datos);
    }
}
?>
