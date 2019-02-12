<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

    $conexion="estructura";
    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    
    $conexionClave="clave_academica";
    $clavesDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexionClave);
    
    $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
    $rutaDocumento = $this->miConfigurador->getVariableConfiguracion("raizDocumento");
    $rutaDocumentoTemp = $this->miConfigurador->getVariableConfiguracion("raizDocumentoTemp");
    $rutaBloque = $rutaDocumento."/blocks/".$esteBloque['grupo']."/".$esteBloque['nombre'];
    $rutaUrlBloque = $this->miConfigurador->getVariableConfiguracion("host");
    $rutaUrlBloque.=$this->miConfigurador->getVariableConfiguracion("site");
    $rutaUrlBloque.= "/blocks/".$esteBloque['grupo']."/".$esteBloque['nombre'];
    $rutaArchivos = $rutaDocumentoTemp."/archivos/";
    $rutaUrlArchivos = $rutaUrlBloque."/archivos/";

    $proceso = $_REQUEST['proceso'];
    $nombreDestino = $_REQUEST['nombreDestino'];
    $archivoProgreso = $rutaArchivos.$nombreDestino.".progress";
    $cargo = 0;
    $yaEsta = 0;
    $totalRegistros = 0;

    $parametro[0]=$proceso;
    $parametro[1]="'Presencial'";
    $cadena_sql = $this->sql->cadena_sql("consultaCensoProceso", $parametro);
    $resultadoCenso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
    
    if($resultadoCenso)
        {   $totalRegistros = count($resultadoCenso);
            foreach ($resultadoCenso as $key => $value) {
                $parametro[0]=$resultadoCenso[$key]['identificacion'];
                $cadena_sql = $this->sql->cadena_sql("consultaClaveAcademica", $parametro);
                $resultadoClave = $clavesDB->ejecutarAcceso($cadena_sql, "busqueda");
                 if($resultadoClave)
                    {$parametro[1]=$resultadoClave[0][1];
                     $parametro[2]=$resultadoCenso[$key]['ideleccion'];
                    $cadena_sql = $this->sql->cadena_sql("actualizaClave", $parametro);
                    $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
                    if ($resultado) { $cargo++; }
                    }
            //escribe en archivo el porcentaje    
            $progreso = fopen($archivoProgreso,"w");
            $porcentaje = (($key+1)/$totalRegistros)*100.0;
            fwrite($progreso,$porcentaje);
            fclose($progreso);  
                
            }
        
        }
           
    $resultado = array('cargados' => $cargo,'total' => $totalRegistros);
    header('Content-Type: application/json');
    echo json_encode($resultado);

}
