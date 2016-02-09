<?php

//Evitar un acceso directo a este archivo
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
}
include_once("core/manager/Configurador.class.php");

class FronteraregistroCierreProceso{

	var $ruta;
	var $sql;
	var $funcion;
	var $lenguaje;
	var $formulario;
	
	var $miConfigurador;
	
	function __construct()
	{
	
		$this->miConfigurador=Configurador::singleton();		
	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
	}

	public function setLenguaje($lenguaje){
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

	function frontera()
	{
		$this->html();
	}

	function setSql($a)
	{
		$this->sql=$a;

	}

	function setFuncion($funcion)
	{
		$this->funcion=$funcion;

	}

	function html()
	{
		
		include_once("core/builder/FormularioHtml.class.php");
		
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
		
		
		$this->miFormulario=new formularioHtml();
                if(isset($_REQUEST['opcion']))
                    {
                    switch ($_REQUEST['opcion']) {
                        case "cerrarPorEleccion":
                                include_once($this->ruta."/formulario/cerrarPorEleccion.php");
                            break;
                        
                        case "verResultadosEleccion":
                                include_once($this->ruta."/formulario/verResultadosEleccion.php");
                            break;
                        
                        case "actaCierre":
                                include_once($this->ruta."/formulario/actaCierre.php");
                            break;

                        default:
                            break;
                    }
                    }else
                        {
                            include_once($this->ruta."/formulario/procesosActivos.php");
                        }
	}





}
?>