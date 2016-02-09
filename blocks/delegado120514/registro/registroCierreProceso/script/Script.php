<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */

// Registrar los archvios js que deben incluirse
$funcion = array ();
$indice = 0;
$funcion[$indice++]="jqueryui.js";
$funcion[$indice++]="jquery.validationEngine.js";
$funcion[$indice++]="jquery.validationEngine-es.js";
$funcion[$indice++]="jquery.dataTables.js";
$funcion[$indice++]="jquery.dataTables.min.js";
$funcion[$indice++]="tinymce/tinymce.min.js";
//Graficas
$funcion[$indice++]="jquery.jqGrid.min.js";
$funcion[$indice++]="jqplot/jquery.jqplot.min.js";
$funcion[$indice++]="jqplot/plugins/jqplot.barRenderer.min.js";
$funcion[$indice++]="jqplot/plugins/jqplot.pieRenderer.min.js";
$funcion[$indice++]="jqplot/plugins/jqplot.categoryAxisRenderer.min.js";
$funcion[$indice++]="jqplot/plugins/jqplot.pointLabels.min.js";


if (isset ( $funcion [0] )) {
	
	$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
	$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );
	
	if ($esteBloque ["grupo"] == "") {
		$rutaBloque .= "/blocks/" . $esteBloque ["nombre"];
	} else {
		$rutaBloque .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"];
	}
	
	foreach ( $funcion as $clave => $nombre ) {
		if (! isset ( $embebido [$clave] )) {
			echo "\n<script type='text/javascript' src='" . $rutaBloque . "/script/" . $nombre . "'>\n</script>\n";
		} else {
			echo "\n<script type='text/javascript'>";
			include ($nombre);
			echo "\n</script>\n";
		}
	}
}
/**
 * Incluir los scripts que deben registrarse como javascript pero requieren procesamiento previo de código php
 * ej. Ajax.php
 */

include("Ajax.php");
?>
