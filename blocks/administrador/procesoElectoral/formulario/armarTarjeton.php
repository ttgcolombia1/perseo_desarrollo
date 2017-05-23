<?php
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("partials/logicaTarjeton.php");

// Consulta de todas las elecciones segun el proceso
$resultadoElecciones = $esteRecursoDB->ejecutarAcceso($this->sql->cadena_sql("consultaEleccion", array($proceso)), "busqueda");

if ($resultadoElecciones) {

    // Si hay resultado de elecciones por cada una de las elecciones
    for ($i = 0; $i < count($resultadoElecciones); $i++) {

        // Por cada una de las elecciones del proceso, consultar la lista de tarjetones de la tabla evoto_lista
        // Seleccionar las listas que estan inscritas para esta eleccion

        $cadena_sql = $this->sql->cadena_sql("listaTarjetones", $resultadoElecciones[$i]["ideleccion"]);
        $resultadoTarjeton = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
        // Traer la informacion de la eleccion.
        $cadena_sql = $this->sql->cadena_sql("infoEleccion", $resultadoElecciones[$i]["ideleccion"]);
        $resultadoInfoEleccion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
         // Formulario de Votacion

        $atributos["id"] = $nombreFormulario;
        $atributos["tipoFormulario"] = "multipart/form-data";
        $atributos["metodo"] = "POST";
        $atributos["nombreFormulario"] = $nombreFormulario;
        $verificarFormulario = "1";
        echo $this->miFormulario->formulario("inicio", $atributos);

        $tab = 0;


        if ($resultadoTarjeton) {




            $atributos["id"] = "botones";
            $atributos["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);

            echo $this->miFormulario->division("fin");

            $atributos["id"] = "Tarjeton";
            $atributos["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);

            echo "<table width='100%'>";
            echo "<caption>
                <font size=3'>
                    <b>
                    " . strtoupper($resultadoInfoEleccion[0][0]) . "
                    </b>
                </font>
                <br>
            </caption>";

            // Traer el numero de la listas por cada fila
            if (isset($resultadoInfoEleccion[0]['listatarjeton'])) {

                $listasPorFila = $resultadoInfoEleccion[0]['listatarjeton'];

            } else {

                $listasPorFila = 3;
            }

            // Verificar


            $porcentajeLista = 100 / $listasPorFila;


            $idLista = 0;
            $eleActual = '';


            for ($j = 0; $j < count($resultadoTarjeton); $j++) {


                if (($j % $listasPorFila) == 0) {
                    if ($j > 0) {
                        echo "</tr>";
                    }
                    echo "<tr heigth='200px'>";
                }
                if ($resultadoTarjeton[$j][0] != $eleActual) {
                    $arregloCandidatos = array($resultadoElecciones[$i]["ideleccion"], $resultadoTarjeton[$j][0]);
                    $cadena_sql = $this->sql->cadena_sql("listaCandidatos", $arregloCandidatos);
                    $resultadoCandidatos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                    echo "<td width='" . $porcentajeLista . "%'  class='fondoLimpio' id='seleccion" . $idLista . " aling='center'>";
                    $idLista++;
                    echo "<center><font size='5'><b>" . $resultadoTarjeton[$j][1] . "</b></font></center>";
                    $atributos["id"] = "lista" . $idLista;
                    $atributos["estilo"] = "marcoBotones";
                    echo $this->miFormulario->division("inicio", $atributos);
                    echo "<table width='100%'>";
                    echo "<tr>";
                    for ($n = 0; $n < count($resultadoCandidatos); $n++) {
                        switch ($n) {
                            case 0;
                                $posicCandidato = "Principal";
                                break;
                            case 1;
                                $posicCandidato = "Suplente";
                                break;
                            default:
                                $posicCandidato = "Candidato " . ($n + 1);
                                break;
                        }
                        echo "<td aling='center'>
                                            <center>
                                            <b>" . $posicCandidato . "</b>
                                            <br>
                                            <img src='" . $directorio . $resultadoCandidatos[$n][5] . "' title='" . $resultadoCandidatos[$n][3] . " " . $resultadoCandidatos[$n][4] . "' width='113px' height='150px'>
                                            <br>
                                            " . $resultadoCandidatos[$n][3] . " " . $resultadoCandidatos[$n][4] . "
                                           </center>     
                                        </td>";
                    }
                    echo "</tr>";
                    echo "</table>";

                    echo $this->miFormulario->division("fin", $atributos);
                    echo "</td>";
                    $eleActual = $resultadoTarjeton[$j][0];
                }
            }

            echo "</table>";

            echo $this->miFormulario->division("fin", $atributos);
        }


    }

}
