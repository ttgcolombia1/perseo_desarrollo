<?


if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

/**
 * La conexiòn que se debe utilizar es la principal de SARA
*/
$conexion="voto";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

	
	$cadena_sql=$this->sql->cadena_sql("usuarioAcceso",'');
	$resultadosAcceso=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
	
	
	$series1 = "";
	$labels1 = "";
	
	for($i=0;$i<count($resultadosAcceso);$i++)
	{
		if(($i + 1) == (count($resultadosAcceso)))
		{
			$series1 .= $resultadosAcceso[$i][1];
			$labels1 .= "'".$resultadosAcceso[$i][0]."'";
		}else
		{
			$series1 .= $resultadosAcceso[$i][1].", ";
			$labels1 .= "'".$resultadosAcceso[$i][0]."', ";
		}
		
	}
	
	
	?>
	<table>
		<tr>
		<td><div id='chart1'></div></td>
		<td><div id='chart2'></div></td>
		</tr>
		<tr>
		<td><div id='chart3'></div></td>
		<td><div id='chart4'></div></td>
		</tr>
	</table>
	 
	 
	<script type='text/javascript'>
	
	$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1?>];
        var ticks1 = [<?php echo $labels1?>];
        
         
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            title: 'Accesos a la plataforma virtual',
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
	
	<?php	
	//Accesos Fallidos
	
	$cadena_sql=$this->sql->cadena_sql("usuarioNoExiste",'');
	$resultadosUsuario=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
	
	$cadena_sql=$this->sql->cadena_sql("usuarioClave",'');
	$resultadosClave=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
	
	$series1 = "";
	$labels1 = "";
	
	for($i=0;$i<count($resultadosUsuario);$i++)
	{
		if(($i + 1) == (count($resultadosUsuario)))
		{
			$series1 .= $resultadosUsuario[$i][1];
			$labels1 .= "'".$resultadosUsuario[$i][0]."'";
		}else
		{
			$series1 .= $resultadosUsuario[$i][1].", ";
			$labels1 .= "'".$resultadosUsuario[$i][0]."', ";
		}
		
	}
	
	$series2 = "";
	$labels2 = "";
	
	for($i=0;$i<count($resultadosClave);$i++)
	{
		if(($i + 1) == (count($resultadosClave)))
		{
			$series2 .= $resultadosClave[$i][1];
			$labels2 .= "'".$resultadosClave[$i][0]."'";
		}else
		{
			$series2 .= $resultadosClave[$i][1].", ";
			$labels2 .= "'".$resultadosClave[$i][0]."', ";
		}
		
	}
        var_dump($series1);
	
	?>
	
	<script type='text/javascript'>
	
	$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1?>];
        var ticks1 = [<?php echo $labels1?>];
        
        var s2 = [<?php echo $series2?>];
        var ticks2 = [<?php echo $labels2?>];
        //var ticks = ['a', 'b', 'c', 'd'];
         
        plot1 = $.jqplot('chart2', [s1,s2], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            series:[
	            {label:'Usuario No Existe'},
	            {label:'Clave invalida'}
	        ],
	        legend: {
	            show: true,
	            placement: 'outsideGrid'
	        },
	        title: 'Accesos Fallidos a la plataforma virtual',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: { show: false }
        });
     
    });
	</script>
	
	<?php
	
	//Certificados
	
	$cadena_sql=$this->sql->cadena_sql("certificadosGenerados",'');
	$resultadosCertificados=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
	
	
	$series1 = "";
	$labels1 = "";
	
	for($i=0;$i<count($resultadosCertificados);$i++)
	{
		if(($i + 1) == (count($resultadosCertificados)))
		{
			$series1 .= $resultadosCertificados[$i][1];
			$labels1 .= "'".$resultadosCertificados[$i][0]."'";
		}else
		{
			$series1 .= $resultadosCertificados[$i][1].", ";
			$labels1 .= "'".$resultadosCertificados[$i][0]."', ";
		}
		
	}
	
	
	?>
	
	<script type='text/javascript'>
	
	$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1?>];
        var ticks1 = [<?php echo $labels1?>];
        
         
        plot1 = $.jqplot('chart3', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            title: 'Certificados generados',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: { show: false }
        });
     
    });
	</script>
	
		
	<?php
	
	//Votaciones
	
	$cadena_sql=$this->sql->cadena_sql("totalVotaciones",'');
	$resultadosDecod=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
	
	$series = "";
	$labels = "";
	
	for($i=0;$i<count($resultadosDecod);$i++)
	{
		if(($i + 1) == (count($resultadosDecod)))
		{
			$series .= $resultadosDecod[$i][1];
			$labels .= "'".$resultadosDecod[$i][0]."'";
		}else
		{
			$series .= $resultadosDecod[$i][1].", ";
			$labels .= "'".$resultadosDecod[$i][0]."', ";
		}
		
	}
	
	?>
	
	
	<script type='text/javascript'>
	
	$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series?>];
        var ticks = [<?php echo $labels?>];
        //var ticks = ['a', 'b', 'c', 'd'];
         
        plot1 = $.jqplot('chart4', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            title: 'Proceso de votación',
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            
            highlighter: { 
            	show: false 
            	}
        });
     
    });
	</script>
	
	
	<?php
	
?>