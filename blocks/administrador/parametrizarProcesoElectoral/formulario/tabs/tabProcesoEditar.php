<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");


$miSesion = Sesion::singleton();

$sesion = $miSesion->getSesionUsuarioId();

$nombreFormulario = $esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton();

$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "/imagen/";

$tab = 1;

$procesoElectoral = $_REQUEST['proceso'];
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("consultarProcesoEditar", $procesoElectoral);
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);

$conexion = "voto";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

?>
<?php
$atributos["id"] = "divDatos";
$atributos["estilo"] = "marcoBotones";
//$atributos["estiloEnLinea"]="display:none";
//echo $this->miFormulario->division("inicio",$atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "nombreProceso";
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
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"] = "required, minSize[5]";
$atributos["valor"] = $resultadoProcesos[0]['nombre'];
$atributos["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


//-------------Control cuadroTexto-----------------------
$esteCampo = "fechaInicio";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "20";
$atributos["ancho"] = 350;
$atributos["etiquetaObligatorio"] = true;
$atributos["deshabilitado"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"] = "required";
$atributos["categoria"] = "fecha";
$atributos["valor"] = $resultadoProcesos[0]['fechainicio'];
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "fechaFin";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "20";
$atributos["ancho"] = 350;
$atributos["etiquetaObligatorio"] = true;
$atributos["deshabilitado"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"] = "required";
$atributos["categoria"] = "fecha";
$atributos["valor"] = $resultadoProcesos[0]['fechafin'];
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


//------------------Fin Division para los botones-------------------------
//echo $this->miFormulario->division("fin");

//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

//-------------Control Boton-----------------------
$esteCampo = "botonActualizar";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["tipo"] = "boton";
$atributos["estilo"] = "";
$atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"] = "Actualizar Fechas";//$this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado .= "&opcion=editarProceso";
$valorCodificado .= "&bloque=" . $esteBloque["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado .= "&proceso=" . $procesoElectoral;
$valorCodificado = $cripto->codificar($valorCodificado);

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


?>
