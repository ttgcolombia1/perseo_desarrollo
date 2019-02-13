<?php
class InspectorHTML{
	
	private static $instance;
	
	
	//Constructor
	function __construct(){
	
	}
	
	
	public static function singleton()
	{
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}
	
	function limpiarPHPHTML($arreglo, $excluir=""){
		
		if($excluir!=""){
			$variables=explode("|",$excluir);
		}else{
			$variables[0]="";
		}
		 $aux=array();
		foreach ($arreglo as $clave => $valor)
		{
			if(!in_array($clave,$variables) && !is_array($valor))
                            {	$arreglo[$clave]= strip_tags($valor); }
                        elseif (is_array($valor)) 
                            {   foreach ($valor as $key => $dato)
                                    {   if(!is_array($dato))
                                            { $aux[$key]= strip_tags($dato); }
                                    }
                                $arreglo[$clave]=$aux;
                            }    
		}		
		
		return $arreglo;
		
	}
	
	
	function limpiarSQL($arreglo, $excluir=""){
	
		if($excluir!=""){
			$variables=explode("|",$excluir);
		}else{
			$variables[0]="";
		}
                 $aux=array();
		foreach ($arreglo as $clave => $valor)
		{
			if(!in_array($clave,$variables)  && !is_array($valor) )
                            {	$arreglo[$clave]= addcslashes($valor, '\'"%-()?&~^/\\');}
                        elseif (is_array($valor)) 
                            {   foreach ($valor as $key => $dato)
                                    {   if(!is_array($dato))
                                            { $aux[$key]= addcslashes($dato, '\'"%-()?&~^/\\'); }
                                    }
                                $arreglo[$clave]=  $aux;
                            } 
		}
	
		return $arreglo;
	
	}
	
	
}