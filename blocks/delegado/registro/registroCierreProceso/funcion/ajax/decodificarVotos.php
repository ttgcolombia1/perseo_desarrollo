<?php

//Evitar un acceso directo a este archivo
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
}


if($_REQUEST['fraseSecreta']==''){

	$registro['tipo']='sinFraseSeguridad';
	//-------------------------------Mensaje-------------------------------------
	$esteCampo = "sinFraseSeguridad";
	$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = 'warning';
	$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo,$registro);
	echo $this->miFormulario->cuadroMensaje($atributos);
	exit;
}

$ruta=$this->miConfigurador->getVariableConfiguracion('raizDocumento');
include_once($ruta.'/core/crypto/EncriptadorSSL.php');
$generador=new EncriptadorSSL();
$conexion = "estructura";

$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (!$esteRecursoDB) {
	echo 'No hay acceso a la base de datos';
	exit;
}

$cadena_sql = $this->sql->cadena_sql('buscarLlaves', '');
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, 'busqueda');
if($resultado){
    
        $cadena_sql = $this->sql->cadena_sql('llavePrivadaProceso', $_REQUEST['eleccion']);
        $resultadoLlave = $esteRecursoDB->ejecutarAcceso($cadena_sql, 'busqueda');
	       
        $ubicacionLlavePublica = $resultado[0]['valor'].$resultadoLlave[0][1];
        $ubicacionLlavePrivada = $resultado[1]['valor'].$resultadoLlave[0][1];
        //verifica si la fecha final del proceso es menor a la de la eleccion, para cerrar la eleccion
        $cadena_sqlPro = $this->sql->cadena_sql('datosProceso', $resultadoLlave[0]['proceso']);
        $resultadoPro = $esteRecursoDB->ejecutarAcceso($cadena_sqlPro, 'busqueda');
	if(strtotime($resultadoPro[0]['fechaTermina'])< strtotime($resultadoLlave[0]['fechafin']))
           {  $parametros=array('eleccion'=>$_REQUEST['eleccion'],'fechafin'=>$resultadoPro[0]['fechaTermina']);
              $cadena_sql= $this->sql->cadena_sql('cerrarEleccion', $parametros);
              $registroDecodificado=$esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
           }
        
	$cadena_sql=$this->sql->cadena_sql('contarVotosDecodificados', $_REQUEST['eleccion']);
	$registro=$esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

	if($registro && $registro[0]['total']==0){

		$llavePrivada=$generador->getLlavePrivadaArchivo($ubicacionLlavePrivada,$_REQUEST['fraseSecreta']);

                if ($llavePrivada)
		{
			//Total de votos
			$cadena_sql= $this->sql->cadena_sql('buscarVotos',  $_REQUEST['eleccion']);
			$registro=$esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

                        if($registro){
				
                                $mensajeRegistro['totalVotos'] = $esteRecursoDB->getConteo();
                                
				$contador=0;

                                for($i=0;$i<count($registro);$i++)
                                {
                                    $voto = base64_decode($registro[$i]['voto']);
                                    $eleccion = $generador->decodificarSSLConLlave($voto,$llavePrivada);
                                    
                                    if($eleccion)
                                        {
                                            $votoDefinitivo = $eleccion;
                                            $ip = $registro[$i]['ip'];
                                            $ideleccion =  $registro[$i]['ideleccion'];
                                            $estamento =  $registro[$i]['estamento'];
                                            
                                            $arregloVoto = array($ideleccion, $votoDefinitivo, $ip, $estamento);
                                            
                                            $cadena_sql= $this->sql->cadena_sql('guardarVotoDecodificado', $arregloVoto);
                                            $registroDecodificado=$esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
					
                                            if($registroDecodificado){
							$contador++;
						}else{
							error_log('Unable to save a row: '.$votoDefinitivo);
						}

					}else{
                                            $votoDefinitivo = $eleccion;
                                            error_log('Unable to decode a row: '.$votoDefinitivo);
					}
                                }

				//Datos decodificados

                                $mensajeRegistro['tipo']='datosDecodificados';
				$mensajeRegistro['total']=$contador;
				
				//-------------------------------Mensaje-------------------------------------
				$esteCampo = "datosDecodificados";
				$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
				$atributos["etiqueta"] = "";
				$atributos["estilo"] = "centrar";
				$atributos["tipo"] = 'warning';
				$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo,$mensajeRegistro);
				echo $this->miFormulario->cuadroMensaje($atributos);
                        }else
                            {
                                //Datos decodificados

                                $mensajeRegistro['tipo']='nohayvotos';
				
				//-------------------------------Mensaje-------------------------------------
				$esteCampo = "nohayvotos";
				$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
				$atributos["etiqueta"] = "";
				$atributos["estilo"] = "centrar";
				$atributos["tipo"] = 'warning';
				$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo,$mensajeRegistro);
				echo $this->miFormulario->cuadroMensaje($atributos);
                            }
                            


		}else{

			//Error porque no se pudo extraer la llave privada

			$mensajeRegistro['tipo']='sinLlavePrivada';
			//-------------------------------Mensaje-------------------------------------
			$esteCampo = "sinLlavePrivada";
			$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
			$atributos["etiqueta"] = "";
			$atributos["estilo"] = "centrar";
			$atributos["tipo"] = 'warning';
			$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo,$mensajeRegistro);
			echo $this->miFormulario->cuadroMensaje($atributos);



		}


	}else{
		//Error porque existen votos codificados

		$mensajeRegistro['tipo']='conVotosCodificados';
	 //-------------------------------Mensaje-------------------------------------
		$esteCampo = "conVotosCodificados";
		$atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
		$atributos["etiqueta"] = "";
		$atributos["estilo"] = "centrar";
		$atributos["tipo"] = 'warning';
		$atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo,$mensajeRegistro);
		echo $this->miFormulario->cuadroMensaje($atributos);
	}


}else{



}







?>
