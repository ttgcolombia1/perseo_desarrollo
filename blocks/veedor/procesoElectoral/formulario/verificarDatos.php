<?

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$valorCodificado="action=".$esteBloque["nombre"];
$valorCodificado.="&opcion=guardarProceso";
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$conexion="voto";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$this->cadena_sql = $this->sql->cadena_sql("consultarEstado", $_REQUEST['documento']);
$resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

if($resultadoEstado)
{
	$tab=1;
	//---------------Inicio Formulario (<form>)--------------------------------
	$atributos["id"]=$nombreFormulario;
	$atributos["tipoFormulario"]="multipart/form-data";
	$atributos["metodo"]="POST";
	$atributos["nombreFormulario"]=$nombreFormulario;
	$verificarFormulario="1";
	echo $this->miFormulario->formulario("inicio",$atributos);
	
	$atributos["id"]="divDatos";
	$atributos["estilo"]="marcoBotones";
        //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
    
    //-------------Control cuadroTexto-----------------------
	$esteCampo="documentoConfirmar";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=false;
	$atributos["deshabilitado"]=true;
	$atributos["tamanno"]="40";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["valor"]=$_REQUEST['documento'];
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
    
    //-------------Control cuadroTexto-----------------------
	$esteCampo="nombreConfirmar";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=false;
	$atributos["deshabilitado"]=true;
	$atributos["tamanno"]="40";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["valor"]=$resultadoEstado[0]['nombre'];
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
	unset($atributos);
	
	//-------------Control cuadroTexto-----------------------
	$esteCampo="correoConfirmar";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="40";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["validar"]="required, custom[email]";
	$atributos["valor"]=$resultadoEstado[0]['correo'];
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
	
	$atributos["id"]="divDatos";
	$atributos["estilo"]="marcoBotones";
        //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control cuadroTexto-----------------------
	$esteCampo="habilitadoConfirmar";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["estilo"]="jqueryui";
	$atributos["opciones"]="S&SI|N&NO";
	$atributos["seleccion"]=$resultadoEstado[0]['habilitado'];;
	$atributos["validar"]="required, custom[radio]";
	$atributos["valor"]=$resultadoEstado[0]['habilitado'];
	echo $this->miFormulario->campoBotonRadial($atributos);
	unset($atributos);
	
	echo $this->miFormulario->division("fin");
	
	echo $this->miFormulario->division("fin");
	
    //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo="botonActivar";
	$atributos["id"]=$esteCampo;
	$atributos["tabIndex"]=$tab++;
	$atributos["tipo"]="boton";
	$atributos["estilo"]="";
	$atributos["verificar"]=""; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
	$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["nombreFormulario"]=$nombreFormulario;
	echo $this->miFormulario->campoBoton($atributos);
	unset($atributos);
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
	
//Fin del Formulario
echo $this->miFormulario->formulario("fin");
}else
{
	$atributos["id"]="divNoEncontroEgresado";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroEgresado";
	$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = 'error';
	$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
	echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos); 
	//-------------Fin Control Boton----------------------
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
}
    

?>