<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
	 
	$miSesion = Sesion::singleton();
	
	$usuarioSoporte = $miSesion->getSesionUsuarioId(); 
	 
	$conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if(isset($_REQUEST['dependencias']) && is_array($_REQUEST['dependencias']))
            {
                $dependencias = $_REQUEST['dependencias'];
        
                if(is_array($dependencias))
                    {
                        $depResponsable = "{";
                        for ($i=0;$i<count($dependencias);$i++)    
                        {
                            if(($i + 1) == count($dependencias))
                                {
                                    $depResponsable .= $dependencias[$i];
                                }else
                                    {
                                        $depResponsable .= $dependencias[$i].",";
                                    }
                        }
                        $depResponsable .= "}";
                    }
            }else
                {
                    $depResponsable = "{}";
                }
        
        
	$arregloDatos = array($_REQUEST['nombreProceso'],
                              $_REQUEST['descripcion'],
                              $_REQUEST['fechaInicio'],
                              $_REQUEST['fechaFin'],
                              $_REQUEST['tipoacto'],
                              $_REQUEST['numeacto'],
                              $_REQUEST['fechaacto'],
                              $_REQUEST['cantelecciones'],
                              $depResponsable,
                              $_REQUEST['tipovotacion']);
	
	$this->cadena_sql = $this->sql->cadena_sql("insertarProceso", $arregloDatos);
	$resultadoEstado = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
	
        if($resultadoEstado)
	{   $this->cadena_sql = $this->sql->cadena_sql("buscaProcesoNombre", $arregloDatos);
	    $resultadoProc = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
            //$idProceso=$esteRecursoDB->ultimo_insertado();
            $idProceso=$resultadoProc[0][0];
            $arregloPasa = array($idProceso,$_REQUEST['nombreProceso']);
            $this->funcion->redireccionar('inserto',$arregloPasa);
	}else
	{
		$this->funcion->redireccionar('noInserto',$_REQUEST['nombreProceso']);
	}



}
?>