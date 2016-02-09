<?php
if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}else
{

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directoriourl = $this->miConfigurador->getVariableConfiguracion("host");
$directoriourl.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directoriourl.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario=$esteBloque["nombre"];

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$tab=1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

	$atributos["id"]="divNoEncontroEgresado";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	if($_REQUEST['mensaje'] == 'confirma')
	{
            $tipo = 'success';
            $mensaje = "El proceso electoral ".$_REQUEST['proceso']." ha sido creado exitosamente. Presione el botón Continuar para parametrizar cada una de las elecciones.";
            $boton = "continuar";
            
            $valorCodificado="pagina=parametrizarProcesoElectoral";
            $valorCodificado.="&opcion=parametrizar"; 
            $valorCodificado.="&proceso=".$_REQUEST['idproceso'];  
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
                
	}else if($_REQUEST['mensaje'] == 'error')
	{
            $tipo = 'error';
            $mensaje = "El proceso electoral ".$_REQUEST['proceso']." no ha sido creado. Por favor intente mas tarde.";
            $boton = "regresar";
                        
            $valorCodificado="&opcion=nuevo"; 
            $valorCodificado.="&nombreProceso=".$_REQUEST['proceso']; 
            //$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            //$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'actualizo')
	{
            $tipo = 'success';
            $mensaje = "El proceso electoral ".$_REQUEST['proceso']." se ha actualizado exitosamente. Presione el botón Continuar para parametrizar cada una de las elecciones.";
            $boton = "continuar";
                        
            $valorCodificado="pagina=parametrizarProcesoElectoral";
            $valorCodificado.="&opcion=parametrizar"; 
            $valorCodificado.="&proceso=".$_REQUEST['idproceso'];
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'errorActualizo')
	{
            $tipo = 'error';
            $mensaje = "El proceso electoral ".$_REQUEST['proceso']." no se ha actualizado. Por favor intente mas tarde.";
            $boton = "regresar";
                        
            $valorCodificado="&opcion=nuevo"; 
            $valorCodificado.="&nombreProceso=".$_REQUEST['proceso']; 
            //$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
            //$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'inhabilito')
	{
            $tipo = 'success';
            $mensaje = "El proceso electoral se inhabilito con exito.";
            $boton = "continuar";
                        
            $valorCodificado="pagina=procesoElectoral";
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}else if($_REQUEST['mensaje'] == 'noInhabilito')
	{
            $tipo = 'error';
            $mensaje = "El proceso electoral no se pudo inhabilitar. Por favor intente mas tarde.";
            $boton = "regresar";
                        
            $valorCodificado="&opcion=nuevo"; 
            $valorCodificado.="&nombreProceso=".$_REQUEST['proceso']; 
            $valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	}
	
	$esteCampo = $_REQUEST['proceso'];
        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
        $atributos["etiqueta"] = "";
        $atributos["estilo"] = "centrar";
        $atributos["tipo"] = $tipo;
        $atributos["mensaje"] = $mensaje;
        echo $this->miFormulario->cuadroMensaje($atributos);
        unset($atributos); 
        
        //------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
        
        //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = $boton;
	$atributos["id"]=$esteCampo;
	$atributos["tabIndex"]=$tab++;
	$atributos["tipo"]="boton";
	$atributos["estilo"]="jquery";
	$atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos["onclick"]="location.replace('".$valorCodificado."');"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
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
	
	
	
}

?>