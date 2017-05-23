<?php
include_once("core/crypto/Encriptador.class.php");

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

  $proceso = $_REQUEST['proceso'];
  $idEleccion = $_REQUEST['idEleccionBD'];
  $nombreEleccion = $_REQUEST['nombreEleccion'.$idEleccion];
  $nombreDestino = $_REQUEST['nombreDestino'];
  $arregloUrl = array($proceso,$idEleccion,$nombreEleccion,$nombreDestino);

  $this->funcion->redireccionar('progresoArchivo', $arregloUrl);
}

