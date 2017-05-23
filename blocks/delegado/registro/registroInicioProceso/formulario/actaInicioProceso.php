<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("idioma", '');
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    
   
$cadena_sql = $this->sql->cadena_sql("consultarProcesos", '');
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoProcesos)
{	
    $atributos["id"]="accordion2";
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
             * FORMULARIO ACTA
             */
            
            $nombreFormulario = 'formActaInicio';

            $valorCodificado = "action=" . $esteBloque["nombre"];
            $valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
            $valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
            $valorCodificado.='&opcion=generarActa';
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

            $meses = array(" ","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            
            
            $hora=$resultadoProcesos[$i]['horainicio'];
            $dia= $resultadoProcesos[$i]['diainicio'];
            $mes= $meses[$resultadoProcesos[$i]['mesinicio']];
            $anno= $resultadoProcesos[$i]['annoinicio'];

            $fecha = $dia.' de '.$mes.' de '.$anno;
            
            $parametros = array(
                                'nombre'=>$resultadoProcesos[$i]['nombre'],
                                'fecha'=>$fecha,
                                'dia'=>$dia,
                                'mes'=>$mes,
                                'anno'=>$anno,
                                'hora'=>$hora,
                                'tipo'=>'actainicio'
                                );            
            //-------------Control cuadroTexto-----------------------
            $esteCampo='textoActa';
            $atributos["id"]=$esteCampo;
            $atributos["etiqueta"]="Obesvaciones del acta de inicio";
            $atributos["estilo"]="jqueryui";
            $atributos["tabIndex"]=$tab++;
            $atributos["obligatorio"]=true;
            $atributos['columnas']='90';
            $atributos['filas']='25';
            //$atributos['valor']=$this->lenguaje->getCadena("textoActaInicio");
            echo $this->miFormulario->campoTextArea($atributos);
            unset($atributos);
            
            //echo "Información del acta de inicio";

            //------------------Division para los botones-------------------------
            $atributos["id"]="botones";
            $atributos["estilo"]="marcoBotones";
            echo $this->miFormulario->division("inicio",$atributos);

            //-------------Control Boton-----------------------
            $esteCampo="botonGenerarActa";
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
