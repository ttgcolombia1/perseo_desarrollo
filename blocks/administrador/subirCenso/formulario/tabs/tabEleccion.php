<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

//$directorio = $this->miConfigurador->getVariableConfiguracion("host");
//$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
//$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

$directorioEnlace = $this->miConfigurador->getVariableConfiguracion("host");
$directorioEnlace.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioEnlace.=$this->miConfigurador->getVariableConfiguracion("enlace");

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
//$valorCodificado="action=".$esteBloque["nombre"];
$valorCodificado="&opcion=cargarArchivo";
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$miSesion = Sesion::singleton();
$nombreFormulario="Eleccion".$idEleccion;

$arrayEleccion = array($proceso, $idEleccion);

$this->cadena_sql = $this->sql->cadena_sql("consultaEleccion", $arrayEleccion);
$resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

if ($resultadoEleccion) {
    $idEleccion = $resultadoEleccion[0]['ideleccion'];
}

$tab=1;

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$atributos["titulo"]=$nombreFormulario;
echo $this->miFormulario->formulario("inicio", $atributos);
unset($atributos);

$atributos["id"]="divSubirCensoEleccion";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo="nombreEleccion".$idEleccion;
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]="Digite el nombre de la elección: ";
$atributos["titulo"]="Digite el nombre de la elección ";
$atributos["tabIndex"]=$tab++;
$atributos["tamanno"]=40;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["categoria"]="";
$atributos["deshabilitado"] = true;
$atributos["texto"] = $resultadoEleccion[0]['nombre'];
echo $this->miFormulario->campoTexto($atributos);
unset($atributos);

//------------------Control Lista Desplegable------------------------------
$esteCampo = "tipoestamento".$idEleccion;
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["evento"] = 2;
$atributos["columnas"] = "1";
$atributos["limitar"] = false;
$atributos["tamanno"] = 1;
$atributos["ancho"] = "250px";
$atributos["estilo"] = "jqueryui";
$atributos["etiquetaObligatorio"] = true;
$atributos["anchoEtiqueta"] = 250;
$atributos["etiqueta"] = "Tipo de estamento: ";
$atributos["deshabilitado"] = true;
$atributos["seleccion"] = $resultadoEleccion[0]['tipoestamento'];

//-----De donde rescatar los datos ---------
$atributos["cadena_sql"] = $this->sql->cadena_sql("tipoestamento");
$atributos["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

  //-------------Control cuadroTexto-----------------------
$esteCampo="descripcion".$idEleccion;
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]="Digite la descripción de la elección: ";
$atributos["titulo"]="Digite la descripción de la elección ";
$atributos["tabIndex"]=$tab++;
$atributos["tamanno"]=40;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["categoria"]="";
$atributos["deshabilitado"] = true;
$atributos["texto"] = $resultadoEleccion[0]['descripcion'];
echo $this->miFormulario->campoTexto($atributos);
unset($atributos);


//-------------Control cuadroTexto-----------------------
$esteCampo="fechaInicio".$idEleccion;
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]="Fecha de inicio: ";
$atributos["titulo"]="Fecha de inicio de la elección ";
$atributos["tabIndex"]=$tab++;
$atributos["tamanno"]=25;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["deshabilitado"] = true;
$atributos["texto"] = $resultadoEleccion[0]['fechainicio'];
echo $this->miFormulario->campoTexto($atributos);
unset($atributos);

  //-------------Control cuadroTexto-----------------------
$esteCampo="fechaFin".$idEleccion;
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]="Fecha de finalización: ";
$atributos["titulo"]="Fecha de finalización de la elección ";
$atributos["tabIndex"]=$tab++;
$atributos["tamanno"]=25;
$atributos["etiquetaObligatorio"] = true;
$atributos["deshabilitado"] = true;
$atributos["texto"]="";
$atributos["estilo"]="jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["deshabilitado"] = true;
$atributos["texto"] = $resultadoEleccion[0]['fechafin'];
echo $this->miFormulario->campoTexto($atributos);
unset($atributos);

$esteCampo = "marcoDatosSubirCensoEleccion";
$atributos["estilo"] = "jqueryui";
$atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
unset($atributos);

  if ($resultadoEleccion) {
      //-------------Control cuadroTexto-----------------------
      $esteCampo="archivoEleccion".$idEleccion;
      $atributos["id"]=$esteCampo;
      $atributos["etiqueta"]="Seleccione el archivo del censo: ";
      $atributos["titulo"]="Seleccione el archivo";
      $atributos["tabIndex"]=$tab++;
      $atributos["obligatorio"]=true;
      $atributos["tamanno"]=40;
      $atributos["columnas"] = 1;
      $atributos["etiquetaObligatorio"] = true;
      $atributos["tipo"]="file";
      $atributos["estilo"]="jqueryui";
      $atributos["anchoEtiqueta"] = 250;
      $atributos["validar"]="required";
      $atributos["categoria"]="";

      echo $this->miFormulario->campoCuadroTexto($atributos);
      unset($atributos);

      $esteCampo="llavehash";
      $atributos["id"]=$esteCampo;
      $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
      $atributos["titulo"]='';//$this->lenguaje->getCadena($esteCampo."Titulo");
      $atributos["tabIndex"]=$tab++;
      $atributos["obligatorio"]=true;
      $atributos["tamanno"]="50";
      $atributos["ancho"] = 350;
      $atributos["etiquetaObligatorio"] = true;
      $atributos["tipo"]="";
      $atributos["estilo"]="jqueryui";
      $atributos["anchoEtiqueta"] = 250;
      $atributos["validar"]="minSize[64] required";
      $atributos["categoria"]="";
      echo $this->miFormulario->campoCuadroTexto($atributos);
      unset($atributos);
  } else {

      $esteCampo = 'noCargaCenso';
      $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
      $atributos["etiqueta"] = "";
      $atributos["estilo"] = "centrar";
      $atributos["tipo"] = "information";
      $atributos["mensaje"] = "Primero debe realizar la parametrización de esta elección";
      echo $this->miFormulario->cuadroMensaje($atributos);
      unset($atributos);
  }

//Fin de Conjunto de Controles
echo $this->miFormulario->marcoAGrupacion("fin");

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");


//------------------Division para los botones-------------------------
$atributos["id"]="botones";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

if ($resultadoEleccion) {
  //-------------Control Boton-----------------------
  $esteCampo="enviar";
  $atributos["id"]=$esteCampo;
  $atributos["tabIndex"]=$tab++;
  $atributos["tipo"]="boton";
  $atributos["estilo"]="jqueryui";
  $atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
  $atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
  $atributos["valor"]="Cargar Archivo Censo";
  $atributos["nombreFormulario"]=$nombreFormulario;
  echo $this->miFormulario->campoBoton($atributos);
  unset($atributos);
}
  //-------------Fin Control Boton----------------------

  //------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

  //-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"]="formSaraData"; //No cambiar este nombre
$atributos["tipo"]="hidden";
$atributos["obligatorio"]=false;
$atributos["etiqueta"]="";
$atributos["valor"]=$valorCodificado;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

  //-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"]="idEleccionBD"; //No cambiar este nombre
$atributos["tipo"]="hidden";
$atributos["obligatorio"]=false;
$atributos["etiqueta"]="";
$atributos["valor"]=$resultadoEleccion[0]['ideleccion'];
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo="nombreEleccion".$resultadoEleccion[0]['ideleccion'];
$atributos["id"]=$esteCampo;
$atributos["tipo"]="hidden";
$atributos["valor"] = $resultadoEleccion[0]['nombre'];
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo="proceso";
$atributos["id"]=$esteCampo;
$atributos["tipo"]="hidden";
$atributos["valor"] = $proceso;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//Fin del Formulario
echo $this->miFormulario->formulario("fin");
