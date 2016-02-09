<?php

if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}
    $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
    
    $nombreFormulario=$esteBloque["nombre"];

    include_once("core/crypto/Encriptador.class.php");
    $cripto=Encriptador::singleton();
    $valorCodificado="&bloque=".$esteBloque["id_bloque"];
    $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
    $valorCodificado=$cripto->codificar($valorCodificado);
    $directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";
    
    $rutaHash = $this->miConfigurador->getVariableConfiguracion("raizDocumento");

    $tab=1;
    //Rescatar los valores temporales
    
    $rutaDocumento = $this->miConfigurador->getVariableConfiguracion("raizDocumento");
    
    $rutaDocumentoTemp = $this->miConfigurador->getVariableConfiguracion("raizDocumentoTemp");
              
    $rutaBloque = $rutaDocumento."/blocks/".$esteBloque['grupo']."/".$esteBloque['nombre']; 

    $rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion("host");
    $rutaUrlBloque.=$this->miConfigurador->getVariableConfiguracion("site");
    $rutaUrlBloque.= "/blocks/".$esteBloque['grupo']."/".$esteBloque['nombre'];
    
    $hashFinal = hash_file("sha1", $rutaHash);
     
    if($_REQUEST['llavehash'] === $hashFinal)
        {
            //---------------Inicio Formulario (<form>)--------------------------------
            $atributos["id"]=$nombreFormulario;
            $atributos["tipoFormulario"]="multipart/form-data";
            $atributos["metodo"]="POST";
            $atributos["nombreFormulario"]=$nombreFormulario;
            $verificarFormulario="1";
            echo $this->miFormulario->formulario("inicio",$atributos);

            $atributos["id"]="divMensaje";
            $atributos["estilo"]="marcoBotones";
            echo $this->miFormulario->division("inicio",$atributos);

            $tipo = 'success';
            $mensaje = "La llave digitada coincide con la llave generada por el sistema.";
            $boton = "continuar";

            $esteCampo = "llaveCoincide";
            $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
            $atributos["etiqueta"] = "";
            $atributos["estilo"] = "centrar";
            $atributos["tipo"] = $tipo;
            $atributos["mensaje"] = $mensaje;
            echo $this->miFormulario->cuadroMensaje($atributos);
            unset($atributos); 

            //------------------Fin Division para los botones-------------------------
            echo $this->miFormulario->division("fin");

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

                //---------------Inicio Formulario (<form>)--------------------------------
                $atributos["id"]=$nombreFormulario;
                $atributos["tipoFormulario"]="multipart/form-data";
                $atributos["metodo"]="POST";
                $atributos["nombreFormulario"]=$nombreFormulario;
                $verificarFormulario="1";
                echo $this->miFormulario->formulario("inicio",$atributos);

                $atributos["id"]="divMensaje";
                $atributos["estilo"]="marcoBotones";
                echo $this->miFormulario->division("inicio",$atributos);

                $tipo = 'warning';
                $mensaje = "La llave digitada no coincide con la llave generada por el sistema.";
                $boton = "continuar";

                $esteCampo = "llaveCoincide";
                $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
                $atributos["etiqueta"] = "";
                $atributos["estilo"] = "centrar";
                $atributos["tipo"] = $tipo;
                $atributos["mensaje"] = $mensaje;
                echo $this->miFormulario->cuadroMensaje($atributos);
                unset($atributos); 

                //------------------Fin Division para los botones-------------------------
                echo $this->miFormulario->division("fin");

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