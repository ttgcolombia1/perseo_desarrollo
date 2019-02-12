<?php

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

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("idioma", '');
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    
   
$cadena_sql = $this->sql->cadena_sql("consultarProcesos", '');
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoProcesos)
{	
    //-------------------------------Mensaje-------------------------------------
       $esteCampo = "formatoLlaves";
       $atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
       $atributos["etiqueta"] = "";
       $atributos["estilo"] = "centrar";
       $atributos["tipo"] = "success";
       $atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo);
       echo $this->miFormulario->cuadroMensaje($atributos);
   
    $atributos["id"]="accordion";
    $atributos["estilo"]="marcoBotones";
    echo $this->miFormulario->division("inicio",$atributos);
    
    for($i=0;$i<count($resultadoProcesos);$i++)
        {
            $atributos["id"]=$resultadoProcesos[$i]['idprocesoelectoral'];
            $atributos["estilo"]="group";
            echo $this->miFormulario->division("inicio",$atributos);
            echo "<h3>".$resultadoProcesos[$i]['nombre']."</h3>";
            
            $atributos["id"]="espacio".$i;
            $atributos["estilo"]="marcoGrupo";
            echo $this->miFormulario->division("inicio",$atributos);
            
            /**
             * FORMULARIO PARA GENERAR LAS LLAVES
             */
            $cadena_sql = $this->sql->cadena_sql("buscarLlavesRuta",$resultadoProcesos[$i]['idprocesoelectoral']);
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            if ($resultado) 
                {
                    $cadena_sql = $this->sql->cadena_sql("buscarLlavesArchivo",$resultadoProcesos[$i]['idprocesoelectoral']);
                    $resultadoLlaves = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                    
                    if($resultadoLlaves)
                        {
                            $ubicacionLlavePublica = $resultado[0]['valor'].$resultadoLlaves[0]['nombrellave'];
                            $ubicacionLlavePrivada = $resultado[1]['valor'].$resultadoLlaves[0]['nombrellave'];
                            
                            if(file_exists(substr($ubicacionLlavePublica, strlen('file://'))))
                            {
                                    //-------------------------------Mensaje-------------------------------------
                                    $esteCampo = "existenLlaves";
                                    $atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
                                    $atributos["etiqueta"] = "";
                                    $atributos["estilo"] = "centrar";
                                    $atributos["tipo"] = "error";
                                    $atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo);
                                    echo $this->miFormulario->cuadroMensaje($atributos);
                            }
                        }                    		
                }

            $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

            $nombreFormulario = 'formLlaves'.$resultadoProcesos[$i]['idprocesoelectoral'];

            $valorCodificado = "action=" . $esteBloque["nombre"];
            $valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
            $valorCodificado.='&opcion=paso1';
            $valorCodificado.='&procesoElectoral='.$resultadoProcesos[$i]['idprocesoelectoral'];
            $valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);
            $directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");
            $tab=1;

            //---------------Inicio Formulario (<form>)--------------------------------
            $atributos["id"]=$nombreFormulario;
            $atributos["tipoFormulario"]="multipart/form-data";
            $atributos["metodo"]="POST";
            $atributos["nombreFormulario"]=$nombreFormulario;
            $verificarFormulario="1";
            echo $this->miFormulario->formulario("inicio",$atributos);

            //-------------Control cuadroTexto-----------------------
            $esteCampo='fraseSeguridad'.$resultadoProcesos[$i]['idprocesoelectoral'];
            $atributos["id"]=$esteCampo;
            $atributos["etiqueta"]="Frase de Seguridad:";
            $atributos["titulo"]="Frase de seguridad que se utilizará para exportar la llave a un archivo.";
            $atributos["tabIndex"]=$tab++;
            $atributos["obligatorio"]=true;
            $atributos["tamanno"]=30;
            $atributos["columnas"] = 1;
            $atributos['anchoEtiqueta']=250;
            $atributos["etiquetaObligatorio"] = true;
            $atributos["tipo"]='password';
            $atributos["estilo"]="jqueryui";
            $atributos["validar"]="required,minSize[8],maxSize[16],custom[minNumberChars],custom[minLowerAlphaChars],custom[minUpperAlphaChars]"; 
            //$atributos["validar"].=",custom[minSpecialChars]"; 
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            //-------------Control cuadroTexto-----------------------
            $esteCampo='fraseSeguridadConfirmar'.$resultadoProcesos[$i]['idprocesoelectoral']; 
            $atributos["id"]=$esteCampo;
            $atributos["etiqueta"]="Confirmar frase de Seguridad:";
            $atributos["titulo"]="Frase de seguridad que se utilizará para exportar la llave a un archivo.";
            $atributos["tabIndex"]=$tab++;
            $atributos["obligatorio"]=true;
            $atributos["tamanno"]=30;
            $atributos["columnas"] = 1;
            $atributos['anchoEtiqueta']=250;
            $atributos["etiquetaObligatorio"] = true;
            $atributos["tipo"]='password';
            $atributos["estilo"]="jqueryui ";
            $atributos["validar"]="required,minSize[8],equals[fraseSeguridad".$resultadoProcesos[$i]['idprocesoelectoral']."]"; 
            echo $this->miFormulario->campoCuadroTexto($atributos);
            unset($atributos);

            $cadena_sql = $this->sql->cadena_sql("buscarVotosProceso", $resultadoProcesos[$i]['idprocesoelectoral']);
            $resultadoVotos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            
            if($resultadoVotos && $resultadoVotos[0][0] > 0)
                    {

                            //------------------Division para los botones-------------------------
                            $atributos["id"]="mensaje";
                            $atributos["estilo"]="marcoBotones";
                            echo $this->miFormulario->division("inicio",$atributos);
                            //-------------------------------Mensaje-------------------------------------
                            $esteCampo = "existenVotos";
                            $atributos["id"] = "mensaje"; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
                            $atributos["etiqueta"] = "";
                            $atributos["estilo"] = "centrar";
                            $atributos["tipo"] = "warning";
                            $atributos["mensaje"] =$this->lenguaje->getCadena($esteCampo);
                            echo $this->miFormulario->cuadroMensaje($atributos);

                            //------------------Fin Division para los botones-------------------------
                            echo $this->miFormulario->division("fin");
                    }else
                        {
                            //------------------Division para los botones-------------------------
                            $atributos["id"]="botones";
                            $atributos["estilo"]="marcoBotones";
                            echo $this->miFormulario->division("inicio",$atributos);

                            //-------------Control Boton-----------------------
                            $esteCampo="botonAceptar";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["tipo"]="boton";
                            $atributos["estilo"]="jqueryui";
                            $atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
                            $atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                            $atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
                            $atributos["nombreFormulario"]=$nombreFormulario;
                            echo $this->miFormulario->campoBoton($atributos);
                            unset($atributos);
                            //-------------Fin Control Boton----------------------

                            //------------------Fin Division para los botones-------------------------
                            echo $this->miFormulario->division("fin");
                        }



                        //-------------Control cuadroTexto con campos ocultos-----------------------
                        //Para pasar variables entre formularios o enviar datos para validar sesiones
                        $esteCampo="formSaraData"; //No cambiar este nombre
                        $atributos["id"]=$esteCampo;
                        $atributos["tipo"]="hidden";
                        $atributos["obligatorio"]=false;
                        $atributos["etiqueta"]="";
                        $atributos["valor"]=$valorCodificado;
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        //Fin del Formulario
                        echo $this->miFormulario->formulario("fin");

                                    echo $this->miFormulario->division("fin");
                                    echo $this->miFormulario->division("fin");
                                }

                            echo $this->miFormulario->division("fin");


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
                                $atributos["mensaje"] = "No se encontraron procesos electorales activos";
                                echo $this->miFormulario->cuadroMensaje($atributos);
                            unset($atributos); 
                                //-------------Fin Control Boton----------------------

                                //------------------Fin Division para los botones-------------------------
                                echo $this->miFormulario->division("fin");
                        }
    

?>
