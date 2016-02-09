<?

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

    $mensaje = "";

    $_REQUEST["pregunta1"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["pregunta1"]);
    $_REQUEST["respuesta1"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["respuesta1"]);
//    $_REQUEST["pregunta2"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["pregunta2"]);
//    $_REQUEST["respuesta2"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["respuesta2"]);
    $_REQUEST["clave"] = $this->validar->eliminarCaracteresEspeciales($_REQUEST["clave"]);

    
    if ($_REQUEST["pregunta1"] == null || strlen($_REQUEST["pregunta1"]) == 0 ||
            $_REQUEST["respuesta1"] == null || strlen($_REQUEST["respuesta1"]) == 0 ||
//            $_REQUEST["pregunta2"] == null || strlen($_REQUEST["pregunta2"]) == 0 ||
//            $_REQUEST["respuesta2"] == null || strlen($_REQUEST["respuesta2"]) == 0 ||
            $_REQUEST["clave"] == null || strlen($_REQUEST["clave"]) == 0) {
        $mensaje .= "<li>Todos los campos marcados con asterisco (*) son obligatorios.</li>";
    }

    if ($this->validar->soloNumeros($_REQUEST['pregunta1']) == true) {
        if ($this->validar->validaLongitud($_REQUEST['pregunta1'], 2, 1) != true) {
            $mensaje .= "<li>La pregunta 1 no tiene formato valido</li>";
        }
    }

//    if ($this->validar->soloNumeros($_REQUEST['pregunta2']) == true) {
//        if ($this->validar->validaLongitud($_REQUEST['pregunta2'], 2, 1) != true) {
//            $mensaje .= "<li>La pregunta 2 no tiene formato valido</li>";
//        }
//    }

    if ($this->validar->validaLongitud($_REQUEST['respuesta1'], 30, 2) != true) {
        $mensaje .= "<li>La respuesta 1 no tiene formato valido</li>";
    }

//    if ($this->validar->validaLongitud($_REQUEST['respuesta2'], 30, 2) != true) {
//        $mensaje .= "<li>La respuesta 2 no tiene formato valido</li>";
//    }

    if ($this->validar->soloNumeros($_REQUEST['clave']) == true) {
        if ($this->validar->validaLongitud($_REQUEST['clave'], 4, 4) != true) {
            $mensaje .= "<li>La clave no tiene formato valido</li>";
        }
    }

    if ($mensaje != null) {
        $mensaje = "<p>Por favor ingrese verifique la siguiente información: " . $mensaje . "</p>";
        
    }     
    
}
?>