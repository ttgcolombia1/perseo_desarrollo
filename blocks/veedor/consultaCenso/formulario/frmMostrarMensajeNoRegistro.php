<?php

$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");
echo "<img alt='' src='" . $directorio . "formulario/superior.jpg' >";


if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

ini_set('display_errors', 0);
$datos = $this->miConfigurador->fabricaConexiones->crypto->decodificar($_REQUEST['datos']);
$datos = unserialize(urldecode($datos));
$datos = $datos[0];

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];

$conexion = "votocenso";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("consultarActualizacionNoRegistrado", $_REQUEST['idUsuario']);
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$valorCodificado = "pagina=index";

//Se comentarea para no actualizar
//if ($resultado != null) {
//    $valorCodificado.="&action=" . $esteBloque["nombre"];
//}
//$valorCodificado.="&opcion=actualizarNoRegistrado";// Se comentarea para que no actualicen los datos
$valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado.="&idRegistro=" . $datos['censo_id_registro'];
$valorCodificado.="&idUsuario=" . $_REQUEST['idUsuario'];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);


//------------------Division para las pestañas-------------------------
$atributos["id"] = "tabs";
$atributos["estilo"] = "";
echo $this->miFormulario->division("inicio", $atributos);
unset($atributos);

//-------------------------------Mensaje-------------------------------------
$esteCampo = "noIncluidoCenso";
$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos["etiqueta"] = "";
$atributos["estilo"] = "centrar";
$atributos["tipo"] = "information";
if ($resultado != null) {
    $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo) . $this->lenguaje->getCadena("mensaje4");
} else {
    $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);
}
echo $this->miFormulario->cuadroMensaje($atributos);

$tab = 1;

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);


//-------------Control Mensaje-----------------------
$esteCampo = "informacionNoRegistro";
$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos["etiqueta"] = "";
$atributos["estilo"] = "";
$atributos["tipo"] = "message";
$atributos["mensaje"] = $this->lenguaje->getCadena("informacionNoRegistro");
echo $this->miFormulario->cuadroMensaje($atributos);


//if ($resultado != null) {
//
//    $esteCampo = "mensaje4";
//    $atributos["tamanno"] = "";
//    $atributos["estilo"] = "jqueryui";
//    $atributos["etiqueta"] = "";
//    $atributos["texto"] = $this->lenguaje->getCadena($esteCampo);
//    $atributos["columnas"] = ""; //El control ocupa 47% del tamaño del formulario
//    echo $this->miFormulario->campoTexto($atributos);
//    unset($atributos);
//}
//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

//if ($resultado == null) {

//-------------Control Boton-----------------------
//    $esteCampo = "botonActualizar"; // Se comentarea para que no actualicen los datos
    $esteCampo = "botonVolver"; // Se pone el voton para que vuelva
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
//-------------Fin Control Boton----------------------
//} else {
//
////-------------Control Boton-----------------------
//    $esteCampo = "botonCancelar";
//    $atributos["verificar"] = "";
//    $atributos["tipo"] = "boton";
//    $atributos["id"] = $esteCampo;
//    $atributos["cancelar"] = "true";
//    $atributos["tabIndex"] = $tab++;
//    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
//    $atributos["nombreFormulario"] = $nombreFormulario;
//    echo $this->miFormulario->campoBoton($atributos);
//    unset($atributos);
////-------------Fin Control Boton----------------------
//}
//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"] = "formSaraData"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = false;
$atributos["etiqueta"] = "";
$atributos["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


//Fin del Formulario
echo $this->miFormulario->formulario("fin");

//------------------Fin Division para las pestañas-------------------------
echo $this->miFormulario->division("fin");
?>
