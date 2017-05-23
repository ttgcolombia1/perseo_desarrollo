<?php

include_once("core/crypto/Encriptador.class.php");

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$cripto = Encriptador::singleton();
$miSesion = Sesion::singleton();

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];
$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$nombreFormulario = $esteBloque["nombre"];

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$valorCodificado = "action=".$esteBloque["nombre"];
$valorCodificado .= "&bloque=" . $esteBloque["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado = $cripto->codificar($valorCodificado);

$valorCodificadoNuevo = "pagina=".$esteBloque["nombre"];
$valorCodificadoNuevo .= "&bloque=" . $esteBloque["id_bloque"];
$valorCodificadoNuevo .= "&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificadoNuevo .= "&opcion=nuevoVotante";
$valorCodificadoNuevo .= "&eleccion=".$_REQUEST['proceso'];
$urlvalorCodificadoNuevo = $cripto->codificar_url($valorCodificadoNuevo,$directorio);

if (isset($_REQUEST['proceso'])) {

    $proceso_id = $_REQUEST['proceso'];
    $cadena_sql = $this->sql->cadena_sql("datosProceso", $proceso_id);
    $resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    if($resultadoProcesos){
        $resultadoProcesos = $resultadoProcesos[0];
        $nombreEleccion = $resultadoProcesos["nombre"];
    }


    $atributos["id"]="tabs";
    $atributos["estilo"]="";
    echo $this->miFormulario->division("inicio",$atributos);
    unset($atributos);


    $items=array("tabProceso"=>$this->lenguaje->getCadena("tabConsultaVotante"). " para proceso electoral: $nombreEleccion");

    $atributos["id"]="pestana";
    $atributos["items"]=$items;
    $atributos["estilo"]="jqueryui";
    $atributos["pestañas"]="true";
    echo $this->miFormulario->listaNoOrdenada($atributos);


    $atributos["id"]="tabProceso";
    $atributos["estilo"]="";
    echo $this->miFormulario->division("inicio",$atributos);


    $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
    $rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
    $rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
    $rutaBloque .= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

    $directorio = $this->miConfigurador->getVariableConfiguracion("host");
    $directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
    $directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
    $miSesion = Sesion::singleton();

    $nombreFormulario = $esteBloque["nombre"];


    $tab = 1;

    $atributos["id"] = "consultaCenso";
    $atributos["tipoFormulario"] = "multipart/form-data";
    $atributos["metodo"] = "POST";
    $atributos["nombreFormulario"] = $nombreFormulario;
    $verificarFormulario = "1";
    echo $this->miFormulario->formulario("inicio", $atributos);

    $conexion = "voto";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


    $atributos["id"] = "divDatos";
    $atributos["estilo"] = "marcoBotones";
    $esteCampo = "identificacionVotante";
    $atributos["id"] = $esteCampo;
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
    $atributos["tabIndex"] = $tab++;
    $atributos["obligatorio"] = true;
    $atributos["tamanno"] = "50";
    $atributos["ancho"] = 350;
    $atributos["etiquetaObligatorio"] = true;
    $atributos["tipo"] = "";
    $atributos["estilo"] = "jqueryui";
    $atributos["anchoEtiqueta"] = 250;
    $atributos["categoria"] = "";
    $atributos["verificar"]="true";
    $atributos["validar"]="required, minSize[5], custom[integer]";
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);


    $atributos["id"] = "botones";
    $atributos["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);


    $esteCampo = "botonBuscar";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["tipo"] = "boton";
    $atributos["estilo"] = "";
    $atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
    $atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["nombreFormulario"] = $nombreFormulario;
    echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);

    $esteCampo = "botonCrear";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["tipo"] = "boton";
    $atributos["estilo"] = "";
    $atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
    $atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["nombreFormulario"] = $nombreFormulario;
    //echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);

    $atributos["id"] = "urlNuevo"; //No cambiar este nombre
    $atributos["tipo"] = "hidden";
    $atributos["obligatorio"] = false;
    $atributos["etiqueta"] = "";
    $atributos["valor"] = $urlvalorCodificadoNuevo;
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);


    echo $this->miFormulario->division("fin");




    $atributos["id"] = "formSaraData"; //No cambiar este nombre
    $atributos["tipo"] = "hidden";
    $atributos["obligatorio"] = false;
    $atributos["etiqueta"] = "";
    $atributos["valor"] = $valorCodificado;
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);


    echo $this->miFormulario->formulario("fin");
    echo $this->miFormulario->division("fin");
    echo $this->miFormulario->division("fin");


} else {

    $esteCampo = "errorConsultaProceso";
    $atributos["id"] = $esteCampo;
    $atributos["estilo"] = "centrar";
    $atributos["tipo"] = 'error';
    $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);
    echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos);

}

