<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
    
    
        
	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");

        switch($opcion){

		case "yaVoto":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensajes";
			$variable.="&mensaje=".$datos["mensaje"];
			$variable.="&error=".$datos["error"];
			break;
                    
		case "mostrarMensaje":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensajes";
                        $variable.="&usuario=".$datos["id_usuario"];
			$variable.="&mensaje=".$datos["mensaje"];
			$variable.="&error=".$datos["error"];
			break;

		case "paginaPrincipal":
			$variable="pagina=index";
			break;
                    
                
                    
                case "paginaVoto":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=vertarjeton";
			$variable.="&segundaClave=ok";
                        $variable.="&usuario=".$datos["id_usuario"];
			$variable.="&eleccion=".$datos["eleccion"];
			break;    
	}

	foreach($_REQUEST as $clave=>$valor){
		unset($_REQUEST[$clave]);

	}
        
        

	$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
	$variable=$this->miConfigurador->fabricaConexiones->crypto->codificar($variable);

	$_REQUEST[$enlace]=$variable;
	$_REQUEST["recargar"]=true;        

}

?>