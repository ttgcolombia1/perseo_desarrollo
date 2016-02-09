<?php

$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");
echo "<img alt='' src='" . $directorio . "formulario/superior.jpg' >";


if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];

ini_set('display_errors', 0);
$valorCodificado = "pagina=index";
$valorCodificado.="&action=" . $esteBloque["nombre"];
$valorCodificado.="&opcion=actualizarDatos";
$valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado.="&idRegistro=noRegistrado";
$valorCodificado.="&idUsuario=".$_REQUEST["idUsuario"];
$valorCodificado.="&votacionMensaje=" . $datos['votacion_mensaje'];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

//------------------Division para las pestañas-------------------------
$atributos["id"] = "tabs";
$atributos["estilo"] = "";
echo $this->miFormulario->division("inicio", $atributos);
unset($atributos);

//-------------------------------Mensaje-------------------------------------
$esteCampo = "mensaje2";
$atributos["id"] = $esteCampo;
$atributos["obligatorio"] = false;
$atributos["estilo"] = "jqueryui";
$atributos["etiqueta"] = "simple";
$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->campoMensaje($atributos);

$tab = 1;

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);


//-----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDatosContacto";
$atributos["estilo"] = "jqueryui";
$atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo="tipoDocNuevo";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["seleccion"]=1;
$atributos["evento"]=2;
$atributos["limitar"]=false;
$atributos["tamanno"]=1;
//usseless: El estilo en las listas desplegables se maneja registrando el widget menu en jquery
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["ancho"]="60%";
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"]=$this->sql->cadena_sql("buscarTipoDocumento");
$atributos["baseDatos"]="votocenso";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);


//-------------Control cuadroTexto-------------------------------------
$esteCampo = "numeroDocNuevo";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "10";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "2"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, custom[integer], number, minSize[4], maxSize[10]";
$atributos["categoria"] = "";
$atributos["deshabilitado"] = true;
$atributos["valor"] = $_REQUEST['idUsuario'];
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "nombre";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "50";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, OnlyLetterSp, minSize[5], maxSize[50]";
$atributos["categoria"] = "";
$atributos["deshabilitado"] = false;
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "correoPrincipal";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "40";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, custom[email], maxSize[40]";
$atributos["categoria"] = "";
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "correoInstitucional";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "40";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "custom[email], maxSize[40]";
$atributos["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "telefonoFijo";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "7";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "2"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "custom[integer], number, minSize[7], maxSize[7]";
$atributos["valor"] = "";
$atributos["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "telefonoCelular";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = false;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["tamanno"] = "10";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "2"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "custom[integer], number, minSize[10], maxSize[10]";
$atributos["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "direccion";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = false;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["tamanno"] = "40";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "minSize[10], maxSize[40]";
$atributos["categoria"] = "";
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Fin de Conjunto de Controles----------------------------
echo $this->miFormulario->marcoAGrupacion("fin");


//-----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoEgresados";
$atributos["estilo"] = "jqueryui";
$atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "codigo";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["etiquetaObligatorio"] = false;
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "11";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "custom[integer], number, minSize[5], maxSize[11]";
$atributos["categoria"] = "";
$atributos["deshabilitado"] = false;
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo="facultad";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["seleccion"]=1;
$atributos["evento"]=2;
$atributos["limitar"]=false;
$atributos["tamanno"]=1;
//usseless: El estilo en las listas desplegables se maneja registrando el widget menu en jquery
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["ancho"]="60%";
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"]=$this->sql->cadena_sql("buscarFacultadesPostgres");
$atributos["baseDatos"]="votocenso";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo="carrera";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["seleccion"]=1;
$atributos["evento"]=2;
$atributos["limitar"]=false;
$atributos["tamanno"]=1;
//usseless: El estilo en las listas desplegables se maneja registrando el widget menu en jquery
$atributos["estilo"]="jqueryui";
$atributos["columnas"]="2";
$atributos["ancho"]="60%";
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"]=$this->sql->cadena_sql("buscarCarrerasPostgres");
$atributos["baseDatos"]="votocenso";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "anoGraduado";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["etiquetaObligatorio"] = false;
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = false;
$atributos["tamanno"] = "4";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "2"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "custom[integer], number, minSize[4], maxSize[4]";
$atributos["categoria"] = "";
$atributos["deshabilitado"] = false;
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "periodoGraduado";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = false;
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = false;
$atributos["tamanno"] = "1";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "2"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = " min[1],max[3], custom[integer], number, minSize[1], maxSize[1]";
$atributos["categoria"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "acta";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["etiquetaObligatorio"] = false;
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = false;
$atributos["tamanno"] = "6";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "2"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "minSize[3], maxSize[6]";
$atributos["categoria"] = "";
$atributos["deshabilitado"] = false;
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-------------------------------------
$esteCampo = "folio";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
$atributos["etiquetaObligatorio"] = false;
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = false;
$atributos["tamanno"] = "6";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "2"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "minSize[1], maxSize[6]";
$atributos["categoria"] = "";
$atributos["deshabilitado"] = false;
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Fin de Conjunto de Controles----------------------------
echo $this->miFormulario->marcoAGrupacion("fin");
//----------------------Fin Conjunto de Controles--------------------------------------
//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

//-------------Control Boton-----------------------
$esteCampo = "botonGuardar";
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
//-------------Control Boton-----------------------
$esteCampo = "botonCancelar";
$atributos["verificar"] = "";
$atributos["tipo"] = "boton";
$atributos["id"] = $esteCampo;
$atributos["cancelar"] = "true";
$atributos["tabIndex"] = $tab++;
$atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------
//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

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

//------------------Fin Division para las pestañas-------------------------
echo $this->miFormulario->division("fin");
?>
