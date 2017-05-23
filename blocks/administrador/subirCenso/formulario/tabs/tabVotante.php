<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}


$tab = 1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);

$conexion = "voto";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


$atributos["id"] = "divDatos";
$atributos["estilo"] = "marcoBotones";
//$atributos["estiloEnLinea"]="display:none";
//echo $this->miFormulario->division("inicio",$atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "identificacion";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "50";
$atributos["ancho"] = 350;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["validar"] = "minSize[5]";
$atributos["categoria"] = "";
$atributos["verificar"] = "true";
$atributos["validar"] = "required, minSize[5], custom[integer]";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


//-------------Control cuadroTexto-----------------------
$esteCampo = "nombreCompleto";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "50";
$atributos["ancho"] = 350;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["categoria"] = "fecha";
$atributos["verificar"] = "true";
$atributos["validar"] = "required, minSize[4]";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


$esteCampo = "tipoestamento";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["seleccion"] = 0;
$atributos["evento"] = 2;
$atributos["columnas"] = "1";
$atributos["limitar"] = false;
$atributos["tamanno"] = 1;
$atributos["ancho"] = 350;
$atributos["estilo"] = "jqueryui";
$atributos["etiquetaObligatorio"] = true;
$atributos["validar"] = "required";
$atributos["anchoEtiqueta"] = 350;
$atributos["obligatorio"] = true;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"] = $this->sql->cadena_sql("tipoestamento");
$atributos["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

//------------------Fin Division para los botones-------------------------
//echo $this->miFormulario->division("fin");

//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

//-------------Control Boton-----------------------
$esteCampo = "botonAceptar";
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

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

$atributos["id"] = "eleccion"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = false;
$atributos["etiqueta"] = "";
$atributos["valor"] = $_REQUEST['eleccion'];
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$atributos["id"] = "estamento"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = false;
$atributos["etiqueta"] = "";
$atributos["valor"] = $_REQUEST['estamento'];
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


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

