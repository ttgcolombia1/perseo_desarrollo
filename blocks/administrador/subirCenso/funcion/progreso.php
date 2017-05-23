<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

  $rutaDocumentoTemp = $this->miConfigurador->getVariableConfiguracion("raizDocumentoTemp");
  $rutaArchivos = $rutaDocumentoTemp."/archivos/";
  $nombreDestino = $_REQUEST['nombreDestino'];
  $archivoProgreso = $rutaArchivos.$nombreDestino.".progress";
  $progreso = file_get_contents($archivoProgreso);
  $resultado = array("progreso"=>$progreso);
  header('Content-Type: application/json');
  echo json_encode($resultado);

}

