<?php
//claves erroneas
$cadena_sql = $this->sql->cadena_sql("totalVotantes", '');
$resultadosParticipacion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
$censo=0;
$promediar = 0;

$seriesPArray = array();
$labelsPArray = array();

if ($resultadosParticipacion) {
    $series1 = $resultadosParticipacion[0]['conteo'];
    foreach ($resultadosParticipacion as $participa) {
      array_push($seriesPArray,intval($participa['conteo']));
      array_push($labelsPArray,"'".$participa['tipo']."'");
      if($participa['tipo']=='Censo')
        {$censo=$participa['conteo'];}
      if($participa['tipo']=='Votantes')
        {$promediar=$participa['conteo'];}  
    }

} else {
    array_push($seriesPArray,0);
    array_push($labelsPArray,"'Participación'");
}

if($resultadosCenso){
  $valorMaximo = $resultadosCenso[0]['conteo'];
  $votantesFaltantes = intval($valorMaximo) - intval($series1);
}
?>

<script type='text/javascript'>

    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo implode(",",$seriesPArray) ?>];
        var ticks1 = [<?php echo implode(",",$labelsPArray) ?>];

        plot1 = $.jqplot('votantesFaltantes', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            title: 'Total participación - <?php echo round($promediar / $censo * 100, 2); ?> %',
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
