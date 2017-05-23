<?php
//claves erroneas
$cadena_sql = $this->sql->cadena_sql("totalPorEstamento", '');
$resultadosVotantes = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");


$series1 = "";
$labels1 = "";
$valorMaximo = 0;

//var_dump($resultadosVotantes);
$series1Array = array();
$labels1Array = array();

if ($resultadosVotantes) {

    $series1 = $resultadosVotantes[0]['conteo'];
    foreach ($resultadosVotantes as $resultado) {
      array_push($series1Array,$resultado['conteo']);
      array_push($labels1Array,"'".$resultado['descripcion']."'");
    }

} else {
    array_push($series1Array,0);
    array_push($labels1Array,"'Estamento'");
}

?>

<script type='text/javascript'>

    $(document).ready(function() {
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo implode(",",$series1Array) ?>];
        var ticks1 = [<?php echo implode(",",$labels1Array) ?>];


        plot1 = $.jqplot('votantesEstamento', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults: {
                renderer: $.jqplot.BarRenderer,
                pointLabels: {show: true}
            },
            title: 'Votos Realizados Por Estamento',
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
