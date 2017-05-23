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

$rutaCandidatos = $this->miConfigurador->getVariableConfiguracion("host");
$rutaCandidatos .= $this->miConfigurador->getVariableConfiguracion("urlCandidatos");

$miSesion = Sesion::singleton();

$sesion = $miSesion->getSesionUsuarioId();

$nombreFormulario = $esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton();
$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "/imagen/";

$tab = 1;
$candidato = array($_REQUEST['idcandidato'], $_REQUEST['ideleccion']);
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("consultarCandidato", $candidato);
$resultadoCandidato = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
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
echo "<img src='" . $rutaCandidatos . $resultadoCandidato[0]['foto'] . "' width='150px'>";
//-------------Control cuadroTexto-----------------------
$esteCampo = "nombre";
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
$atributos["validar"] = "required, minSize[2]";
$atributos["valor"] = $resultadoCandidato[0]['nombre'];
//$atributos["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "apellido";
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
$atributos["validar"] = "required, minSize[2]";
$atributos["valor"] = $resultadoCandidato[0]['apellido'];
//  $atributos["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


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
$atributos["anchoEtiqueta"] = 350;
$atributos["validar"] = "required, minSize[3],maxSize[12]";
$atributos["valor"] = $resultadoCandidato[0]['identificacion'];
//  $atributos["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "eleccion";
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
$atributos["valor"] = $_REQUEST['eleccion'];
//  $atributos["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


//------------------Control Lista Desplegable------------------------------
$esteCampo = "lista";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["seleccion"] = $resultadoCandidato[0]['idlista'];
$atributos["evento"] = 2;
$atributos["columnas"] = "1";
$atributos["limitar"] = false;
$atributos["tamanno"] = "1";
$atributos["ancho"] = 350;
$atributos["estilo"] = "jqueryui";
$atributos["etiquetaObligatorio"] = true;
$atributos["validar"] = "required";
$atributos["anchoEtiqueta"] = 350;
$atributos["obligatorio"] = true;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"] = $this->sql->cadena_sql("idLista", $_REQUEST['ideleccion']);
$atributos["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "renglon";
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
$atributos["validar"] = "required, minSize[1],custom[integer]";
$atributos["valor"] = $resultadoCandidato[0]['reglon'];
$atributos["deshabilitado"] = false;
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
$atributos["valor"] = "Actualizar Candidato";//$this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado .= "&opcion=editarCandidato";
$valorCodificado .= "&bloque=" . $esteBloque["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado .= "&proceso=" . $_REQUEST['proceso'];
$valorCodificado .= "&ideleccion=" . $_REQUEST['ideleccion'];
$valorCodificado .= "&idcandidato=" . $_REQUEST['idcandidato'];
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
