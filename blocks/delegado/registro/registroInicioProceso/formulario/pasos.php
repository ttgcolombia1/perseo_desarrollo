<?php
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
if (!$esteRecursoDB) {
	//Este se considera un error fatal
	exit;
}

        $atributos["id"]="tabs";
        $atributos["estilo"]="";
        echo $this->miFormulario->division("inicio",$atributos);
        unset($atributos);

        $items["crearllaves"]="Generar Llaves de Seguridad";
        $items["actaInicio"]="Generar Acta de Inicio";
        $atributos["items"]=$items;
        $atributos["estilo"]="jqueryui";
        $atributos["pestañas"]="true";
        echo $this->miFormulario->listaNoOrdenada($atributos);
        unset($atributos);
        
        $atributos["id"]="crearllaves";
        $atributos["estilo"]="jqueryui";
        echo $this->miFormulario->division("inicio",$atributos);
        unset($atributos);
        
        //include($this->ruta."formulario/forms/generarLlaves.php"); 
        include($this->ruta."formulario/procesosActivos.php"); 

         //-----------------Fin Division para la pestaña 1-------------------------
        echo $this->miFormulario->division("fin");
        
        $atributos["id"]="actaInicio";
        $atributos["estilo"]="jqueryui";
        echo $this->miFormulario->division("inicio",$atributos);
        unset($atributos);
        
        include($this->ruta."formulario/actaInicioProceso.php"); 

         //-----------------Fin Division para la pestaña 1-------------------------
        echo $this->miFormulario->division("fin");
        
        //-----------------Fin Division para los tabs-------------------------
        echo $this->miFormulario->division("fin");
