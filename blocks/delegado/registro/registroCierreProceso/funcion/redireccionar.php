<?
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( "pagina" );
	switch ($opcion) {
		
		case 'exitoCierre' :
			$variable = 'pagina=cerrarProceso';
			$variable .= '&tiempo=' . time ();
			
			break;
		
		case 'indexDelegadoErrorPaso' :
			$variable = 'pagina=indexDelegado';
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