<?php

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

if(!isset($datosUsuario))
    {
        $datosUsuario[0]['NOMBRE'] = "USUARIO";
        $datosUsuario[0]['APELLIDO'] = "INVITADO";
    }
$datosUsuario[0]['imagen'] = "sabio";

$nombreFormulario='ActualizarDatos';

$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$nombreAplicativo = $this->miConfigurador->getVariableConfiguracion("nombreAplicativo");

$rutaImagen = $rutaBloque . "/imagenesTemp/" . trim($datosUsuario[0]['imagen']) . ".jpg";

$imagenok = $rutaBloque . "/imagenesTemp/bullet_green.png";

$atributos["id"] = "divPrincipal";
$atributos["estilo"] = "divPrincipal";
echo $this->miFormulario->division("inicio", $atributos);

$atributos["id"] = "divContenedor";
$atributos["estilo"] = "divContenedor";
echo $this->miFormulario->division("inicio", $atributos);

$atributos["id"] = "textoSistema";
$atributos["estilo"] = "textoSistema";
echo $this->miFormulario->division("inicio", $atributos);

echo $nombreAplicativo;
//------------------Fin Division-------------------------
echo $this->miFormulario->division("fin");

$atributos["id"] = "textoNombre";
$atributos["estilo"] = "textoNombre";
echo $this->miFormulario->division("inicio", $atributos);
echo "Usuario: ".$datosUsuario[0]['NOMBRE'] . " " . $datosUsuario[0]['APELLIDO'];
echo $this->miFormulario->division("fin");
?>

<?php

$tablasVoto = array();
$tablasVoto['estado'] = "ok";
$tablasVoto['resumen'] = "Operacional";
$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$consulta='';
$cadena_sql = $this->sql->cadena_sql("voto", $consulta);
$resultadoVoto = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$registrosVoto = $resultadoVoto[0]['conteo'];
if(intval($registrosVoto) > 0){
    $tablasVoto['resumen'] = "Proceso de votacion en curso";
}else{
    $tablasVoto['resumen'] = "Las tablas no contienen registros";
}



$tablasProceso = array();
$tablasProceso['estado'] = "ok";
$tablasProceso['resumen'] = "Operacional";

$cadena_sql = $this->sql->cadena_sql("proceso", $consulta);
$resultadoProceso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$registrosProceso = $resultadoProceso[0]['conteo'];
if(intval($registrosProceso) > 0){
    $tablasProceso['resumen'] = "Procesos electorales credos";
}else{
    $tablasProceso['resumen'] = "Las tablas no contienen registros";
}


$tablasCenso = array();
$tablasCenso['estado'] = "ok";
$tablasCenso['resumen'] = "Operacional";

?>
<div id="clockDiv"></div>


<?php




echo $this->miFormulario->division("fin");
echo $this->miFormulario->division("fin");

?>
<input type="hidden" id="horaServidor" name="horaServidor" value="<?php echo date('d M Y G:i:s');?>">
