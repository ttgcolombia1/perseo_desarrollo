<?php
if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {
    $miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

    switch ($opcion) {
        case "segundaIdentificacion":
            $variable="pagina=".$miPaginaActual;
            $variable.="&redireccionar=true";
            $variable.="&opcion=segundaIdentificacion";
            $variable.="&usuario=".$valor["id_usuario"];
            $variable.="&tiempo=".$valor["tiempo"];
            $variable.="&sesionID=".$valor["sesionID"];
            break;

        case "indexVotante":
            $variable="pagina=indexVotante";
            $variable.="&redireccionar=true";
            $variable.="&mensaje=bienvenida";
            $variable.="&usuario=".$valor["id_usuario"];
            $variable.="&tiempo=".time();
            $variable.="&sesionID=".$valor["sesionID"];
            break;

        case "indexVeedor":
            $variable="pagina=indexVeedor";
            $variable.="&redireccionar=true";
            $variable.="&mensaje=bienvenida";
            $variable.="&usuario=".$valor["id_usuario"];
            $variable.="&tiempo=".time();
            $variable.="&sesionID=".$valor["sesionID"];
            break;

        case "indexDelegado":
            $variable="pagina=indexDelegado";
            $variable.="&redireccionar=true";
            $variable.="&mensaje=bienvenida";
            $variable.="&usuario=".$valor["id_usuario"];
            $variable.="&tiempo=".time();
            $variable.="&sesionID=".$valor["sesionID"];
            break;

        case "indexAdministrador":
            $variable="pagina=indexAdministrador";
            $variable.="&redireccionar=true";
            $variable.="&mensaje=bienvenida";
            $variable.="&usuario=".$valor["id_usuario"];
            $variable.="&tiempo=".time();
            $variable.="&sesionID=".$valor["sesionID"];
            break;

        case "indexSalas":
            $variable="pagina=indexSalas";
            $variable.="&redireccionar=true";
            $variable.="&mensaje=bienvenida";
            $variable.="&usuario=".$valor["id_usuario"];
            $variable.="&tiempo=".time();
            $variable.="&sesionID=".$valor["sesionID"];
            break;

        case "paginaPrincipal":
            $variable="pagina=index";
                        $variable.="&redireccionar=true";
            if (isset($valor) && $valor!='') {
                $variable.="&mostrarMensaje=".$valor;
            }
            break;


    }

    foreach ($_REQUEST as $clave=>$valor) {
        unset($_REQUEST[$clave]);
    }


    $enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
    $variable=$this->miConfigurador->fabricaConexiones->crypto->codificar($variable);

    $_REQUEST[$enlace]=$variable;
    $_REQUEST["recargar"]=true;
}
