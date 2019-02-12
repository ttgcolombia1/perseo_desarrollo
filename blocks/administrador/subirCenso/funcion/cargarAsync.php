<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

    $conexion="estructura";
    $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
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
    $idEleccion = $_REQUEST['idEleccionBD'];
    $nombreEleccion = $_REQUEST['nombreEleccion'.$idEleccion];
    $nombreDestino = $_REQUEST['nombreDestino'];

    $arregloUrl = array($idEleccion, $nombreEleccion,$proceso);
    $nombreArchivo = "archivoEleccion".$idEleccion;
    $archivoProgreso = $rutaArchivos.$nombreDestino.".progress";
    $destino = $rutaArchivos.$nombreDestino;
    $cargo = 0;
    $yaEsta = 0;
    $totalRegistros = 0;

    $handle = fopen($destino, "r");
    while(!feof($handle)){
      $line = fgets($handle);
      $totalRegistros++;
    }

    fclose($handle);
    $pattern = '1234567890aeiouAEIOU#=';
    if (($handle = fopen($destino, "r")) !== FALSE) {

        $numeroRegistro = 2;
        while (($fila = fgetcsv($handle)) !== FALSE) {

            $numeroCampos = count($fila);
            $identificacion = $fila[0];
            $clave =  hash("sha1", hash("md5", (str_pad('X',4,($pattern{mt_rand(0,(strlen($pattern)-1))})).str_pad('Y',4,($pattern{mt_rand(0,(strlen($pattern)-1))}))) ));            
            //$clave = hash("sha1", hash("md5", $identificacion.'='));
            $nombre = $fila[1];
            $estamento = $fila[2];
            $segundaIdentificacion = 0;

            if($numeroCampos > 3){
              if ($fila[3]!='') {
                  $segundaIdentificacion = $fila[3];
              }
            }

            $registro = array($identificacion, $clave, $idEleccion, strtoupper($nombre), $estamento,$segundaIdentificacion);
            $this->cadena_sql = $this->sql->cadena_sql("validarDatoCenso", $registro);
            $resultadoCensoValida = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

            if ($resultadoCensoValida) {
                $yaEsta++;
            } else {
                $this->cadena_sql = $this->sql->cadena_sql("insertarDatoCenso", $registro);
                $resultadoCenso = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
                if ($resultadoCenso) {
                    $cargo++;
                }
            }

            $progreso = fopen($archivoProgreso,"w");
            $porcentaje = ($numeroRegistro/$totalRegistros)*100.0;
            fwrite($progreso,$porcentaje);

            $numeroRegistro++;
            fclose($progreso);
        }
        fclose($handle);
    }

    $resultado = array('cargados' => $cargo,'existentes' => $yaEsta);
    header('Content-Type: application/json');
    echo json_encode($resultado);

}
