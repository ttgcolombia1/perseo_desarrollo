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

$directorioIndex = $this->miConfigurador->getVariableConfiguracion("host");
$directorioIndex.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioIndex.=$this->miConfigurador->getVariableConfiguracion("enlace");

$tab=1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

	$atributos["id"]="divGeneroContrasena";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
		
            $tipo = 'success';
            //$mensaje = "La contraseña para el usuario ".$_REQUEST['idUsuario']." ha sido generado exitosamente. <br>Puede visualizar los datos en el PDF de Resumen.";
            $mensaje = "La contraseña para el usuario ".$_REQUEST['idUsuario']." ha sido generado exitosamente. <br>";
            $boton = "continuar";
            

            
            $variableResumen = "pagina=consultarCenso"; //pendiente la pagina para modificar parametro                                                        
            $variableResumen.= "&action=".$esteBloque["nombre"];
            $variableResumen.= "&bloque=" . $esteBloque["id_bloque"];
            $variableResumen.= "&bloqueGrupo=" . $esteBloque["grupo"];
            $variableResumen.= "&opcion=resumen";
            $variableResumen.= "&idUsuario=".$_REQUEST["idUsuario"];
            $variableResumen.= "&contrasena=".$_REQUEST["contrasena"];
            $variableResumen.= "&vidaClave=".$_REQUEST["vidaClave"];
            $variableResumen.= "&timeClave=".$_REQUEST["timeClave"];
            $variableResumen.= "&host=".$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site");
            $variableResumen = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableResumen, $directorioIndex);
	
	
		$esteCampo = 'mensaje';
        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
        $atributos["etiqueta"] = "";
        $atributos["estilo"] = "centrar";
        $atributos["tipo"] = $tipo;
        $atributos["mensaje"] = $mensaje;
        echo $this->miFormulario->cuadroMensaje($atributos);
        unset($atributos); 
        
        //------------------Fin Division para los botones-------------------------
        
        //------------------Division para los botones-------------------------
        $atributos["id"]="botones";
        $atributos["estilo"]="marcoBotones";
        echo $this->miFormulario->division("inicio",$atributos);
        
        //$enlace = "<a href='".$variableResumen."'>";
        $enlace = '<a href="javascript:void(window.open(\''.$variableResumen.'\',\'\',\'width=700,height=450,noresize\'));" rel="nofollow">';
        $enlace.="<img src='".$rutaBloque."/images/acroread.png' width='25px'><br>Abrir Resumen ";
        $enlace.="</a><br><br>";
        //echo $enlace;
        
                
        //echo '<a href="javascript:void(window.open(\''.$variableResumen.'\',\'\',\'width=700,height=450,noresize\'));" rel="nofollow">TEXTO</a>'; 
        /*
        echo '<script language=\'JavaScript\' type=\'text/javascript\'>
        window.open(\''.$variableResumen.'\',\'\',\'width=700,height=450,noresize\');
        self.focus();
        </script>';*/
        
        
        
        
        echo '        		
        <script>
        var window_handle;
        function open_window()
        {
        	window_handle = window.open(\''.$variableResumen.'\',\'\',\'width=700,height=450,noresize\');
        }
        function close_window()
        {
        	window_handle.close();
        }
        </script>
        <script>
        open_window();
        self.focus();
        window.setInterval(" window_handle.close();", 15000, "JavaScript");
        </script>';
        
          
        
        
        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
        
	echo $this->miFormulario->division("fin");
        
        //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	
	$valorCodificado="pagina=consultarCenso";
	$valorCodificado.= "&usuario=" . $miSesion->getSesionUsuarioId();
	$valorCodificado=$cripto->codificar_url($valorCodificado,$directoriourl);
	
	
	$esteCampo = botonVolver;
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