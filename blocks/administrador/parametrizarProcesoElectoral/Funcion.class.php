<?php
if(!isset($GLOBALS["autorizado"]))
{
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Mensaje.class.php");
include_once("core/crypto/Encriptador.class.php");

//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion

//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncionParametrizarProcesoElectoral
{

	var $sql;
	var $funcion;
	var $lenguaje;
	var $ruta;
	var $miConfigurador;
	var $miInspectorHTML;
	var $error;
	var $miRecursoDB;
	var $crypto;


	function action()
	{
		//Evitar que se ingrese codigo HTML y PHP en los campos de texto
		//Campos que se quieren excluir de la limpieza de código. Formato: nombreCampo1|nombreCampo2|nombreCampo3
		$excluir="";
		//$_REQUEST=$this->miInspectorHTML->limpiarPHPHTML($_REQUEST);
		
			if(isset($_REQUEST["procesarAjax"]))
			{
				$this->procesarAjax();

			}else if($_REQUEST["opcion"]=="guardarDatos")
			{
				$this->guardarDatos(); 
			}else if($_REQUEST["opcion"]=="editarEleccion")
			{
				$this->editarEleccion(); 
			}else if($_REQUEST["opcion"]=="editarProceso")
			{
				$this->editarProceso(); 
			}else if($_REQUEST["opcion"]=="editarCandidato")
			{
				$this->editarCandidato(); 
			}else if($_REQUEST["opcion"]=="guardarEleccion")
			{
				$this->guardarEleccion(); 
			}else if($_REQUEST["opcion"]=="resumen")
			{
				$this->resumenProceso(); 
			}else if($_REQUEST["opcion"]=="resumenEleccion")
			{
				$this->resumenEleccion();
			}
            else if($_REQUEST["opcion"]=="eliminarCandidato")
            {
                $this->eliminarCandidato();
            }
	}


	function __construct()
	{

		$this->miConfigurador=Configurador::singleton();

		$this->miInspectorHTML=InspectorHTML::singleton();
			
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

		$this->miMensaje=Mensaje::singleton();

		$conexion="aplicativo";
		$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

		if(!$this->miRecursoDB){

			$this->miConfigurador->fabricaConexiones->setRecursoDB($conexion,"tabla");
			$this->miRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
		}


	}

	public function setRuta($unaRuta){
		$this->ruta=$unaRuta;
		//Incluir las funciones
	}
	
	function verificarCampos(){
		include_once($this->ruta."/funcion/verificarCampos.php");
		if($this->error==true){
			return false;
		}else{
			return true;
		}

	}

    function eliminarCandidato()
    {
        include_once($this->ruta."/funcion/eliminarCandidato.php");
    }

    function guardarDatos()
	{
		include_once($this->ruta."/funcion/guardarDatos.php");
	}	
        
	function guardarEleccion()
	{
		include_once($this->ruta."/funcion/guardarEleccion.php");
	}	

	function editarEleccion()
	{
		include_once($this->ruta."/funcion/editarEleccion.php");
	}

	function editarProceso()
	{
		include_once($this->ruta."/funcion/editarProceso.php");
	}        
        
	function resumenProceso()
	{
		include_once($this->ruta."/funcion/resumenProceso.php");
	}

	function editarCandidato()
	{
		include_once($this->ruta."/funcion/editarCandidato.php");
	} 
        
        function resumenEleccion()
	{
		include_once($this->ruta."/funcion/resumenEleccion.php");
	}
        
	function procesarAjax(){
		include_once($this->ruta."/funcion/procesarAjax.php");
	}
	
	function redireccionar($opcion, $valor=""){
		include_once($this->ruta."/funcion/redireccionar.php");
	}
	
	/**
	 * Métodos de acceso
	 * @param unknown $a
	 */

	function setSql($a)
	{
		$this->sql=$a;
	}

	function setFuncion($funcion)
	{
		$this->funcion=$funcion;
	}

	public function setLenguaje($lenguaje)
	{
		$this->lenguaje=$lenguaje;
	}

	public function setFormulario($formulario){
		$this->formulario=$formulario;
	}

}

