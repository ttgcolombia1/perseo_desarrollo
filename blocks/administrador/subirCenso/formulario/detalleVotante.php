<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];
$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$rutaHash = $this->miConfigurador->getVariableConfiguracion("raizDocumento");
$nombreFormulario = $esteBloque["nombre"];

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$identificacion = $_REQUEST['identificacion'];
$proceso = $_REQUEST['proceso'];

$consulta = array($identificacion, "", $proceso);
$cadena_sql = $this->sql->cadena_sql("validarDatoCenso", $consulta);
$resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if ($resultado) {

    echo "<div class='datagrid'><table id='tablaProcesosActivos'>";
    echo "<thead>
                <tr>
                    <th>Identificacion</th>
                    <th>Nombre</th>
                    <th>Tipo Estamento</th>
                    <th>Eleccion</th>
                </tr>
            </thead>
            <tbody>";

    for ($i = 0; $i < count($resultado); $i++) {

        $idEstamento = $resultado[$i][4];
        $eleccion=$resultado[$i][2];
        $consultaEleccion = array($eleccion);
        $cadena_sql = $this->sql->cadena_sql("consultaSimpleEleccion", $consultaEleccion);
        $resultadoEleccion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

        $consultaEstamento = array($idEstamento);
        $cadena_sql = $this->sql->cadena_sql("consultaEstamento", $consultaEstamento);
        $resultadoEstamento = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");


        $parametrosEliminarVotante = array("pagina" => "subirCenso",
            "action" => "subirCenso",
            "opcion" => "eliminarVotante",
            "bloqueGrupo" => "administrador",
            "bloque" => $esteBloque["id_bloque"],
            "identificacion" => $resultado[$i][0],
            "eleccion" => $proceso
        );

        $parametrosBusquedaVotante = array("pagina" => "subirCenso",
            "opcion" => "consulta",
            "proceso" => $proceso
        );
        $homeUrl = $this->miFormulario->enlaceCifrado($parametrosBusquedaVotante);

        $urlEliminarVotante = $this->miFormulario->enlaceCifrado($parametrosEliminarVotante);

        echo "<tr>
                    <td>" . $resultado[$i][0] . "</td>
                    <td>" . $resultado[$i][3] . "</td>
                    <td>" . $resultadoEstamento[0]['descripcion'] . "</td>
                    <td>" . $resultadoEleccion[0]["nombre"] . "</td>
                </tr>";
        /*
        echo "<tr>
                    <td>" . $resultado[$i][0] . "</td>
                    <td>" . $resultado[$i][3] . "</td>
                    <td>" . $resultadoEstamento[0]['descripcion'] . "</td>
                    <td>" . $resultadoEleccion[0]["nombre"] . "</td>
                    <td>
                        <input type='hidden' name='urlEliminar' value='" . $urlEliminarVotante . "'>
                        <input type='hidden' name='homeUrl' value='".$homeUrl."'>
                        <input type='hidden' name='eliminarVotante'>
                        <button id='botonEliminar'>Eliminar</button>
                        <button id='botonEditar'>Editar</button>
                    </td>
                </tr>";*/
    }

    echo "</tbody>";
    echo "</table></div>";

    echo "<div id=\"dialog-confirm\" title=\"¿Borrar Votante?\">";
    echo "<p><span class=\"ui-icon ui-icon-alert\" style=\"float:left; margin:12px 12px 20px 0;\"></span>";
    echo "Este votante se eliminará del censo, ¿Está seguro?</p>";
    echo "</div>";

}