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


// Enlace API borrado de candidatos
$enlaceEliminar['enlace'] = "pagina=parametrizarProcesoElectoral&action=parametrizarProcesoElectoral&opcion=eliminarCandidato&bloqueGrupo=administrador&bloque=".$esteBloque["id_bloque"];
$enlaceEliminar['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceEliminar['enlace'], $directorioEnlace);



$tab = 1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$atributos["titulo"] = $nombreFormulario;
echo $this->miFormulario->formulario("inicio", $atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "nombreEleccion" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Digite el nombre de la elección: ";
$atributos["titulo"] = "Digite el nombre de la elección ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 40;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "required, minSize[5]";
$atributos["categoria"] = "";
$atributos["evento"] = " OnkeyUp=\"cambiarTitulo('" . $idEleccion . "');\" ";
if ($resultadoEleccion) {
    $atributos["valor"] = $resultadoEleccion[0]['nombre'];
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);
/*
//------------------Control Lista Desplegable------------------------------
$esteCampo = "tipoestamento" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["evento"] = 2;
//$atributos["seleccion"] = 0;
$atributos["columnas"] = "1";
$atributos["limitar"] = false;
$atributos["tamanno"] = 1;
$atributos["ancho"] = "250px";
$atributos["estilo"] = "jqueryui";
$atributos["etiquetaObligatorio"] = true;
$atributos["validar"] = "required";
$atributos["anchoEtiqueta"] = 300;
$atributos["obligatorio"] = true;
$atributos["etiqueta"] = "Tipo de estamento: ";

if ($resultadoEleccion) {
    $atributos["seleccion"] = $resultadoEleccion[0]['tipoestamento'];
}

//-----De donde rescatar los datos ---------
$atributos["cadena_sql"] = $this->sql->cadena_sql("tipoestamento");
$atributos["baseDatos"] = "estructura";
// Se deshabilita para dejr por defecto para toda ellecion valor 0 Todos los estamentos
//echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);*/

//-------------Control cuadroTexto-----------------------
$esteCampo = "descripcion" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Digite la descripción de la elección: ";
$atributos["titulo"] = "Digite la descripción de la elección ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 40;
$atributos["etiquetaObligatorio"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "required, minSize[5]";
$atributos["categoria"] = "";
if ($resultadoEleccion) {
    $atributos["valor"] = $resultadoEleccion[0]['descripcion'];
}
echo $this->miFormulario->campoCuadroTexto($atributos);
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
$atributos["anchoEtiqueta"] = 300;
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
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "required";
$atributos["categoria"] = "fecha";
if ($resultadoEleccion) {
    $atributos["valor"] = $resultadoEleccion[0]['fechafin'];
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);


//------------------Control Lista Desplegable------------------------------
$esteCampo = "segundaClave" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["nombre"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["etiquetaObligatorio"] = true;
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "required";
$atributos["obligatorio"] = true;
$atributos["estilo"] = "campoCuadroTexto";
$atributos["etiqueta"] = "Uso segunda clave:";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['utilizarsegundaclave'] == 1) {
        $atributos["valor"] = "on";
        $atributos["seleccionado"] = true;
    } else {
        $atributos["valor"] = "off";
        $atributos["seleccionado"] = false;
    }

}
echo $this->miFormulario->campoCuadroSeleccion($atributos);
unset($atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo = "listaTarjeton" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Digite el número de columnas por tarjeton: ";
$atributos["titulo"] = "Digite el número de columnas ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 10;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "required, minSize[1]";
$atributos["categoria"] = "";
if ($resultadoEleccion) {
    $atributos["valor"] = $resultadoEleccion[0]['listaTarjeton'];
}
else {    $atributos["valor"] = 2;}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//------------------Control Lista Desplegable------------------------------
$esteCampo = "tipovotacion" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["evento"] = 2;
$atributos["columnas"] = "1";
$atributos["limitar"] = false;
$atributos["tamanno"] = 1;
$atributos["ancho"] = "250px";
$atributos["estilo"] = "jqueryui";
$atributos["etiquetaObligatorio"] = true;
$atributos["validar"] = "required";
$atributos["anchoEtiqueta"] = 300;
$atributos["obligatorio"] = true;
$atributos["etiqueta"] = "Tipo de Votación";
if ($resultadoEleccion) {
    $atributos["seleccion"] = $resultadoEleccion[0]['tipovotacion'];
} else {
    $atributos["seleccion"] = 0;
}
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"] = $this->sql->cadena_sql("tipovotacion");
$atributos["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);


//------------------Control Lista Desplegable------------------------------
$esteCampo = "tiporesultados" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["evento"] = 2;
$atributos["columnas"] = "1";
$atributos["limitar"] = false;
$atributos["tamanno"] = 1;
$atributos["ancho"] = 350;
$atributos["estilo"] = "jqueryui";
$atributos["etiquetaObligatorio"] = true;
$atributos["validar"] = "required";
$atributos["anchoEtiqueta"] = 300;
$atributos["ancho"] = "250px";
$atributos["obligatorio"] = true;
$atributos["etiqueta"] = "Tipo de resultados:";
if ($resultadoEleccion) {
    $atributos["seleccion"] = $resultadoEleccion[0]['tiporesultado'];
} else {
    $atributos["seleccion"] = 0;
}
//-----De donde rescatar los datos ---------
$atributos["cadena_sql"] = $this->sql->cadena_sql("tiporesultados");
$atributos["baseDatos"] = "estructura";
echo $this->miFormulario->campoCuadroLista($atributos);
unset($atributos);

//------------------Division para los botones-------------------------
$atributos["id"] = "resultados";
$atributos["estilo"] = "marcoBotones";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['tiporesultado'] == 2) {
        $atributos["estiloEnLinea"] = "display: block;";
    } else {
        $atributos["estiloEnLinea"] = "display: none;";
    }
} else {
    $atributos["estiloEnLinea"] = "display: none;";
}

echo $this->miFormulario->division("inicio", $atributos);
unset($atributos);

$esteCampo = "resulEstudiantes" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Porcentaje voto estudiantes: ";
$atributos["titulo"] = "Digite el valor en porcentaje del voto de estudiante ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 5;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "max[100],min[0],custom[number]";
$atributos["evento"] = " OnkeyUp=\"calculoPonderado('" . $idEleccion . "');\" ";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['tiporesultado'] == 2) {
        $atributos["valor"] = $resultadoEleccion[0]['porcEstudiante'];
    } else {
        $atributos["valor"] = 0;
    }
} else {
    $atributos["valor"] = 0;
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo = "resulDocentes" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Porcentaje voto docentes: ";
$atributos["titulo"] = "Digite el valor en porcentaje del voto de docentes ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 5;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "max[100],min[0],custom[number]";
$atributos["evento"] = " OnkeyUp=\"calculoPonderado('" . $idEleccion . "');\" ";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['tiporesultado'] == 2) {
        $atributos["valor"] = $resultadoEleccion[0]['porcDocente'];
    } else {
        $atributos["valor"] = 0;
    }
} else {
    $atributos["valor"] = 0;
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo = "resulEgresados" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Porcentaje voto egresados: ";
$atributos["titulo"] = "Digite el valor en porcentaje del voto de egresados ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 5;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "max[100],min[0],custom[number]";
$atributos["evento"] = " OnkeyUp=\"calculoPonderado('" . $idEleccion . "');\" ";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['tiporesultado'] == 2) {
        $atributos["valor"] = $resultadoEleccion[0]['porcEgresado'];
    } else {
        $atributos["valor"] = 0;
    }
} else {
    $atributos["valor"] = 0;
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo = "resulFuncionarios" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Porcentaje voto funcionarios: ";
$atributos["titulo"] = "Digite el valor en porcentaje del voto de funcionarios ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 5;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "max[100],min[0],custom[number]";
$atributos["evento"] = " OnkeyUp=\"calculoPonderado('" . $idEleccion . "');\" ";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['tiporesultado'] == 2) {
        $atributos["valor"] = $resultadoEleccion[0]['porcFuncionario'];
    } else {
        $atributos["valor"] = 0;
    }
} else {
    $atributos["valor"] = 0;
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo = "resulDocenteVinEspecial" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Porcentaje voto Docentes Vinc. Especial: ";
$atributos["titulo"] = "Digite el valor en porcentaje del voto de Docentes Vinc. Especial ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 5;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "max[100],min[0],custom[number]";
$atributos["evento"] = " OnkeyUp=\"calculoPonderado('" . $idEleccion . "');\" ";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['tiporesultado'] == 2) {
        $atributos["valor"] = $resultadoEleccion[0]['porcDocenteVinEspecial'];
    } else {
        $atributos["valor"] = 0;
    }
} else {
    $atributos["valor"] = 0;
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

$esteCampo = "resulSuma" . $idEleccion;
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = "Suma de Porcentajes: ";
$atributos["titulo"] = "Suma de Porcentajes ";
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = 5;
$atributos["columnas"] = 1;
$atributos["etiquetaObligatorio"] = false;
$atributos["deshabilitado"] = true;
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["anchoEtiqueta"] = 300;
$atributos["validar"] = "maxSize[3],max[100],min[100],custom[number]";
if ($resultadoEleccion) {
    if ($resultadoEleccion[0]['tiporesultado'] == 2) {
        $atributos["valor"] = $resultadoEleccion[0]['porcEstudiante'] + $resultadoEleccion[0]['porcDocente'] + $resultadoEleccion[0]['porcEgresado'] + $resultadoEleccion[0]['porcFuncionario'] + $resultadoEleccion[0]['porcDocenteVinEspecial'];
    } else {
        $atributos["valor"] = 0;
    }
} else {
    $atributos["valor"] = 0;
}
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");


//------------------Division para los botones-------------------------
$atributos["id"] = "gestionar";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);
unset($atributos);

if ($resultadoEleccion) {
    
        //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosCandidatos";
        $atributos["id"] = $esteCampo;
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
        unset($atributos);

        if ($resultadoEleccion) {
            $arrayCandidatos = array($proceso, $resultadoEleccion[0]['ideleccion']);
            $this->cadena_sql = $this->sql->cadena_sql("consultaCandidatos", $arrayCandidatos);
            $resultadoListaCandidatos = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
        }
        
        ?>
        <input type="hidden" name="candidato_url" value="<?php echo $enlaceEliminar['urlCodificada'] ?>">
        <div id="scroll" class="datagrid" style=" width: 100%">
            <table id="tablaCandidatos<?php echo $idEleccion ?>" width="90%">
                <!-- Cabecera de la tabla -->
                <thead>
                <?php

                if ($resultadoEleccion) {
                    ?>
                    <tr>
                        <th>Nombre Lista</th>
                        <th>Posición Lista</th>
                        <th>Renglón</th>
                        <th>Identificación</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                    <?php
                } else {
                    ?>
                    <tr>
                        <th>Nombre Lista</th>
                        <th>Posición Lista</th>
                        <th>Renglón</th>
                        <th>Identificación</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Foto</th>
                        <th>Borrar</th>
                    </tr>
                    <?php
                }
                ?>
                </thead>

                <!-- Cuerpo de la tabla con los campos -->
                <tbody>

                <?php

                if ($resultadoEleccion) {
                    if ($resultadoListaCandidatos) {

                        for ($can = 0; $can < count($resultadoListaCandidatos); $can++) {

                            ?>

                            <tr>
                                <td>
                                    <?php echo $resultadoListaCandidatos[$can][0] ?>
                                </td>
                                <td>
                                    <?php echo $resultadoListaCandidatos[$can][1] ?>
                                </td>
                                <td>
                                    <?php echo $resultadoListaCandidatos[$can][7] ?>
                                </td>
                                <td>
                                    <?php echo $resultadoListaCandidatos[$can][2] ?>
                                </td>
                                <td>
                                    <?php echo $resultadoListaCandidatos[$can][3] ?>
                                </td>
                                <td>
                                    <?php echo $resultadoListaCandidatos[$can][4] ?>
                                </td>
                                <td>
                                    <img src='<?php echo $rutaCandidatos . $resultadoListaCandidatos[$can][5] ?>' width="100px">
                                </td>
                                <td>
                                    <img class="eliminar" src='<?php echo $rutaBloque . "/images/cancel.png" ?>'>
                                    <input type="hidden" value="<?php echo $resultadoListaCandidatos[$can]["identificacion"] ?>">
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
                                    $variableCandidato .= "&idcandidato=" . $resultadoListaCandidatos[$can][6];
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
                <!-- fila base para clonar y agregar al final -->
                <tr id="fila-base<?php echo $idEleccion ?>" class="fila-base">
                    <td>
                        <?php
                        //-------------Control cuadroTexto-----------------------
                        $esteCampo = "nombreLista" . $idEleccion . "[]";
                        $atributos["id"] = $esteCampo;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["obligatorio"] = true;
                        $atributos["tamanno"] = 10;
                        $atributos["columnas"] = 1;
                        $atributos["etiquetaObligatorio"] = false;
                        $atributos["tipo"] = "";
                        $atributos["estilo"] = "jqueryui";
                        $atributos["anchoEtiqueta"] = 300;
                        $atributos["validar"] = "required, minSize[1]";
                        $atributos["categoria"] = "";
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        ?>
                        <!--<input type="text" class="identificacion" name='identificacion<?php echo $idEleccion; ?>[]' id='identificacion<?php echo $idEleccion; ?>[]'/>-->
                    </td>
                    <td>
                        <?php
                        //-------------Control cuadroTexto-----------------------
                        $esteCampo = "posicionLista" . $idEleccion . "[]";
                        $atributos["id"] = $esteCampo;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["obligatorio"] = true;
                        $atributos["tamanno"] = 2;
                        $atributos["columnas"] = 1;
                        $atributos["etiquetaObligatorio"] = false;
                        $atributos["tipo"] = "";
                        $atributos["estilo"] = "jqueryui";
                        $atributos["anchoEtiqueta"] = 300;
                        $atributos["validar"] = "required, custom[integer]";
                        $atributos["categoria"] = "";
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        ?>
                        <!--<input type="text" class="nombres" name='nombres<?php echo $idEleccion; ?>[]' id='nombres<?php echo $idEleccion; ?>[]' />-->
                    </td>
                    <td>
                        <?php
                        //-------------Control cuadroTexto-----------------------
                        $esteCampo = "renglon" . $idEleccion . "[]";
                        $atributos["id"] = $esteCampo;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["obligatorio"] = true;
                        $atributos["tamanno"] = 2;
                        $atributos["columnas"] = 1;
                        $atributos["etiquetaObligatorio"] = false;
                        $atributos["tipo"] = "";
                        $atributos["estilo"] = "jqueryui";
                        $atributos["anchoEtiqueta"] = 300;
                        $atributos["validar"] = "required, custom[integer]";
                        $atributos["categoria"] = "";
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        ?>
                        <!--<input type="text" class="nombres" name='nombres<?php echo $idEleccion; ?>[]' id='nombres<?php echo $idEleccion; ?>[]' />-->
                    </td>            
                    <td>
                        <?php
                        //-------------Control cuadroTexto-----------------------
                        $esteCampo = "identificacion" . $idEleccion . "[]";
                        $atributos["id"] = $esteCampo;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["obligatorio"] = true;
                        $atributos["tamanno"] = 15;
                        $atributos["columnas"] = 1;
                        $atributos["etiquetaObligatorio"] = false;
                        $atributos["tipo"] = "";
                        $atributos["estilo"] = "jqueryui";
                        $atributos["anchoEtiqueta"] = 300;
                        $atributos["validar"] = "required, minSize[3],maxSize[12], custom[integer]";
                        $atributos["evento"] = " OnkeyUp=\"validarIdentificacion('" . $idEleccion . "');\" ";
                        $atributos["categoria"] = "";
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        ?>
                        <!--<input type="text" class="identificacion" name='identificacion<?php echo $idEleccion; ?>[]' id='identificacion<?php echo $idEleccion; ?>[]'/>-->
                    </td>
                    <td>
                        <?php
                        //-------------Control cuadroTexto-----------------------
                        $esteCampo = "nombres" . $idEleccion . "[]";
                        $atributos["id"] = $esteCampo;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["obligatorio"] = true;
                        $atributos["tamanno"] = 15;
                        $atributos["columnas"] = 1;
                        $atributos["etiquetaObligatorio"] = false;
                        $atributos["tipo"] = "";
                        $atributos["estilo"] = "jqueryui";
                        $atributos["anchoEtiqueta"] = 300;
                        $atributos["validar"] = "required, minSize[2]";
                        $atributos["categoria"] = "";
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        ?>
                        <!--<input type="text" class="nombres" name='nombres<?php echo $idEleccion; ?>[]' id='nombres<?php echo $idEleccion; ?>[]' />-->
                    </td>
                    <td>
                        <?php
                        //-------------Control cuadroTexto-----------------------
                        $esteCampo = "apellidos" . $idEleccion . "[]";
                        $atributos["id"] = $esteCampo;
                        $atributos["tabIndex"] = $tab++;
                        $atributos["obligatorio"] = true;
                        $atributos["tamanno"] = 15;
                        $atributos["columnas"] = 1;
                        $atributos["etiquetaObligatorio"] = false;
                        $atributos["tipo"] = "";
                        $atributos["estilo"] = "jqueryui";
                        $atributos["anchoEtiqueta"] = 300;
                        $atributos["validar"] = "required, minSize[2]";
                        $atributos["categoria"] = "";
                        echo $this->miFormulario->campoCuadroTexto($atributos);
                        unset($atributos);

                        ?>
                        <!--<input type="text" class="apellidos" name='apellidos<?php echo $idEleccion; ?>[]' id='apellidos<?php echo $idEleccion; ?>[]' />-->
                    </td>
                    <td>
                        <input type='file' name='foto<?php echo $idEleccion; ?>[]' id='foto<?php echo $idEleccion; ?>[]'
                               class="validate[required]">
                    </td>
                    <td class="eliminar"><img src='<?php echo $rutaBloque . "/images/cancel.png" ?>'></td>
                </tr>
                <!-- fin de código: fila base -->
                </tbody>
            </table>
        </div>

        <!-- Botón para agregar filas -->
        <button type="button" id="agregar<?php echo $idEleccion ?>" value="Agregar Candidato" onclick="agregarfila('<?php echo $idEleccion ?>')">Agregar Candidato</button>
        <br>

        <?php
          
        $esteCampo = 'foto';
        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
        $atributos["etiqueta"] = "";
        $atributos["estilo"] = "centrar";
        $atributos["tipo"] = 'information';
        $atributos["mensaje"] = 'Recuerde que el archivo de la fotografía debe ser en formato JPG, JPEG o PNG.';
        echo $this->miFormulario->cuadroMensaje($atributos);
        unset($atributos); 
       
        //Fin de Conjunto de Controles
        echo $this->miFormulario->marcoAGrupacion("fin");

}
//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");


//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);


//-------------Control Boton-----------------------
$esteCampo = "guardar";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["tipo"] = "boton";
$atributos["estilo"] = "jqueryui";
$atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"] = "Guardar Elección";
$atributos["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);

//-------------Fin Control Boton----------------------

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado .= "&opcion=guardarEleccion";
$valorCodificado .= "&bloque=" . $esteBloque["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
if ($resultadoEleccion) {
    $valorCodificado .= "&eleccionParametrizada=" . $resultadoEleccion[0]['ideleccion'];
}
//Se da por defecto para la elección todos los estamentos 04092017 
$valorCodificado .= "&tipoestamento".$idEleccion."=0";


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
