<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 * 
 *  La ruta absoluta del bloque está definida en $this->ruta
 */


$esteBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");

$nombreFormulario=$esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();

$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

//-----------------División Contenedor -----------------------------------
$esteCampo='resultados';
$atributos["id"]=$esteCampo;
$atributos["estilo"]=$esteCampo;
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);


include($this->ruta."formulario/frmResultados.php");

//-----------------Fin Division para la pestaña 1-------------------------
echo $this->miFormulario->division("fin");





?>
