<?php
if (!isset($GLOBALS["autorizado"])){
    include("index.php");
    exit;
}
?>
<?php
  $esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
  $enlace = $this->miConfigurador->getVariableConfiguracion("enlace");
  $nombreFormulario=$esteBloque["nombre"];
  $cripto=Encriptador::singleton();
  $valorCodificado="pagina=".$esteBloque["nombre"];
  $valorCodificado.="&action=subirCenso";
  $valorCodificado.="&opcion=cargarAsync";
  $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
  $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
  $valorCodificado.="&proceso=".$_REQUEST['proceso'];
  $valorCodificado.="&idEleccionBD=".$_REQUEST['idEleccionBD'];
  $valorCodificado.="&nombreEleccion=".$_REQUEST['nombreEleccion'];
  $valorCodificado.="&nombreDestino=".$_REQUEST['nombreDestino'];

  $directorio = $this->miConfigurador->getVariableConfiguracion("host");
  $directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
  $directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");

  $valor="pagina=".$esteBloque["nombre"];
  $valor.="&action=subirCenso";
  $valor.="&opcion=progreso";
  $valor.="&bloque=".$esteBloque["id_bloque"];
  $valor.="&bloqueGrupo=".$esteBloque["grupo"];
  $valor.="&proceso=".$_REQUEST['proceso'];
  $valor.="&idEleccionBD=".$_REQUEST['idEleccionBD'];
  $valor.="&nombreEleccion=".$_REQUEST['nombreEleccion'];
  $valor.="&nombreDestino=".$_REQUEST['nombreDestino'];

  $enlace = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $directorio);
  $enlace_progreso = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valor, $directorio);

  $cripto=Encriptador::singleton();
  $miSesion = Sesion::singleton();

  $url_regreso="pagina=subirCenso";
  $url_regreso.= "&usuario=".$miSesion->getSesionUsuarioId();
  $enlace_regreso = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($url_regreso, $directorio);

?>

<p> Se esta subiendo el censo, por favor espere mientras se cargan todos los datos. </p>
<div id="progressbar">
  <div class="progress-label">Cargando...</div>
</div>
<input type="hidden" name="cargaasync" value="<?php echo $enlace ?>">
<input type="hidden" name="progreso_endpoint" value="<?php echo $enlace_progreso ?>">

<div id="resultado_censo">
  <p> Se cargaron en total <span id="totalRegistros"></span> registros.</p>
  <div id="noCargados">
    <p> En total se encontraron <span id="totalNoCargados"></span> registros previamente existentes en el censo</p>
  </div>
  <a href="<?php echo $enlace_regreso ?>">Regresar</a>
</div>
