<?php

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");

$miSesion = Sesion::singleton();


{ //-------------Lista No numerada --------------------------------------------
//Votaciones
$item = 'votaciones';
$items[$item]['nombre'] = 'Mi Votación';
$items[$item]['enlace'] = true; //El li es un enlace directo, dejar false si existe submenus
$items[$item]['icono'] = 'ui-icon-circle-triangle-e'; //El li es un enlace directo
$enlace = 'pagina=indexVotante';
$enlace.= '&usuario=' . $miSesion->getSesionUsuarioId();
$items[$item]['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlace, $directorio);

//Cerrar Sesión
$item = 'cerrarSesion';
$items[$item]['nombre'] = 'Cerrar Sesión';
$items[$item]['enlace'] = true; //El <li> es un enlace directo
$items[$item]['icono'] = 'ui-icon-extlink'; //El <li> es un enlace directo
$enlace = 'pagina=cerrarSesionVotante';
$enlace.= '&usuario=' . $miSesion->getSesionUsuarioId();

$items[$item]['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlace, $directorio);

$atributos ['id'] = 'menuLateralVotante';
$atributos ['estilo'] = 'jqueryui';
$atributos ["enlaces"]=true;
$atributos['items']=$items;
echo $this->miFormulario->listaNoOrdenada($atributos);

}// -----------------Fin Lista no numerada -------------------------------------


// ----------------------División ----------------------------------





?>