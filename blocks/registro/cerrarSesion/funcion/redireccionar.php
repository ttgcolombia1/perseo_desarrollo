<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
        
        unset($_REQUEST);
        
	switch($opcion)
	{

		case "paginaPrincipal":
			$variable="pagina=index";
                        $variable.="&mostrarMensaje=cerrarSesion";
                        $variable.="&jquery=true";
                        
                        $_REQUEST["redireccionar"]=true;                        
                    
			break;


	}

        $enlace=$this->miConfigurador->getVariableConfiguracion("enlace");
	$variable=$this->miConfigurador->fabricaConexiones->crypto->codificar($variable);

	$_REQUEST[$enlace]=$variable;
        
        //Obliga a cargar la página. Si además existe $_REQUEST["redireccionar"] entonces se hace un location.replace
	$_REQUEST["recargar"]=true;

}

?>