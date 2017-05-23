<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}	


$ruta=$this->miConfigurador->getVariableConfiguracion('raizDocumento');

include_once($ruta.'/core/crypto/EncriptadorSSL.php');

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$generador=new EncriptadorSSL();
//$ruta='/usr/local/apache/llaves/';
$ruta=$this->miConfigurador->getVariableConfiguracion('rutaLlaves');

//$ruta=$this->miConfigurador->getVariableConfiguracion('public_key');
//1. Crear las Llaves

$llave = $generador->generarLlaves();

//2. Exportarlas a un archivo

if($generador->guardarLlave($ruta,$_REQUEST['fraseSeguridad'.$_REQUEST['procesoElectoral']],$_REQUEST['procesoElectoral'])){
	///3.Obtener la llave pública	
        $resultadoGuardar=$generador->guardarLlavePublica($ruta,$_REQUEST['procesoElectoral']);
        
	if($resultadoGuardar)
        {
            $cadena_sql = $this->sql->cadena_sql("validarLlave", $_REQUEST['procesoElectoral']);
            $resultadoLlave = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
            if(!$resultadoLlave)
                {
                    $cadena_sql = $this->sql->cadena_sql("guardarLlavePublica", $_REQUEST['procesoElectoral']);
                    $resultadoGuardar &= $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    

                    $cadena_sql = $this->sql->cadena_sql("guardarLlavePrivada", $_REQUEST['procesoElectoral']);
                    $resultadoGuardar &= $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");   
                   
                }
        }
        
        if($resultadoGuardar==true){
            $this->funcion->redireccionar('indexDelegadoExitoPaso1',$_REQUEST['fraseSeguridad'.$_REQUEST['procesoElectoral']]);
	}else{	
		$this->funcion->redireccionar('indexDelegadoErrorPaso');
	}
                
                
	
}else{
	
	$this->funcion->redireccionar('indexDelegadoErrorPaso');
}
