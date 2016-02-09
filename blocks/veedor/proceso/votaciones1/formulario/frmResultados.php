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

	
	$cadena_sql=$this->sql->cadena_sql("totalVotaciones",'');
	$resultadosDecod=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
	
	$series = "";
	$labels = "";
	
	for($i=0;$i<count($resultadosDecod);$i++)
	{
		if(($i + 1) == (count($resultadosDecod)))
		{
			$series .= $resultadosDecod[$i][2];
			$labels .= "'".$resultadosDecod[$i][1]."'";
		}else
		{
			$series .= $resultadosDecod[$i][2].", ";
			$labels .= "'".$resultadosDecod[$i][1]."', ";
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
        var ticks1 = [<?php echo $labels?>];
        
         
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            title: 'Votaciones',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: { show: true }
        });
     
    }); 
	</script>
	
	<table id="list4"></table>
	
	<script type="text/javascript">
		jQuery("#list4").jqGrid(
			{ 
				datatype: "local", 
				//height: 250, 
				width: 250,
				colNames:['Hora','Total Votos'], 
				colModel:[ 
					{name:'tarjeton',index:'tarjeton', width:100}, 
					{name:'total',index:'total', width:80,align:"right",sorttype:"float"} ], 
					multiselect: false, 
					caption: "Proceso de Votación" }); 
					
					var mydata = [ 
					<?php
					
					for($n=0;$n<count($resultadosDecod);$n++)
					{
						if(($n + 1) == (count($resultadosDecod)))
						{
							echo "{tarjeton:'".$resultadosDecod[$n][0]."',total:'".$resultadosDecod[$n][1]."'}";
						}else
						{
							echo "{tarjeton:'".$resultadosDecod[$n][0]."',total:'".$resultadosDecod[$n][1]."'},";
						}
					}
					?>
					]; 
					
					for(var i=0;i<=mydata.length;i++) jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
	</script>
	<?php
?>