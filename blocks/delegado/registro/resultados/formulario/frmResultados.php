<?php


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
$conexion="voto";
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
			$estado='<span style="color:green">ABIERTA</span>';
			$abiertas++;
		}else
		{
			$estado='<span style="color:red">CERRADA</span>';
		}
		
		//-----------------Inicio de Conjunto de Controles----------------------------------------
		$esteCampo="marcoVotacion";
		$atributos["estilo"]="jqueryui";
		$atributos["leyenda"]=$resultadoVotaciones[$i][1];
		echo $this->miFormulario->marcoAGrupacion("inicio",$atributos);
		unset($atributos);		
		 
		//echo "<div id='mensaje' class='validationVoto shadow'>".$resultadoVotaciones[$i][1]."  -  ".$estado."</div>"; 
						
	}
	
}


if($abiertas == 0)
{
	//---------------Inicio Formulario (<form>)--------------------------------
	$atributos["id"]=$nombreFormulario;
	$atributos["tipoFormulario"]="multipart/form-data";
	$atributos["metodo"]="POST";
	$atributos["nombreFormulario"]=$nombreFormulario;
	$verificarFormulario="1";
	echo $this->miFormulario->formulario("inicio",$atributos);
	
	$tab = 0;
	//------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo="botonVerResultado";
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
	//-------------Control texto-----------------------
	$esteCampo="mensajeVotacionesAbiertas";
	$atributos["tamanno"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["etiqueta"]="";
	$atributos["mensaje"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["columnas"]=""; //El control ocupa 47% del tamaño del formulario
	echo $this->miFormulario->campoMensaje($atributos);
	unset($atributos);
	
	//Fin de Conjunto de Controles
	echo $this->miFormulario->marcoAGrupacion("fin");
}
?>