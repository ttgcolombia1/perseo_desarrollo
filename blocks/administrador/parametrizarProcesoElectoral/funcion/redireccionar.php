<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	switch($opcion)
	{
            
                case "inserto":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=confirma";
			if($valor!=""){
				$variable.="&proceso=".$valor['proceso'];
                                $variable.="&errores=".$valor['errores'];
			}
			break;
                       
                case "insertoSinCandidatos":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=confirmasincandidatos";
			if($valor!=""){
				$variable.="&proceso=".$valor;
			}
			break;
                        
                case "ErrorInsertando":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=error";
			if($valor!=""){
				$variable.="&proceso=".$valor;
			}
			break;
                        
                case "noInserto":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=error";
			if($valor!=""){
				$variable.="&proceso=".$valor;
			}
			break;
            
		case "confirmarNuevo":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=confirmar";
			if($valor!=""){
				$variable.="&id_sesion=".$valor;
			}
			break;

                case "Actualiza":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=confirmaActualiza";
			if($valor!=""){
				$variable.="&proceso=".$valor;
			}
			break;                        
                case "ErrorActualiza":
			$variable="pagina=".$miPaginaActual;
			$variable.="&opcion=mensaje";
			$variable.="&mensaje=errorActualiza";
			if($valor!=""){
				$variable.="&proceso=".$valor;
			}
			break;
                        
                case "paginaPrincipal":
			$variable="pagina=index";
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