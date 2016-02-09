<?

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
/**
 * La conexiòn que se debe utilizar es la principal de SARA
*/

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$proceso = $_REQUEST['proceso'];
$nombreProceso = $_REQUEST['nombreProceso'];

$cadena_sql=$this->sql->cadena_sql("parametrosProceso",$proceso); 
$resultadoParametros=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

switch ($resultadoParametros[0]['calculoresultados']) {
    case '1':

        $cadena_sql=$this->sql->cadena_sql("resultadosNormales",$proceso); 
        $resultadoVotoDecodificado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

        $series = "";
	$labels = "";
	
	for($i=0;$i<count($resultadoVotoDecodificado);$i++)
	{
		if(($i + 1) == (count($resultadoVotoDecodificado)))
		{
			$series .= $resultadoVotoDecodificado[$i][1];
			$labels .= "'".$resultadoVotoDecodificado[$i][0]."'";
		}else
		{
			$series .= $resultadoVotoDecodificado[$i][1].", ";
			$labels .= "'".$resultadoVotoDecodificado[$i][0]."', ";
		}
		
	}
        ?>
        <div id='info1'>
	 
	</div>
	<div id='chart1'>
	
	</div>
	<script type='text/javascript'>
	
	$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series?>];
        var ticks = [<?php echo $labels?>];
        //var ticks = ['a', 'b', 'c', 'd'];
         
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            title:'Total de Votos',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
     
        $('#chart1').bind('jqplotDataClick',
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
    });
	</script>
	
	<table id="list4"></table>
	
	<script type="text/javascript">
		jQuery("#list4").jqGrid(
			{ 
				datatype: "local", 
				//height: 250, 
				width: 250,
				colNames:['Tarjeton','Total Votos'], 
				colModel:[ 
					{name:'tarjeton',index:'tarjeton', width:100}, 
					{name:'total',index:'total', width:80,align:"right",sorttype:"float"} ], 
					multiselect: false, 
					caption: "Resultados Proceso de Votación" }); 
					
					var mydata = [ 
					<?php
					
					for($n=0;$n<count($resultadoVotoDecodificado);$n++)
					{
						if(($n + 1) == (count($resultadoVotoDecodificado)))
						{
							echo "{tarjeton:'".$resultadoVotoDecodificado[$n][0]."',total:'".$resultadoVotoDecodificado[$n][1]."'}";
						}else
						{
							echo "{tarjeton:'".$resultadoVotoDecodificado[$n][0]."',total:'".$resultadoVotoDecodificado[$n][1]."'},";
						}
					}
					?>
					]; 
					
					for(var i=0;i<=mydata.length;i++) jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
	</script>
            
        <?php

        break;

    case '2':

        $cadena_sql=$this->sql->cadena_sql("resultadosPonderados",$proceso); 
        $resultadoVotoDecodificado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
        
        $series = "";
	$labels = "";
	
	for($i=0;$i<count($resultadoVotoDecodificado);$i++)
	{
		if(($i + 1) == (count($resultadoVotoDecodificado)))
		{
			$series .= $resultadoVotoDecodificado[$i][1];
			$labels .= "'".$resultadoVotoDecodificado[$i][0]."'";
		}else
		{
			$series .= $resultadoVotoDecodificado[$i][1].", ";
			$labels .= "'".$resultadoVotoDecodificado[$i][0]."', ";
		}
		
	}

        break;
}

?>
	
	<?php

?>
