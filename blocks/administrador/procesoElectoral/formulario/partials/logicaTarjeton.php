<?php
include_once("core/crypto/Encriptador.class.php");

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];
$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("urlCandidatos");
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$cripto = Encriptador::singleton();
$proceso = $_REQUEST['proceso'];

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);