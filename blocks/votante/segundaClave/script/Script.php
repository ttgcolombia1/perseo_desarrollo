<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */

// Registrar los archvios js que deben incluirse

$funcion=array();
$indice=0;

$embebido[$indice]=true;
$funcion[$indice++]="miScript.js";

//Se coloca esta condición para evitar cargar algunos scripts en el formulario de confirmación de entrada de datos.
if(!isset($_REQUEST["opcion"])||(isset($_REQUEST["opcion"]) && $_REQUEST["opcion"]!="confirmar")){
	$funcion[$indice++]="jquery.validationEngine.js";
	$funcion[$indice++]="jquery.validationEngine-es.js";
	$funcion[$indice++]="jquery-te.js";
	$funcion[$indice++]="datepicker_es.js";
	$funcion[$indice++]="combobox.js";
	$funcion[$indice++]="chosen.jquery.js";
	$funcion[$indice++]="ajax-chosen.min.js";
	$funcion[$indice++]="select2.js";
	$funcion[$indice++]="select2_locale_es.js";
        $funcion[$indice++]="miScript.js";
}

$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($esteBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$esteBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$esteBloque["grupo"]."/".$esteBloque["nombre"];
}


foreach ($funcion as $clave=>$nombre){
	if(!isset($embebido[$clave])){
		echo "\n<script type='text/javascript' src='".$rutaBloque."/script/".$nombre."'>\n</script>\n";
	}else{
		echo "\n<script type='text/javascript'>";
		include($nombre);
		echo "\n</script>\n";
	}
}
/**
 * Incluir los scripts que deben registrarse como javascript pero requieren procesamiento previo de código php
 */


?>
