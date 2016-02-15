<?

ini_set('display_errors', 0);

if(!isset($GLOBALS["autorizado"]))
	{
		include("index.php");
		exit;
	}
else{
	        
	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	
	switch($opcion)
		{
	
			case "cambiarClave":
				$variable=$datos;
	                        break;
	                    
			case "mostrarMensaje":
				$variable="pagina=".$miPaginaActual;
				$variable.="&opcion=mostrarMensaje";
				$variable.="&mensaje=".$datos["mensaje"];
				$variable.="&error=".$datos["error"];
				break;
	
			case "paginaPrincipal":
				$variable="pagina=index";
				break;
	                    
	        case "mostrarMensajeNoRegistro":
				$variable="pagina=".$miPaginaActual;
				$variable.="&opcion=mostrarMensajeNoRegistro";
				$variable.="&idUsuario=".$datos;
	     	    break;
	                    
	        case "mostrarMensajeRegistro":
				$variable="pagina=".$miPaginaActual;
				$variable.="&opcion=mostrarMensajeRegistro";
				$variable.="&idUsuario=".$datos;
	        	break;
	        
	        case "actualizoContrasena":
	        	$variable="pagina=".$miPaginaActual;
	        	//$variable.="&opcion=mensaje";
	        	//$variable.="&mensaje=mostrarMensajeContrasena";
	        	$variable.="&opcion=mostrarMensajeContrasena";
	        	$variable.="&idUsuario=".$datos['idUsuario'];
	        	$variable.="&contrasena=".$datos['contrasena'];
	        	$variable.="&vidaClave=".$datos['vidaClave'];
	        	$variable.="&timeClave=".$datos['timeClave'];
	        		
	        	break;
	        
	        case "NoActualizoContrasena":
	           	$variable="pagina=".$miPaginaActual;
	        	$variable.="&opcion=mostrarMensajeNoContrasena";
	        	$variable.="&idUsuario=".$datos;
	        		
	        	break;
	
		}
	
		foreach($_REQUEST as $clave=>$valor)
		{
			unset($_REQUEST[$clave]);
	
		}
	
		$enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
		$variable=$this->miConfigurador->fabricaConexiones->crypto->codificar($variable);
	
		$_REQUEST[$enlace]=$variable;
		$_REQUEST["recargar"]=true;

}

?>
