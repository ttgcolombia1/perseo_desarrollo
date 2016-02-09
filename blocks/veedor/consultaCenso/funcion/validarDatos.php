<?php

ini_set('display_errors', 0);

if ($_REQUEST['nombre'] == null && $_REQUEST['tipoDocAnterior'] == null && $_REQUEST['numeroDocAnterior'] == null &&
        $_REQUEST['tipoDocNuevo'] == null && $_REQUEST['numeroDocNuevo'] == null && $_REQUEST['correoPrincipal'] == null &&
        $_REQUEST['correoInstitucional'] == null && $_REQUEST['telefonoFijo'] == null && $_REQUEST['telefonoCelular'] == null &&
        $_REQUEST['direccion'] == null && $_REQUEST['codigo'] == null && $_REQUEST['facultad'] == null && $_REQUEST['carrera'] == null &&
        $_REQUEST['anoGraduado'] == null && $_REQUEST['periodoGraduado'] == null && $_REQUEST['acta'] == null && $_REQUEST['folio'] == null ) {
    $mensaje = "...Por favor ingrese todos los datos solicitados...";
    $error = "error";
    $datos = array("mensaje" => $mensaje, "error" => $error);
    $this->redireccionar("mostrarMensaje", $datos);
}

$_REQUEST['nombre'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['nombre']);
$_REQUEST['tipoDocAnterior'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['tipoDocAnterior']);
$_REQUEST['numeroDocAnterior'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['numeroDocAnterior']);
$_REQUEST['tipoDocNuevo'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['tipoDocNuevo']);
$_REQUEST['numeroDocNuevo'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['numeroDocNuevo']);
$_REQUEST['correoPrincipal'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['correoPrincipal']);
$_REQUEST['correoInstitucional'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['correoInstitucional']);
$_REQUEST['telefonoFijo'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['telefonoFijo']);
$_REQUEST['telefonoCelular'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['telefonoCelular']);
$_REQUEST['direccion'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['direccion']);
$_REQUEST['codigo'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['codigo']);
$_REQUEST['facultad'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['facultad']);
$_REQUEST['carrera'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['carrera']);
$_REQUEST['anoGraduado'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['anoGraduado']);
$_REQUEST['periodoGraduado'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['periodoGraduado']);
$_REQUEST['acta'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['acta']);
$_REQUEST['folio'] = $this->validar->eliminarCaracteresEspeciales($_REQUEST['folio']);


$mensaje = null;

//Valida si los campos ingresados son nulos
if ($_REQUEST['tipoCenso'] != "egresado") {

    if ($_REQUEST['tipoDocNuevo'] == null) {
        $mensaje .= "<li>tipo de documento </li>";
    }
    if ($_REQUEST['numeroDocNuevo'] == null) {
        $mensaje .= "<li>número de documento</li>";
    }
    if ($_REQUEST['correoPrincipal'] == null) {
        $mensaje .= "<li>correo principal</li>";
    }
    if ($_REQUEST['nombre'] == null) {
        $mensaje .= "<li>nombre</li>";
    }


    if ($_REQUEST['idRegistro'] === "noRegistrado") {
        if ($_REQUEST['codigo'] == null) {
            $mensaje.="<li>código</li>";
        }
        if ($_REQUEST['facultad'] == null) {
            $mensaje.="<li>facultad</li>";
        }
        if ($_REQUEST['carrera'] == null) {
            $mensaje.="<li>carrera</li>";
        }
        if ($_REQUEST['anoGraduado'] == null) {
            $mensaje.="<li>año graduado</li>";
        }
        if ($_REQUEST['periodoGraduado'] == null) {
            $mensaje.="<li>periodo graduado</li>";
        }
        if ($_REQUEST['acta'] == null) {
            $mensaje.="<li>acta graduado</li>";
        }
        if ($_REQUEST['folio'] == null) {
            $mensaje.="<li>folio graduado</li>";
        }
    } else {
        if ($_REQUEST['tipoDocAnterior'] == null) {
            $mensaje.="tipo de documento anterior";
        }
        if ($_REQUEST['numeroDocAnterior'] == null) {
            $mensaje.="número de documento anterior";
        }
    }


    if ($_REQUEST['codigo'] == null) {
        $_REQUEST['codigo'] = null;
    }
    if ($_REQUEST['facultad'] == null) {
        $_REQUEST['facultad'] = '';
    }
    if ($_REQUEST['carrera'] == null) {
        $_REQUEST['carrera'] = '';
    }
    if ($_REQUEST['anoGraduado'] == null) {
        $_REQUEST['anoGraduado'] = null;
    }
    if ($_REQUEST['periodoGraduado'] == null) {
        $_REQUEST['periodoGraduado'] = null;
    }
    if ($_REQUEST['direccion'] == null) {
        $_REQUEST['direccion'] = '';
    }
    if ($_REQUEST['correoInstitucional'] == null) {
        $_REQUEST['correoInstitucional'] = '';
    }
    if ($_REQUEST['correoPrincipal'] == null) {
        $_REQUEST['correoPrincipal'] = '';
    }
}

if ($_REQUEST['telefonoFijo'] == null || $_REQUEST['telefonoFijo'] == "" || strlen($_REQUEST['telefonoFijo']) == 0) {
    $_REQUEST['telefonoFijo'] = 0;
}

if ($_REQUEST['telefonoCelular'] == null || $_REQUEST['telefonoCelular'] == "" || strlen($_REQUEST['telefonoCelular']) == 0) {
    $_REQUEST['telefonoCelular'] = 0;
}

if ($_REQUEST['anoGraduado'] == null || $_REQUEST['anoGraduado'] == "" || strlen($_REQUEST['anoGraduado']) == 0) {
    $_REQUEST['anoGraduado'] = 0;
}

if ($_REQUEST['periodoGraduado'] == null || $_REQUEST['periodoGraduado'] == "" || strlen($_REQUEST['periodoGraduado']) == 0) {
    $_REQUEST['periodoGraduado'] = 0;
}



if ($this->validar->soloLetrasEspacio($_REQUEST['nombre']) != true) {
    $mensaje .= "<li>El campo nombre debe contener solo letras</li>";
}

if ($_REQUEST['numeroDocAnterior'] != 0 && $_REQUEST['numeroDocAnterior'] != null && $_REQUEST['numeroDocAnterior'] != '') {
    if ($this->validar->soloNumerosLetras($_REQUEST['numeroDocAnterior']) != true) {
        $mensaje .= "<li>El campo numero de documento anterior no tiene formato valido</li>";
    }
}

if ($_REQUEST['numeroDocNuevo'] != 0 && $_REQUEST['numeroDocNuevo'] != null && $_REQUEST['numeroDocNuevo'] != '') {
    if ($this->validar->soloNumerosLetras($_REQUEST['numeroDocNuevo']) != true) {
        $mensaje .= "<li>El campo numero de documento nuevo no tiene formato valido</li>";
    }
}

if ($_REQUEST['correoPrincipal'] != 0 && $_REQUEST['correoPrincipal'] != null && $_REQUEST['correoPrincipal'] != '') {
    if ($this->validar->validarCorreo($_REQUEST['correoPrincipal']) != true) {
        $mensaje .= "<li>El campo correo principal no tiene formato valido</li>";
    }
}

if ($_REQUEST['correoInstitucional'] != 0 && $_REQUEST['correoInstitucional'] != null && $_REQUEST['correoInstitucional'] != '') {
    if ($this->validar->validarCorreo($_REQUEST['correoInstitucional']) != true) {
        $mensaje .= "<li>El campo correo institucional no tiene formato valido</li>";
    }
}

if ($_REQUEST['telefonoFijo'] != 0) {
    if ($this->validar->validarTelefonoFijo($_REQUEST['telefonoFijo']) != true) {
        $mensaje .= "<li>Formato del teléfono fijo no valido</li>";
    }
}
if ($_REQUEST['telefonoCelular'] != 0) {
    if ($this->validar->validarTelefonoCelular() != true) {
        $mensaje .= "<li>Formato del teléfono celular no valido</li>";
    }
}

if ($_REQUEST['direccion'] != 0 && $_REQUEST['direccion'] != null && $_REQUEST['direccion'] != '') {
    if ($this->validar->soloNumerosLetras($_REQUEST['direccion']) != true) {
        $mensaje .= "<li>El campo dirección  no tiene formato valido, debe contener solo números y letras</li>";
    }
}

if ($_REQUEST['codigo'] != 0 && $_REQUEST['codigo'] != null && $_REQUEST['codigo'] != '') {
    if ($this->validar->soloNumeros($_REQUEST['codigo']) != true) {
        if ($this->validar->validaLongitud($_REQUEST['codigo'], 4, 11) != true) {
            $mensaje .= "<li>El campo código  no tiene formato valido</li>";
        }
    }
}

if ($_REQUEST['anoGraduado'] != 0 && $_REQUEST['anoGraduado'] != null && $_REQUEST['anoGraduado'] != '') {
    if ($this->validar->soloNumeros($_REQUEST['anoGraduado']) == true) {
        if ($this->validar->validaLongitud($_REQUEST['anoGraduado'], 4, 4) != true) {
            $mensaje .= "<li>El campo año graduado no tiene formato valido</li>";
        }
    }
}

if ($_REQUEST['periodoGraduado'] != 0 && $_REQUEST['periodoGraduado'] != null && $_REQUEST['periodoGraduado'] != '') {
    if ($this->validar->soloNumeros($_REQUEST['periodoGraduado']) == true) {
        if ($this->validar->validaLongitud($_REQUEST['periodoGraduado'], 1, 1) != true) {
            $mensaje .= "<li>El campo año graduado no tiene formato valido</li>";
        }
    }
}

if ($_REQUEST['acta'] != 0 && $_REQUEST['acta'] != null && $_REQUEST['acta'] != '') {
    if ($this->validar->soloNumerosLetras($_REQUEST['acta']) != true) {
        $mensaje .= "<li>El campo acta  no tiene formato valido, debe contener solo números y letras</li>";
    }
}

if ($_REQUEST['folio'] != 0 && $_REQUEST['folio'] != null && $_REQUEST['folio'] != '') {
    if ($this->validar->soloNumerosLetras($_REQUEST['folio']) != true) {
        $mensaje .= "<li>El campo folio  no tiene formato valido, debe contener solo números y letras</li>";
    }
}


if ($mensaje != null) {
    $mensaje = "<p>Por favor ingrese verifique la siguiente información: " . $mensaje . "</p>";
    return $mensaje;    
} else {
    return null;
}
?>
