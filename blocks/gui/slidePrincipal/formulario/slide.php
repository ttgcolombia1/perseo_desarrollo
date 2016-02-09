<?php
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
// -------------Campo Imagen-----------------------
$esteCampo = 'imagen';
$atributos ["id"] = $esteCampo;
$atributos ['ancho'] = '283px';
$atributos ['alto'] = '';
$atributos ['estilo'] = 'campoImagen textoCentrar';
//$atributos ['estiloImagen'] = '';
$atributos ['imagen'] = $directorio.'/imagen/sabio.png';

echo $this->miFormulario->campoImagen( $atributos );
unset ( $atributos );
