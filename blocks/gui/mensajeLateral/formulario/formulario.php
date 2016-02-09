<?php

if(isset($_REQUEST['opcion']) && $_REQUEST['opcion']=='votar' ){
    //---------Division -------------------------
        $atributos["id"]='divMensajeLateral';
        $atributos["estilo"]='';
        //$atributos["estiloEnLinea"]="display:none";
        echo $this->miFormulario->division("inicio",$atributos);

        //-------------Control Boton-----------------------
        $esteCampo = "siaceptaVoto";
        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
        $atributos["etiqueta"] = "";
        $atributos["estilo"] = "centrar";
        $atributos["tipo"] = 'message';
        $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
        echo $this->miFormulario->cuadroMensaje($atributos);
        unset($atributos);
        //-------------Fin Control Boton----------------------

        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
        
}