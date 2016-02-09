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


$cadena_sql=$this->sql->cadena_sql("resultados",''); 
$resultadoVotoDecodificado=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

if($resultadoVotoDecodificado)
{
	$valores['totalVotos']=$esteRecursoDB->getConteo();
	$valores['tipo']='totalVotos';
	
	//-------------Control texto-----------------------
	$esteCampo="mensajeTotalVotos";
	$atributos["tamanno"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["etiqueta"]="";
	$atributos["mensaje"]=$this->lenguaje->getCadena($esteCampo,$valores);
	$atributos["columnas"]=""; //El control ocupa 47% del tamaño del formulario
	echo $this->miFormulario->campoMensaje($atributos);
	unset($atributos);
	
	
	
	$cadena_sql=$this->sql->cadena_sql("resultadosDecod",''); 
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
}else
{
	//-------------Control texto-----------------------
	$esteCampo="mensajeVotosNoDecodificados";
	$atributos["tamanno"]="";
	$atributos["estilo"]="jqueryui";
	$atributos["etiqueta"]="";
	$atributos["mensaje"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["columnas"]=""; //El control ocupa 47% del tamaño del formulario
	echo $this->miFormulario->campoMensaje($atributos);
	unset($atributos);
}

?>
