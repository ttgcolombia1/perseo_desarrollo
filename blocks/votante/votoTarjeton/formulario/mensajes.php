

<?php
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");

$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

$miSesion = Sesion::singleton();
$usuario = $miSesion->getSesionUsuarioId();

$mensaje = $_REQUEST['mensaje'];
$error = $_REQUEST['error'];
$datos = array("mensaje" => $mensaje, "error" => $error);


//-------------------------------Mensaje-------------------------------------
$esteCampo = $mensaje;
$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos["etiqueta"] = "";
$atributos["estilo"] = "centrar";
$atributos["tipo"] = $error;
if ($datos != null) {
    $atributos["mensaje"] = $mensaje;
}else{
    $atributos["mensaje"] = $mensaje;
}
echo $this->miFormulario->cuadroMensaje($atributos);