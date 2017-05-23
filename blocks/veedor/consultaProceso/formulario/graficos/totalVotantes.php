<?php
//claves erroneas
$cadena_sql = $this->sql->cadena_sql("totalVotantes", '');
$resultadosVotantes = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$cadena_sql = $this->sql->cadena_sql("totalCenso", '');
$resultadosCenso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$series1 = "";
$labels1 = "";
$valorMaximo = 0;

if ($resultadosVotantes) {

    $series1 = $resultadosVotantes[0]['conteo'];

} else {
    $series1 = "0,0";
    $labels1 = "0,0";
}

if($resultadosCenso){
  $valorMaximo = $resultadosCenso[0]['conteo'];
}
?>

<script type='text/javascript'>

    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1 ?>];
        var ticks1 = ["Total de Votantes"];


        plot1 = $.jqplot('chart5', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            title: 'Total de Votos Realizados en la jornada',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                },
                yaxis: {
                  max: <?php echo $valorMaximo ?>
                }
            },
            highlighter: {show: true}
        });
    });
</script>
