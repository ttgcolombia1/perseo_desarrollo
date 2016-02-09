<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 * 
 *  La ruta absoluta del bloque está definida en $this->ruta
 */


//-----------------División Contenedor -----------------------------------
$esteCampo='contenedorPaso1';
$atributos["id"]=$esteCampo;
$atributos["estilo"]=$esteCampo;
echo $this->miFormulario->division("inicio",$atributos);
unset($atributos);

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}
$cadena_sql = $this->sql->cadena_sql("buscarProcesoAbierto",5);
$registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

var_dump($registro);
if ($registro) {
	//-------------------------------Mensaje-------------------------------------
	$esteCampo = "procesoAbiertoLlaves";
	$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = "information";
	$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo);
	echo $this->miFormulario->cuadroMensaje($atributos);

}else{

	$cadena_sql = $this->sql->cadena_sql("buscarLlaves");
	$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
	if ($resultado) {
		
		if($resultado[0]['parametro']=='public_key'){
			$ubicacionLlavePublica = $resultado[0]['valor'];
			$ubicacionLlavePrivada = $resultado[1]['valor'];
		}else{
			$ubicacionLlavePrivada = $resultado[0]['valor'];
			$ubicacionLlavePublica = $resultado[1]['valor'];
		}
		 
		if(file_exists(substr($ubicacionLlavePrivada, strlen('file://')))){
			//-------------------------------Mensaje-------------------------------------
			$esteCampo = "existenLlaves";
			$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
			$atributos["etiqueta"] = "";
			$atributos["estilo"] = "centrar";
			$atributos["tipo"] = "error";
			$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo);
			echo $this->miFormulario->cuadroMensaje($atributos);
                }else
                    {
                        include_once 'forms/generarLlaves.php';
                    }		
	}
}




//------------------Fin Division Contenedor-------------------------
echo $this->miFormulario->division("fin");






?>