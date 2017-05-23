<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];
$rutaImagen = $rutaBloque . '/imagenes/';

// ------------------Division-------------------------

$esteCampo = 'divMenuSuperior';
$atributos ["id"] = $esteCampo;
$atributos ['estilo'] = $esteCampo;
echo $this->miFormulario->division("inicio", $atributos);
unset ($atributos);

// -------------Control campoTexto-----------------------

//-------------------------------Mensaje-------------------------------------

unset($atributos);
echo $this->miFormulario->division("fin");
$esteCampo = 'divContenedor';
$atributos ["id"] = $esteCampo;
$atributos ['estilo'] = $esteCampo;
echo $this->miFormulario->division("inicio", $atributos);
unset ($atributos);

$esteCampo = 'nombreUniversidad';
$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos["estilo"] = 'titulocabeza';
$atributos["tipo"] = '';
$atributos ["etiqueta"] = 'encabezado2';
$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->campoMensaje($atributos);

//-------------------------------Mensaje-------------------------------------
$esteCampo = 'mensajeNombre';
$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
$atributos["estilo"] = "nombrevotante";
$atributos["tipo"] = '';
$atributos ["etiqueta"] = 'simple';
//$atributos["mensaje"] = ucwords(strtolower(trim($datosUsuario [0] ['NOMBRE'])));
$atributos["mensaje"] = ucwords(mb_strtolower(trim($datosUsuario [0] ['NOMBRE']),'UTF-8'));

echo $this->miFormulario->campoMensaje($atributos);
unset($atributos);

$esteCampo = 'reloj';
$atributos ['id'] = $esteCampo;
$atributos ['estilo'] = $esteCampo;
echo $this->miFormulario->division('inicio', $atributos);
echo $this->miFormulario->division('fin');
unset($atributos);



$esteCampo = 'horaServidor';
$atributos ['id'] = $esteCampo;
$atributos ['tipo'] = 'hidden';
$atributos ['valor'] = date('d M Y G:i:s');
echo $this->miFormulario->campoCuadroTexto($atributos);
echo $this->miFormulario->division("fin");
unset($atributos);
