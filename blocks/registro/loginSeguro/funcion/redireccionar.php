<?
if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{

	$miPaginaActual=$this->miConfigurador->getVariableConfiguracion("pagina");
	switch($opcion)
	{

		
		case "indexVotante":
			$variable="pagina=indexVotante";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			$variable.="&sesionID=".$valor["sesionID"];
			break;
			
		case "indexVeedor":
			$variable="pagina=indexVeedor";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			$variable.="&sesionID=".$valor["sesionID"];
			break;
			
		case "indexDelegado":
			$variable="pagina=indexDelegado";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			$variable.="&sesionID=".$valor["sesionID"];
			break;
			
		case "indexAdministrador":
			$variable="pagina=indexAdministrador";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			$variable.="&sesionID=".$valor["sesionID"];
			break;	
			
		case "indexSoporte":
			$variable="pagina=indexSoporte";
			$variable.="&redireccionar=true";
			$variable.="&mensaje=bienvenida";
			$variable.="&usuario=".$valor["id_usuario"];
			$variable.="&tiempo=".time();
			$variable.="&sesionID=".$valor["sesionID"];
			break;			

		case "paginaPrincipal":
			$variable="pagina=index";
			if(isset($valor) && $valor!='')
			{
				$variable.="&error=".$valor;
			}
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