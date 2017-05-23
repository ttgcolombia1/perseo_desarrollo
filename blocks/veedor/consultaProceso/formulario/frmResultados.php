<?php
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

/**
 * La conexiòn que se debe utilizar es la principal de SARA
 */
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql('zonaHoraria', '');
$resultadosAcceso = $esteRecursoDB->ejecutarAcceso($cadena_sql, 'acceso');



echo "<center><h4>Seguimiento del proceso " . date('d M Y') . "</h4></center>";
$cadena_sql = $this->sql->cadena_sql("usuarioAcceso", '');
$resultadosAcceso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

//echo $cadena_sql."<br>";

$series1 = '';
$labels1 = '';

if ($resultadosAcceso) {
    for ($i = 0; $i < count($resultadosAcceso); $i++) {
        if ($resultadosAcceso[$i][0] == date('Y m d')) {
            if (($i + 1) == (count($resultadosAcceso))) {
                $series1 .= $resultadosAcceso[$i][3];
                $labels1 .= "'" . $resultadosAcceso[$i][2] . "'";
            } else {
                $series1 .= $resultadosAcceso[$i][3] . ", ";
                $labels1 .= "'" . $resultadosAcceso[$i][2] . "', ";
            }
        }
    }
} else {
    $series1 = "0,0";
    $labels1 = "0,0";
}

if($series1 == "" || $labels1=="")
    {
        $series1 = "0,0";
        $labels1 = "0,0";
    }
?>
<table width="100%">
    <tr>
        <td><div id='chart1'></div></td>
        <td><div id='chart2'></div></td>
    </tr>
    <tr>
        <td><div id='chart3'></div></td>
        <td><div id='chart4'></div></td>
    </tr>
    <tr>
        <td><div id='votantesEstamento'></div></td>
        <td><div id='votantesFaltantes'></div></td>
    </tr>
</table>


<script type='text/javascript'>

    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1 ?>];
        var ticks1 = [<?php echo $labels1 ?>];


        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            title: 'Accesos a la plataforma virtual',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: {show: true}
        });

    });
</script>

<?php
//Accesos Fallidos
$cadena_sql = $this->sql->cadena_sql("usuarioNoExiste", '');
$resultadosUsuario = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$series1 = "";
$labels1 = "";

if ($resultadosUsuario) {
    for ($i = 0; $i < count($resultadosUsuario); $i++) {
        if ($resultadosUsuario[$i][0] == date('Y m d')) {
            if (($i + 1) == (count($resultadosUsuario))) {
                $series1 .= $resultadosUsuario[$i][3];
                $labels1 .= "'" . $resultadosUsuario[$i][2] . "'";
            } else {
                $series1 .= $resultadosUsuario[$i][3] . ", ";
                $labels1 .= "'" . $resultadosUsuario[$i][2] . "', ";
            }
        }
    }
} else {
    $series1 = "0,0";
    $labels1 = "0,0";
}


if($series1 == "" || $labels1=="")
    {
        $series1 = "0,0";
        $labels1 = "0,0";
    }
?>

<script type='text/javascript'>

    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1 ?>];
        var ticks1 = [<?php echo $labels1 ?>];


        plot1 = $.jqplot('chart2', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            title: 'Accesos fallidos a la plataforma virtual, usuario invalido',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: {show: true}
        });

    });
</script>

<?php
//Certificados
$cadena_sql = $this->sql->cadena_sql("totalVotaciones", '');
$resultadosCertificados = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$series1 = "";
$labels1 = "";
$totalVotos = 0;

if ($resultadosCertificados) {
    for ($i = 0; $i < count($resultadosCertificados); $i++) {
        if ($resultadosCertificados[$i][0] == date('Y m d')) {
            if (($i + 1) == (count($resultadosCertificados))) {
                $series1 .= $resultadosCertificados[$i][3];
                $labels1 .= "'" . $resultadosCertificados[$i][2] . "'";
                
            } else {
                $series1 .= $resultadosCertificados[$i][3] . ", ";
                $labels1 .= "'" . $resultadosCertificados[$i][2] . "', ";
            }
            $totalVotos+=$resultadosCertificados[$i][3];
        }
    }
} else {
    $series1 = "0,0";
    $labels1 = "0,0";
}

if($series1 == "" || $labels1=="")
    {
        $series1 = "0,0";
        $labels1 = "0,0";
    }
?>

<script type='text/javascript'>

    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1 ?>];
        var ticks1 = [<?php echo $labels1 ?>];


        plot1 = $.jqplot('chart3', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            title: 'Votos Realizados por hora - Total Votos <?php echo $totalVotos ?>',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: {show: true}
        });

    });
</script>


<?php
//claves erroneas
$cadena_sql = $this->sql->cadena_sql("usuarioClave", '');
$resultadosClave = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$series1 = "";
$labels1 = "";

if ($resultadosClave) {
    for ($i = 0; $i < count($resultadosClave); $i++) {
        if ($resultadosClave[$i][0] == date('Y m d')) {
            if (($i + 1) == (count($resultadosClave))) {
                $series1 .= $resultadosClave[$i][3];
                $labels1 .= "'" . $resultadosClave[$i][2] . "'";
            } else {
                $series1 .= $resultadosClave[$i][3] . ", ";
                $labels1 .= "'" . $resultadosClave[$i][2] . "', ";
            }
        }
    }
} else {
    $series1 = "0,0";
    $labels1 = "0,0";
}

if($series1 == "" || $labels1=="")
    {
        $series1 = "0,0";
        $labels1 = "0,0";
    }
?>

<script type='text/javascript'>

    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1 ?>];
        var ticks1 = [<?php echo $labels1 ?>];


        plot1 = $.jqplot('chart4', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            title: 'Accesos fallidos a la plataforma virtual, clave invalida',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: {show: true}
        });
    });
</script>

<?php// include("graficos/totalVotantes.php"); ?>
<?php include("graficos/totalVotantesFaltantes.php"); ?>
<?php include("graficos/totalVotantesEstamento.php"); ?>
