<?

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {
    
    $miSesion = Sesion::singleton();

    $miPaginaActual = $this->miConfigurador->getVariableConfiguracion("pagina");
    switch ($opcion) {


        case "regresar":
            $variable = "pagina=segundaClave"; //pendiente la pagina para modificar parametro     
            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
            break;

        case "actualizarSegundaClave":
            $datos = urlencode(serialize($datos));
            $variable = "pagina=" . $miPaginaActual;
            $variable.="&opcion=nuevo";
            $variable.="&opcion1=actualizar";
            $variable.="&datos=" . $datos;
            break;

        case "mostrarMensaje":
            $variable = "pagina=" . $miPaginaActual;
            $variable.="&opcion=mostrarMensaje";
            $variable.="&mensaje=" . $datos["mensaje"];
            $variable.="&error=" . $datos["error"];
            break;

        case "paginaPrincipal":
            $variable = "pagina=index";
            break;
    }

    foreach ($_REQUEST as $clave => $valor) {
        unset($_REQUEST[$clave]);
    }

    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar($variable);

    $_REQUEST[$enlace] = $variable;
    $_REQUEST["recargar"] = true;
}
?>