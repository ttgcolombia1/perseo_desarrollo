<?


if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$miBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
$indice=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."/index.php?";
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$nombreFormulario=$miBloque["nombre"];
$tab=1;

$valorCodificado="&opcion=confirmar";
$valorCodificado.="&bloque=".$miBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$miBloque["grupo"];
$valorCodificado=$this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

/**
 * La conexiòn que se debe utilizar es la principal de SARA
*/
$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);


$cadena_sql=$this->sql->cadena_sql("votaciones",''); 
$resultadoVotaciones=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

$abiertas=0;

if($resultadoVotaciones)
{
	for($i=0;$i<count($resultadoVotaciones);$i++)
	{
		$cadena_sql=$this->sql->cadena_sql("calendario",$resultadoVotaciones[$i][0]);
		$resultadoCalendario=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
		
		if($resultadoCalendario)
		{
                    //---------------Inicio Formulario (<form>)--------------------------------
                    $atributos["id"]=$nombreFormulario;
                    $atributos["tipoFormulario"]="multipart/form-data";
                    $atributos["metodo"]="POST";
                    $atributos["nombreFormulario"]=$nombreFormulario;
                    $verificarFormulario="1";
                    echo $this->miFormulario->formulario("inicio",$atributos);
                    
                    $atributos["id"]="divNoEncontroEgresado";
                    $atributos["estilo"]="marcoBotones";
                    echo $this->miFormulario->division("inicio",$atributos);

                    $valorCodificado="&opcion=confirmar"; 
                    $valorCodificado.="&proceso=".$resultadoVotaciones[$i][0]; 
                    $valorCodificado.="&nombreProceso=".$resultadoVotaciones[$i][3]; 
                    $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
                    $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
                    $valorCodificado=$this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

                    $mensaje = $resultadoVotaciones[$i][1];
                    $boton = "continuar";
                    
                    $esteCampo = $resultadoVotaciones[$i][3];
                    $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
                    $atributos["etiqueta"] = "Proceso Electoral: ";
                    $atributos["estilo"] = "jqueryui";
                    $atributos["linea"] = true;
                    $atributos["tipo"] = 'success';
                    $atributos["mensaje"] = $mensaje;
                    echo $this->miFormulario->cuadroMensaje($atributos);
                    unset($atributos); 

                    

                    
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
                    $atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                    $atributos["valor"]="Ver Resultados";
                    $atributos["nombreFormulario"]=$nombreFormulario;
                    echo $this->miFormulario->campoBoton($atributos);
                    unset($atributos);
                    //-------------Fin Control Boton----------------------


                    //------------------Fin Division para los botones-------------------------
                    echo $this->miFormulario->division("fin");

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
					
	}
	
}
?>