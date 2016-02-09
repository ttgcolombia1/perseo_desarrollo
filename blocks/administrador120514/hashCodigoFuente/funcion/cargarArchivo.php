<?php

if(!isset($GLOBALS["autorizado"]))
{
	include("index.php");
	exit;
}else{
        $conexion="estructura";
	$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        
        $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
        
        $rutaDocumento = $this->miConfigurador->getVariableConfiguracion("raizDocumento");
        
        $rutaDocumentoTemp = $this->miConfigurador->getVariableConfiguracion("raizDocumentoTemp");
              
        $rutaBloque = $rutaDocumento."/blocks/".$esteBloque['grupo']."/".$esteBloque['nombre']; 
        
        $rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion("host");
        $rutaUrlBloque.=$this->miConfigurador->getVariableConfiguracion("site");
        $rutaUrlBloque.= "/blocks/".$esteBloque['grupo']."/".$esteBloque['nombre'];
        
        include($rutaDocumento.'/classes/phpExcelReader/Excel/reader.php');
        
        $rutaArchivos = $rutaDocumentoTemp."/archivos/";
        $rutaUrlArchivos = $rutaUrlBloque."/archivos/";
        
        $proceso = $_REQUEST['proceso'];
        $idEleccion = $_REQUEST['idEleccionBD'];
        $nombreEleccion = $_REQUEST['nombreEleccion'.$idEleccion];
        $nombreDestino = $_REQUEST['nombreDestino'];
        
        $arregloUrl = array($idEleccion, $nombreEleccion,$proceso);
        
        $nombreArchivo = "archivoEleccion".$idEleccion;
        
        $destino = $rutaArchivos.$nombreDestino;
        
        $data = new Spreadsheet_Excel_Reader();

        $data->read($destino);

        $totalColumnas = $data->sheets[0]['numCols'];
        $totalFilas = $data->sheets[0]['numRows'];
        $cargo = 0;
        $yaEsta = 0;

        for($i=2;$i<=$totalFilas;$i++)
          {
              $identificacion[$i] = $data->sheets[0]['cells'][$i][1];
              $clave[$i] = '';
              $nombre[$i] = $data->sheets[0]['cells'][$i][2];
              $estamento[$i] = $data->sheets[0]['cells'][$i][3];

              $arreglo[$i] = array($identificacion[$i], $clave[$i], $idEleccion, strtoupper($nombre[$i]), $estamento[$i]);

              $this->cadena_sql = $this->sql->cadena_sql("validarDatoCenso", $arreglo[$i]);
              $resultadoCensoValida = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

              if($resultadoCensoValida)
                {
                    $yaEsta++;
                }else
                    {
                        $this->cadena_sql = $this->sql->cadena_sql("insertarDatoCenso", $arreglo[$i]);
                        $resultadoCenso = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");

                        if($resultadoCenso)
                            {
                                $cargo++;
                            }
                    }


            }
                $arregloUrl[3] = $yaEsta;
                $arregloUrl[4] = $cargo;

                $this->funcion->redireccionar('cargaExitosa',$arregloUrl);
                  
}
?>