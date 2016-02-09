<?php 
if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

//------------------Division para las pestañas-------------------------
$atributos["id"]="tabs";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);

//-------------------- Listado de Pestañas (Como lista No Ordenada) -------------------------------

$items=array(
    "tabSegundaClave"=>$this->lenguaje->getCadena("tabSegundaClave"),
    );
$atributos["items"]=$items;
$atributos["estilo"]="jqueryui";
$atributos["pestañas"]="true";
echo $this->miFormulario->listaNoOrdenada($atributos);

//------------------Division para la pestaña 1-------------------------
$atributos["id"]="tabSegundaClave";
$atributos["estilo"]="";
echo $this->miFormulario->division("inicio",$atributos);
include($this->ruta."formulario/tabs/tabSegundaClave.php");
//-----------------Fin Division para la pestaña 1-------------------------

echo $this->miFormulario->division("fin");

//------------------Fin Division para las pestañas-------------------------
echo $this->miFormulario->division("fin");

?>
