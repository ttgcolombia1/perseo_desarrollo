<?php

class Lenguajeresultados{

	private $elIdioma;
	
	private $idioma;
	
	private $miConfigurador;
	
	private $nombreBloque;
	
	function __construct()
	{
	
		$this->miConfigurador=Configurador::singleton();
		
		$esteBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
		$this->nombreBloque=$esteBloque["nombre"];
		
		$this->ruta=$this->miConfigurador->getVariableConfiguracion("rutaBloque");
		
		
		if($this->miConfigurador->getVariableConfiguracion("idioma")){
			$this->elIdioma=$this->miConfigurador->getVariableConfiguracion("idioma");
		}else{
			$this->elIdioma="es_es";
		}
		
	}	
	
	
	public function getCadena($opcion="",$argumentos=""){
	
		include($this->ruta."/locale/".$this->elIdioma."/Mensaje.php");
		$opcion=trim($opcion);
		if(isset($this->idioma[$opcion])){
			return $this->idioma[$opcion];
		}else{
			return $this->idioma["noDefinido"];
		}
		
	}
}

?>