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
  $valorCodificado.="&opcion=clavesAsync";
  $valorCodificado.="&bloque=".$esteBloque["id_bloque"];
  $valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
  $valorCodificado.="&proceso=".$_REQUEST['proceso'];
  $nombreDestino="contrasenna".$_REQUEST['proceso'];
  $valorCodificado.="&nombreDestino=".$nombreDestino;
  
  $directorio = $this->miConfigurador->getVariableConfiguracion("host");
  $directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
  $directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");

  $valor="pagina=".$esteBloque["nombre"];
  $valor.="&action=subirCenso";
  $valor.="&opcion=progreso";
  $valor.="&bloque=".$esteBloque["id_bloque"];
  $valor.="&bloqueGrupo=".$esteBloque["grupo"];
  $valor.="&proceso=".$_REQUEST['proceso'];
  $valor.="&nombreDestino=".$nombreDestino;
  
  $claves = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valorCodificado, $directorio);
  $claves_progreso = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($valor, $directorio);

  $cripto=Encriptador::singleton();
  $miSesion = Sesion::singleton();

  $url_regreso="pagina=subirCenso";
  $url_regreso.= "&usuario=".$miSesion->getSesionUsuarioId();
  $enlace_regreso = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($url_regreso, $directorio);

?>

<p> Se estan cargando las contraseñas del censo, por favor espere mientras se cargan todos los datos! </p>
<div id="progressbar">
  <div class="progress-label">Cargando...</div>
</div>
<input type="hidden" name="claveasync" value="<?php echo $claves ?>">
<input type="hidden" name="progreso_endpoint" value="<?php echo $claves_progreso ?>">

<div id="resultado_clave">
  <p> Se actualizarón <span id="totalRegistros"></span> claves de usuario.</p>
  <div id="Censo">
    <p> De un total de <span id="totalCenso"></span> registros del censo.</p>
  </div>
  <a href="<?php echo $enlace_regreso ?>">Regresar</a>
</div>
