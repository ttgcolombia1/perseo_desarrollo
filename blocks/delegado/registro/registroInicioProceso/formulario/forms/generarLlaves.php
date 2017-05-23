<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
echo $cadena_sql = $this->sql->cadena_sql("buscarLlaves");
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
        }		
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$nombreFormulario = 'formLlaves';

$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado.='&opcion=paso1';
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
$esteCampo='fraseSeguridad';
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]=30;
$atributos["columnas"] = 1;
$atributos['anchoEtiqueta']=250;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"]='password';
$atributos["estilo"]="jqueryui";
$atributos["validar"]="required,minSize[6]"; 
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo='fraseSeguridadConfirmar'; 
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]=$this->lenguaje->getCadena($esteCampo);
$atributos["titulo"]=$this->lenguaje->getCadena($esteCampo."Titulo");
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos["tamanno"]=30;
$atributos["columnas"] = 1;
$atributos['anchoEtiqueta']=250;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"]='password';
$atributos["estilo"]="jqueryui ";
$atributos["validar"]="required,minSize[6],equals[fraseSeguridad]"; 
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$cadena_sql = $this->sql->cadena_sql("buscarVotos");
$resultadoVotos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoVotos){
    
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