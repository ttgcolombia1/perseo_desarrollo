<?php
include_once("core/manager/Configurador.class.php");

class FronteraSubirCenso{

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

		if(isset($_REQUEST['opcion'])){

			$accion=$_REQUEST['opcion'];

			switch($accion){
				case "consultarProcesosActivos":
					include_once($this->ruta."/formulario/consultarProcesosActivos.php");
					break;
				case "nuevo":
					include_once($this->ruta."formulario/nuevo.php");
					break;
                                case "nuevoVotante":
                                    include_once($this->ruta."formulario/nuevoVotante.php");
                                    break;
				case "mensaje":
					include_once($this->ruta."formulario/mensaje.php");
					break;
				case "elecciones":
					include_once($this->ruta."formulario/elecciones.php");
					break;
				case "cargarArchivo":
					include_once($this->ruta."formulario/cargarArchivo.php");
					break;
				case "consulta":
					include_once($this->ruta."formulario/consulta.php");
					break;
				case "progresoArchivo":
					include_once($this->ruta."formulario/progresoArchivo.php");
					break;
                                case "consultarCenso":
                                    include_once($this->ruta."formulario/consulta.php");
                                    break;
                                case "detalleVotante":
                                    include_once($this->ruta."formulario/detalleVotante.php");
                                    break;
				case "cargarClaves":
					include_once($this->ruta."formulario/progresoClaves.php");
					break;   

			}
		}else{
			include_once($this->ruta."/formulario/consultarProcesosActivos.php");
		}


	}
}

