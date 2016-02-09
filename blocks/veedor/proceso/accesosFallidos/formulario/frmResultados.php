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
	
	?>
	<div id='info1'>
	 
	</div>
	<div id='chart1'>
	
	</div>
	<script type='text/javascript'>
	
	$(document).ready(function(){
        $.jqplot.config.enablePlugins = true;
        //var s1 = [2, 6, 7, 10];
        var s1 = [<?php echo $series1?>];
        var ticks1 = [<?php echo $labels1?>];
        
        var s2 = [<?php echo $series2?>];
        var ticks2 = [<?php echo $labels2?>];
        //var ticks = ['a', 'b', 'c', 'd'];
         
        plot1 = $.jqplot('chart1', [s1,s2], {
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
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: [ticks1,ticks2]
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
	
	<div>
	<table id="listUsuario"></table>
	<table id="listClave"></table>	
	</div>
	
	
	<script type="text/javascript">
		jQuery("#listUsuario").jqGrid(
			{ 
				datatype: "local", 
				//height: 250, 
				width: 250,
				colNames:['Hora','Total Usuarios'], 
				colModel:[ 
					{name:'tarjeton',index:'tarjeton', width:100}, 
					{name:'total',index:'total', width:80,align:"right",sorttype:"float"} ], 
					multiselect: false, 
					caption: "Acceso fallido usuario no existe" }); 
					
					var mydata = [ 
					<?php
					
					for($n=0;$n<count($resultadosUsuario);$n++)
					{
						if(($n + 1) == (count($resultadosUsuario)))
						{
							echo "{tarjeton:'".$resultadosUsuario[$n][0]."',total:'".$resultadosUsuario[$n][1]."'}";
						}else
						{
							echo "{tarjeton:'".$resultadosUsuario[$n][0]."',total:'".$resultadosUsuario[$n][1]."'},";
						}
					}
					?>
					]; 
					
					for(var i=0;i<=mydata.length;i++) jQuery("#listUsuario").jqGrid('addRowData',i+1,mydata[i]);
	</script>
	
	
	
	<script type="text/javascript">
		jQuery("#listClave").jqGrid(
			{ 
				datatype: "local", 
				//height: 250, 
				width: 250,
				colNames:['Hora','Total Usuarios'], 
				colModel:[ 
					{name:'tarjeton',index:'tarjeton', width:100}, 
					{name:'total',index:'total', width:80,align:"right",sorttype:"float"} ], 
					multiselect: false, 
					caption: "Acceso fallido clave invalida" }); 
					
					var mydata = [ 
					<?php
					
					for($n=0;$n<count($resultadosClave);$n++)
					{
						if(($n + 1) == (count($resultadosClave)))
						{
							echo "{tarjeton:'".$resultadosClave[$n][0]."',total:'".$resultadosClave[$n][1]."'}";
						}else
						{
							echo "{tarjeton:'".$resultadosClave[$n][0]."',total:'".$resultadosClave[$n][1]."'},";
						}
					}
					?>
					]; 
					
					for(var i=0;i<=mydata.length;i++) jQuery("#listClave").jqGrid('addRowData',i+1,mydata[i]);
	</script>
	<?php
?>