<?php
if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

    $miPaginaActual = $this->miConfigurador->getVariableConfiguracion("pagina");

    switch ($opcion) {
        case "cargaExitosa":
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=mensaje";
            $variable .= "&mensaje=cargaExitosa";
            $variable .= "&eleccion=" . $valor[0];
            $variable .= "&nombreeleccion=" . $valor[1];
            $variable .= "&proceso=" . $valor[2];
            $variable .= "&yaEsta=" . $valor[3];
            $variable .= "&cargados=" . $valor[4];
            break;

        case "archivoNoValido":
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=mensaje";
            $variable .= "&mensaje=archivoNoValido";
            $variable .= "&eleccion=" . $valor[0];
            $variable .= "&nombreeleccion=" . $valor[1];
            $variable .= "&proceso=" . $valor[2];
            break;

        case "progresoArchivo":
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=progresoArchivo";
            $variable .= "&proceso=" . $valor[0];
            $variable .= "&idEleccionBD=" . $valor[1];
            $variable .= "&nombreEleccion=" . $valor[2];
            $variable .= "&nombreDestino=" . $valor[3];
            break;

        case "noCargaArchivo":
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=mensaje";
            $variable .= "&mensaje=noCargaArchivo";
            $variable .= "&eleccion=" . $valor[0];
            $variable .= "&nombreeleccion=" . $valor[1];
            $variable .= "&proceso=" . $valor[2];
            break;

        case "votanteNoEncontrado":
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=mensaje";
            $variable .= "&mensaje=votanteNoEncontrado";
            break;

        case "votanteEncontrado":
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=detalleVotante";
            $variable .= "&identificacion=$valor[0]";
            $variable .= "&proceso=$valor[1]";
            break;

        case "votanteGuardado":
            $variable = "pagina=" . $miPaginaActual;
            $variable .= "&opcion=mensaje";
            $variable .= "&mensaje=votanteGuardado";
            $variable .= "&eleccion=".$valor[0];
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
