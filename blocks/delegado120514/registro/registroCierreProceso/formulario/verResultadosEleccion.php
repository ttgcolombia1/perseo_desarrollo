<?php


if(!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$miBloque=$this->miConfigurador->getVariableConfiguracion("esteBloque");
$indice=$this->miConfigurador->getVariableConfiguracion("host").$this->miConfigurador->getVariableConfiguracion("site")."/index.php?";
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$nombreFormulario=$miBloque["nombre"];
$tab=1;

$valorCodificado="&opcion=confirmar";
$valorCodificado.="&bloque=".$miBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$miBloque["grupo"];
$valorCodificado=$this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

/**
 * La conexiòn que se debe utilizar es la principal de SARA
*/

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
/*
$cadena_sql=$this->sql->cadena_sql("tiporesultados",$_REQUEST['eleccion']);
$tiporesultados=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

if($tiporesultados[0][1] == 1)
    {*/
        $cadena_sql=$this->sql->cadena_sql("votaciones",$_REQUEST['eleccion']);
        $resultadosDecod=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
          
        $series = "";
	$labels = "";
	
	for($i=0;$i<count($resultadosDecod);$i++)
	{
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$i][0]);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
            
		if(($i + 1) == (count($resultadosDecod)))
		{
			$series .= $resultadosDecod[$i][2];
			$labels .= "'Lista: ".$resultadosDecod[$i][1]."'";
		}else
		{
			$series .= $resultadosDecod[$i][2].", ";
			//$labels .= "'".$resultadosDecod[$i][0]."', ";
			$labels .= "'Lista: ".$resultadosDecod[$i][1]."', ";
		}
		
	}
	
	?>
        <center><h3>RESULTADOS DE VOTACI&Oacute;N</h3></center>
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
				width: 650,
				colNames:['Lista','Candidato Principal','Total Votos'], 
				colModel:[ 
					{name:'tarjeton',index:'tarjeton', width:100}, 
					{name:'candidato',index:'candidato', width:100}, 
					{name:'total',index:'total', width:80,align:"right",sorttype:"float"} ], 
					multiselect: false, 
					caption: "Proceso de Votación" }); 
					
					var mydata = [ 
					<?php
					
					for($n=0;$n<count($resultadosDecod);$n++)
					{
                                            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$n][0]);
                                            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
						if(($n + 1) == (count($resultadosDecod)))
						{
							echo "{tarjeton:'".$resultadosDecod[$n][1]."',candidato:'".$resultadosCandidat[0][0]." ".$resultadosCandidat[0][1]."',total:'".$resultadosDecod[$n][2]."'}";
						}else
						{
							echo "{tarjeton:'".$resultadosDecod[$n][1]."',candidato:'".$resultadosCandidat[0][0]." ".$resultadosCandidat[0][1]."',total:'".$resultadosDecod[$n][2]."'},";
						}
					}
					?>
					]; 
					
					for(var i=0;i<=mydata.length;i++) jQuery("#list4").jqGrid('addRowData',i+1,mydata[i]);
	</script>
	<?php
  /*  }else
        {
            $cadena_sql=$this->sql->cadena_sql("votacionesPonderada",$_REQUEST['eleccion']);
            $resultadosDecod=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

            
            $totalListas = 0;
            
            for($n=0;$n<count($resultadosDecod);$n++)
            {
                switch ($resultadosDecod[$n]['estamento'])
                {
                    case '1':
                            $arregloResul[$totalListas] = array($resultadosDecod[$n]['nombre'],($tiporesultados[0][4]/100));                             
                            $totalListas++;
                        break;
                    case '2':
                            $arregloResul[$totalListas] = array($resultadosDecod[$n]['nombre'],($tiporesultados[0][5]/100));
                            $totalListas++;
                        break;
                    case '3':
                            $arregloResul[$totalListas] = array($resultadosDecod[$n]['nombre'],($tiporesultados[0][3]/100));
                            $totalListas++;
                        break;
                    case '4':
                            $arregloResul[$totalListas] = array($resultadosDecod[$n]['nombre'],($tiporesultados[0][2]/100));
                            $totalListas++;
                        break;
                }
            }
            
            $totalResultados = 0;
            for($m=0;$m<count($arregloResul);$m++)
            {
                if($arregloResul[$m - 1][0] != $arregloResul[$m][0])
                    {
                        $resultadosPonderados[$arregloResul[$m][0]] += $arregloResul[$m][0];
                    }
            }
            var_dump($resultadosPonderados);
        }
*/

?>