<?php
$indice=0;
$estilo[$indice++]="estilos.css";
$estilo[$indice++]="validationEngine.jquery.css";
$estilo[$indice++]="jquery-ui.css";
$estilo[$indice++]="jquery.ui.theme.css";
$estilo[$indice++]="tablasVoto.css";
//Graficas
$estilo[$indice++]="jqplot/jquery.jqplot.min.css";
//Tablas
$estilo[$indice++]="demo_page.css";
$estilo[$indice++]="demo_table.css";
$estilo[$indice++]="jquery.dataTables.css";
$estilo[$indice++]="jquery.dataTables_themeroller.css";
$estilo[$indice++]="ui.jqgrid.css";

$rutaBloque=$this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site");

if($unBloque["grupo"]==""){
	$rutaBloque.="/blocks/".$unBloque["nombre"];
}else{
	$rutaBloque.="/blocks/".$unBloque["grupo"]."/".$unBloque["nombre"];
}

foreach ($estilo as $nombre){
	echo "<link rel='stylesheet' type='text/css' href='".$rutaBloque."/css/".$nombre."'>\n";

}
?>