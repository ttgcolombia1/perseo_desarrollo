<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$rutaCandidatos = $this->miConfigurador->getVariableConfiguracion("host");
$rutaCandidatos .= $this->miConfigurador->getVariableConfiguracion("urlCandidatos");

$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

$directorioEnlace = $this->miConfigurador->getVariableConfiguracion("host");
$directorioEnlace .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioEnlace .= $this->miConfigurador->getVariableConfiguracion("enlace");

include_once("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton();
$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "/imagen/";

$miSesion = Sesion::singleton();
$nombreFormulario = "Eleccion" . $idEleccion;

$arrayEleccion = array($proceso, $idEleccion);

$this->cadena_sql = $this->sql->cadena_sql("consultaEleccion", $arrayEleccion);
$resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

$tab = 1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$atributos["titulo"] = $nombreFormulario;
echo $this->miFormulario->formulario("inicio", $atributos);
unset($atributos);

$this->cadena_sql = $this->sql->cadena_sql("consultaFechaProceso", $arrayEleccion);
$resultadoFechas = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

?>
<input type="hidden" name="fechainiProceso<?php echo $idEleccion ?>" id="fechainiProceso<?php echo $idEleccion ?>"
       value="<?php echo $resultadoFechas[0]['fechainicio'] ?>">
<input type="hidden" name="fechafinProceso<?php echo $idEleccion ?>" id="fechafinProceso<?php echo $idEleccion ?>"
       value="<?php echo $resultadoFechas[0]['fechafin'] ?>">
<?php


//-------------Control cuadroTexto-----------------------
$esteCampo = "fechaInicio" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Fecha de inicio de la elección: ";
$atributos["titulo"] = "Fecha de inicio de la elección ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 25;
$atributos["etiquetaObligatorio"] = true;
$atributos["deshabilitado"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["validar"] = "required";
$atributos["categoria"] = "fecha";
if ($resultadoEleccion) {
    $atributos["valor"] = $resultadoEleccion[0]['fechainicio'];
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "fechaFin" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Fecha de finalización de la elección: ";
$atributos["titulo"] = "Fecha de finalización de la elección ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 25;
$atributos["etiquetaObligatorio"] = true;
$atributos["deshabilitado"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 250;
$atributos["validar"] = "required";
$atributos["categoria"] = "fecha";
if ($resultadoEleccion) {
    $atributos["valor"] = $resultadoEleccion[0]['fechafin'];
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control Boton-----------------------
$esteCampo = "guardar";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["tipo"] = "boton";
$atributos["estilo"] = "jqueryui";
$atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"] = "Ajustar Fechas";
$atributos["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);

//-------------Fin Control Boton----------------------

//------------------Division para los botones-------------------------
$atributos["id"] = "gestionar";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);
unset($atributos);

//-----------------Inicio de Conjunto de Controles----------------------------------------
$esteCampo = "marcoDetalleCandidatos";
$atributos["id"] = $esteCampo;
$atributos["estilo"] = "jqueryui";
$atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
unset($atributos);

if ($resultadoEleccion) {
    $arrayCandidatos = array($proceso, $resultadoEleccion[0]['ideleccion']);
    $this->cadena_sql = $this->sql->cadena_sql("consultaCandidatos", $arrayCandidatos);
    $resultadoCandidatos = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
}
?>
<div id="scroll" class="datagrid" style=" width: 100%">
    <table id="tablaCandidatos<?php echo $idEleccion ?>" width="95%">
        <!-- Cabecera de la tabla -->
        <thead>
        <tr>
            <th>Lista</th>
            <th>Posición Lista</th>
            <th>Renglón</th>
            <th>Identificación</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Foto</th>
            <th>Ajustar</th>
        </tr>
        </thead>

        <!-- Cuerpo de la tabla con los campos -->
        <tbody>

        <?php

        if ($resultadoEleccion) {
            if ($resultadoCandidatos) {
                for ($can = 0; $can < count($resultadoCandidatos); $can++) {
                    ?>

                    <tr>
                        <td>
                            <?php echo $resultadoCandidatos[$can][0] ?>
                        </td>
                        <td>
                            <?php echo $resultadoCandidatos[$can][1] ?>
                        </td>
                        <td>
                            <?php echo $resultadoCandidatos[$can][7] ?>
                        </td>
                        <td>
                            <?php echo $resultadoCandidatos[$can][2] ?>
                        </td>
                        <td>
                            <?php echo $resultadoCandidatos[$can][3] ?>
                        </td>
                        <td>
                            <?php echo $resultadoCandidatos[$can][4] ?>
                        </td>
                        <td>
                            <img src='<?php echo $rutaCandidatos . $resultadoCandidatos[$can][5] ?>' width="150px" height="150px">
                        </td>
                        <td>
                            <?php
                            $variableCandidato = "pagina=parametrizarProcesoElectoral"; //pendiente la pagina para modificar parametro
                            //$variableCandidato.= "&action=".$esteBloque["nombre"];
                            $variableCandidato .= "&bloque=" . $esteBloque["id_bloque"];
                            $variableCandidato .= "&bloqueGrupo=" . $esteBloque["grupo"];
                            $variableCandidato .= "&opcion=ajustarCandidato";
                            $variableCandidato .= "&usuario=" . $miSesion->getSesionUsuarioId();
                            $variableCandidato .= "&proceso=" . $proceso;
                            $variableCandidato .= "&ideleccion=" . $resultadoEleccion[0]['ideleccion'];
                            $variableCandidato .= "&eleccion=" . $resultadoEleccion[0]['nombre'];
                            $variableCandidato .= "&idcandidato=" . $resultadoCandidatos[$can][6];
                            $variableCandidato = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableCandidato, $directorioEnlace);
                            echo "<a href='" . $variableCandidato . "'><img src='" . $rutaBloque . "/images/xmag.png' width='25px'></a>";
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        </tbody>
    </table>
</div>

<?php
//Fin de Conjunto de Controles
echo $this->miFormulario->marcoAGrupacion("fin");

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");


//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);


//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado .= "&opcion=editarEleccion";
$valorCodificado .= "&bloque=" . $esteBloque["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
if ($resultadoEleccion) {
    $valorCodificado .= "&eleccionParametrizada=" . $resultadoEleccion[0]['ideleccion'];
}

$valorCodificado = $cripto->codificar($valorCodificado);

//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"] = "formSaraData"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = false;
$atributos["etiqueta"] = "";
$atributos["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"] = "idEleccion"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = false;
$atributos["etiqueta"] = "";
$atributos["valor"] = $idEleccion;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//Fin del Formulario
echo $this->miFormulario->formulario("fin");


?>
