<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

        switch ($opcion) {
		
		
		case 'exitoApertura' :
			$variable = 'pagina='.$miPaginaActual;
			$variable .= '&tiempo=' . time ();	
			break;
		
		case 'indexDelegadoExitoPaso1' :
			$variable = 'pagina='.$miPaginaActual;
			$variable .= '&opcion=mensaje';			
			$variable .= '&frase='.$valor;			
			$variable .= '&tiempo=' . time ();
			break;
		
		case 'indexDelegadoErrorPaso' :
			$variable = 'pagina='.$miPaginaActual;
			$variable .= '&opcion=error';
			$variable .= '&tiempo=' . time ();
			
			break;
		
		case "paginaPrincipal" :
			$variable = "pagina=index";
			break;
	}
	
	unset ( $_REQUEST  );
	
	$enlace = $this->miConfigurador->getVariableConfiguracion ( "enlace" );
	$variable = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
	
	$_REQUEST [$enlace] = $variable;
	$_REQUEST ["recargar"] = true;
	
}

?>