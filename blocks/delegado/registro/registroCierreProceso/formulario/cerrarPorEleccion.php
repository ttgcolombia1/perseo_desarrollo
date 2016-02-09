<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

//----------Inicio División Tabs ---------------------
$atributos["id"] = "tabs";
$atributos["estilo"] = "";
$atributos["estiloEnLinea"] = 'overflow:auto';
echo $this->miFormulario->division("inicio", $atributos);
unset($atributos); {

    $items["crearllaves"] = "Frase secreta";
    $atributos["items"] = $items;
    $atributos["estilo"] = "jqueryui";
    $atributos["pestañas"] = "true";
    echo $this->miFormulario->listaNoOrdenada($atributos);
    unset($atributos);

    $nombreFormulario = 'formDecodificarVotos';
    $tab = 1;
    //---------------Inicio Formulario (<form>)--------------------------------
    $atributos["id"] = $nombreFormulario;
    $atributos["tipoFormulario"] = "multipart/form-data";
    $atributos["metodo"] = "POST";
    $atributos["nombreFormulario"] = $nombreFormulario;
    $verificarFormulario = "1";
    echo $this->miFormulario->formulario("inicio", $atributos);

    $atributos['estilo'] = 'jqueryui';
    $atributos['mensaje'] = $_REQUEST['nombreEleccion'];
    $atributos ["etiqueta"] = '';
    echo $this->miFormulario->campoMensaje($atributos);


//-------------Control cuadroTexto-----------------------
    $esteCampo = 'fraseSecreta';
    $atributos["id"] = $esteCampo;
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["titulo"] = $this->lenguaje->getCadena($esteCampo . "Titulo");
    $atributos["tabIndex"] = $tab++;
    $atributos["obligatorio"] = true;
    $atributos["tamanno"] = "30";
    $atributos["tipo"] = 'password';
    $atributos["estilo"] = "jqueryui";
    $atributos["estiloEnLinea"] = 'height:25px';
    $atributos["validar"] = "required,minSize[6]"; //Las validaciones van separadas por comas
    $atributos['columnas'] = '2';
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);

    //Para pasar variables entre formularios o enviar datos para validar sesiones
    $esteCampo = "eleccion"; //No cambiar este nombre
    $atributos["id"] = $esteCampo;
    $atributos["tipo"] = "hidden";
    $atributos["obligatorio"] = false;
    $atributos["etiqueta"] = "";
    $atributos["valor"] = $_REQUEST['eleccion'];
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);


    $esteCampo = "nombreEleccion";
    $atributos["id"] = $esteCampo;
    $atributos["tipo"] = "hidden";
    $atributos["obligatorio"] = false;
    $atributos["etiqueta"] = "";
    $atributos["valor"] = $_REQUEST['nombreEleccion'];
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);

    //------------------Division para los botones-------------------------
    $atributos["id"] = "botones";
    $atributos["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);
    {

        //-------------Control Boton-----------------------
        $esteCampo = "botonDecodificarVotacion";
        $atributos["id"] = $esteCampo;
        $atributos["tabIndex"] = $tab++;
        $atributos["tipo"] = "boton";
        $atributos["estilo"] = "jqueryui";
        $atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
        $atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
        $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
        $atributos["nombreFormulario"] = $nombreFormulario;
        echo $this->miFormulario->campoBoton($atributos);
        unset($atributos);
        //-------------Fin Control Boton----------------------
        //------------------Fin Division para los botones-------------------------
    }
    echo $this->miFormulario->division("fin");
    //Fin del Formulario
    echo $this->miFormulario->formulario("fin");
}

//------------------Division-------------------------
$atributos["id"] = "divDecodificarVoto";
$atributos['estiloEnLinea'] = 'margin: 0 auto;width:50%;clear:both';
echo $this->miFormulario->division("inicio", $atributos);

//------------------Fin Division-------------------------
echo $this->miFormulario->division("fin");



//-----------------Fin Division para los tabs-------------------------
echo $this->miFormulario->division("fin");




