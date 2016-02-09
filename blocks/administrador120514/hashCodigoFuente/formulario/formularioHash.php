<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

$directorioEnlace = $this->miConfigurador->getVariableConfiguracion("host");
$directorioEnlace.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioEnlace.=$this->miConfigurador->getVariableConfiguracion("enlace");

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
//$valorCodificado="action=".$esteBloque["nombre"]; 
$valorCodificado="&opcion=validarHash"; 
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$miSesion = Sesion::singleton();
$nombreFormulario="Validar Código Fuente";

    
        $tab=1;
        //---------------Inicio Formulario (<form>)--------------------------------
        $atributos["id"]=$nombreFormulario;
        $atributos["tipoFormulario"]="multipart/form-data";
        $atributos["metodo"]="POST";
        $atributos["nombreFormulario"]=$nombreFormulario;
        $atributos["titulo"]=$nombreFormulario;
        echo $this->miFormulario->formulario("inicio",$atributos); 
        unset($atributos);
        
        $atributos["id"]="grupoLlave";
        $atributos["estilo"]="jqueryui";
        $atributos["leyenda"]="Validación del código fuente"; 
        echo $this->miFormulario->marcoAgrupacion("inicio",$atributos);
        
        $atributos["id"]="divSubirCensoEleccion";
        $atributos["estilo"]="marcoBotones";
        //$atributos["estiloEnLinea"]="display:none"; 
        echo $this->miFormulario->division("inicio",$atributos);
        
                
                $esteCampo="llavehash";
                $atributos["id"]=$esteCampo;
                $atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
                $atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
                $atributos["tabIndex"]=$tab++;
                $atributos["obligatorio"]=true;
                $atributos["tamanno"]="50";
                $atributos["ancho"] = 350;
                $atributos["etiquetaObligatorio"] = true;
                $atributos["tipo"]="";
                $atributos["estilo"]="jqueryui";
                $atributos["anchoEtiqueta"] = 250;
                //$atributos["validar"]="minSize[32] required";
                //$atributos["validar"]="minSize[32] required";
                $atributos["categoria"]="";
                echo $this->miFormulario->campoCuadroTexto($atributos);
                unset($atributos);
            
        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
        
        
        //------------------Division para los botones-------------------------
        $atributos["id"]="botones";
        $atributos["estilo"]="marcoBotones";
        echo $this->miFormulario->division("inicio",$atributos);
        
                //-------------Control Boton-----------------------
                $esteCampo="enviar";
                $atributos["id"]=$esteCampo;
                $atributos["tabIndex"]=$tab++;
                $atributos["tipo"]="boton";
                $atributos["estilo"]="jqueryui";
                $atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
                $atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                $atributos["valor"]="Validar Código Fuente";
                $atributos["nombreFormulario"]=$nombreFormulario;
                echo $this->miFormulario->campoBoton($atributos);
                unset($atributos);
          
        //-------------Fin Control Boton----------------------

        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
               
        echo $this->miFormulario->marcoAgrupacion("fin");
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
