<?php

if(!isset($GLOBALS["autorizado"])) {
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

$tab=1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

$conexion="voto";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$atributos["id"]="divDatos";
$atributos["estilo"]="marcoBotones";
//$atributos["estiloEnLinea"]="display:none"; 
echo $this->miFormulario->division("inicio",$atributos);
    
    //-------------Control cuadroTexto-----------------------
	$esteCampo="nombreProceso";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
    /*    
    //-------------Control cuadroTexto-----------------------
	$esteCampo="descripcion";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);     
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="fechaInicio";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="fecha";
	echo $this->miFormulario->campoFecha($atributos);
	unset($atributos); 
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="fechaFin";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="fecha";
	echo $this->miFormulario->campoFecha($atributos);
	unset($atributos);  
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="tipoacto";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);  
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="numeacto";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);  
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="fechaacto";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos); 
        
        //-------------Control cuadroTexto-----------------------
	$esteCampo="cantelecciones";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos); 
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="dependencias";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);     

    //-------------Control cuadroTexto-----------------------
	$esteCampo="tipovotacion";
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]="15";
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["columnas"]="1"; //El control ocupa 32% del tamaño del formulario
	$atributos["validar"]="required";
	$atributos["categoria"]="";
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);     
        */
        //------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
        
    //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo="botonAceptar";
	$atributos["id"]=$esteCampo;
	$atributos["tabIndex"]=$tab++;
	$atributos["tipo"]="boton";
	$atributos["estilo"]="";
	$atributos["verificar"]=""; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
	$atributos["tipoSubmit"]=""; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
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


?>
