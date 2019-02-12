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

$cadena_sql=$this->sql->cadena_sql("tiporesultados",$_REQUEST['eleccion']);
$tiporesultados=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

if($tiporesultados[0][1] == 1)
    {
        $cadena_sql=$this->sql->cadena_sql("infoElecciones",$_REQUEST['eleccion']);
        $resultadosInfoEleccion=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

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
        <center>
            <h3>RESULTADOS DE VOTACI&Oacute;N</h3>
            <h3><?php echo strtoupper($resultadosInfoEleccion[0][1]);?></h3>
            <h3>FECHA DE INICIO:<?php echo strtoupper($resultadosInfoEleccion[0][3]);?></h3>
            <h3>FECHA FINALIZACIÓN: <?php echo strtoupper($resultadosInfoEleccion[0][4]);?></h3>
        </center>
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
    }else{
        
        /******************************************************************/
        /*De aquí para abajo es el cálculo de resultados ponderado
         * Controlador para la ficha de análisis
	 * @author Jesús Neira Guio - jenegui@gmail.com
	 * @since Mayo de 2016
	 */
        
        $cadena_sql=$this->sql->cadena_sql("infoElecciones",$_REQUEST['eleccion']);
        $resultadosInfoEleccion=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
        
        $cadena_sql=$this->sql->cadena_sql("votacionesPonderada",$_REQUEST['eleccion']);
        $resultadosDecod=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
        
        $cadena_sql=$this->sql->cadena_sql("votacionesPonderadaPor",$_REQUEST['eleccion']);
        $resultadosDecodPor=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
        
        $cadena_sql=$this->sql->cadena_sql("totalvotaciones",$_REQUEST['eleccion']);
        $resultadosTotVotaciones=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
        
        $variable['ideleccion']=$_REQUEST['eleccion'];
        
        $series = "";
	$labels = "";
        
        $totalListas = 0;
         
        ?>    
        <center>
            <h3>RESULTADOS DE VOTACI&Oacute;N</h3>
            <h3><?php echo strtoupper($resultadosInfoEleccion[0][1]);?></h3>
            <h3>FECHA DE INICIO:<?php echo strtoupper($resultadosInfoEleccion[0][3]);?></h3>
            <h3>FECHA FINALIZACIÓN: <?php echo strtoupper($resultadosInfoEleccion[0][4]);?></h3>
        </center>    
        <?php        
        $cadena_sql=$this->sql->cadena_sql("tipoEstamentos",$variable);
        $resultadoTipoEstamentos=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
        /******************************************************/
        //Tabla para votos sin ponderación
        /*******************************************************/
        echo "<br>";
        $resultado='<table border="0" cellpadding="0" cellspacing="0" class="tabla">';
        $resultado.='<caption>Número de votos</caption>';
            $resultado.='<th>';
                $resultado.='No. Plancha';
            $resultado.='</th>';
            $resultado.='<th>';
                $resultado.='Candidato';
            $resultado.='</th>';
        //Resultados por tipos de estamentos    
        for($m=0;$m<count($resultadoTipoEstamentos);$m++)
        {
            //Asigno en un array los tipos de estamento
            $tipoEstamento .= $resultadoTipoEstamentos[$m]['idtipo']."";
            //Asigno en un array los ponderados (peso o porcentaje)d e cada estamento
            $ponderacion .=$resultadoTipoEstamentos[$m]['ponderado'].",";

            $resultado.='<th>';
                $resultado.=$resultadoTipoEstamentos[$m]['descripcion'];
            $resultado.='</th>';
        }
            $resultado.='<th>';
                $resultado.='Votos totales';
            $resultado.='</th>';
        //Resultados de votos decodificados 
        for($n=0;$n<count($resultadosDecod);$n++)
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$n][0]);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            $resultado.='<tr class="modo2">';
                $resultado.='<td>';
                    $resultado.=$resultadosDecod[$n]['nombre'];
                $resultado.='</td>';
                $resultado.='<td>';
                    $resultado.=$resultadosCandidat[0][0].' '.$resultadosCandidat[0][1];
                $resultado.='</td>';
                $variable['plancha']=$resultadosDecod[$n]['lista'];
                //Resultados de votos decodificados por tipos de estamentos
                for($j=0;$j<count($resultadoTipoEstamentos);$j++){
                    $variable['estamento']=$tipoEstamento[$j];
                    $cadena_sql=$this->sql->cadena_sql("votacionesPorEstamento",$variable);
                    $resultadoEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
                    //echo $cadena_sql."<br><br>";    
                    $cadena_sql=$this->sql->cadena_sql("cuentaPorEstamento",$variable);
                    $resultadoCuentaEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
                    //Armo un array con el número de votos por estmanto
                    $cuentaEstamentos.=$resultadoCuentaEstamento[0]['cuenta'].",";

                    if($tipoEstamento[$j]){
                        $totales+=$resultadoEstamento[0]['cuenta'];
                    
                        $resultado.='<td>';
                            if($resultadoEstamento[0]['cuenta']!=''){
                                $resultado.=$resultadoEstamento[0]['cuenta'];
                            }else{
                                $resultado.=0;
                            }
                        $resultado.='</td>';
                    }
                }
                $resultado.='<td>';
                    $resultado.=$resultadosDecod[$n]['cuenta'];
                $resultado.='</td>';
            $resultado.='</tr>';
        }

            $resultado.='<tr class="modo1">';
                $resultado.='<td>';
                    $resultado.="TOTALES";
                $resultado.='</td>';
                $resultado.='<td>';
                $resultado.='</td>';
                //var_dump($cuentaEstamento);
                //Resultados de número de votos por estamento
                $cuentaEstamento=explode(",",$cuentaEstamentos);
                for($r=0;$r<count($resultadoTipoEstamentos);$r++)
                {
                    $resultado.='<td>';
                        $resultado.=$cuentaEstamento[$r];
                    $resultado.='</td>';
                }
                $resultado.='<td>';
                    $resultado.=$totales;
                $resultado.='</td>';
            $resultado.='</tr>';

            $pond=explode(',', $ponderacion); 
				
	    $resultado.='<tr class="modo2">';
                $resultado.='<td>';
                    $resultado.="PESO POR <br> ESTAMENTO";
                $resultado.='</td>';
                $resultado.='<td>';
                $resultado.='</td>';
                //Resultados de votos por estamento
                for($q=0;$q<count($resultadoTipoEstamentos);$q++)
                {
                    $resultado.='<td>';
                        //Si el número de votos por estamento es diferente a 0
                        if($cuentaEstamento[$q] > 0){
                            //Calculo el coeficiente
                            $coeficiente[$q]=($pond[$q]/100)*$totales/$cuentaEstamento[$q];
                            $resultado.=$pond[$q]."%";
                        }else{
                            $resultado.="O%";
                        }
                    $resultado.='</td>';
                }
                $resultado.='<td>';
                    //$resultado.=$totales;
                $resultado.='</td>';
            $resultado.='</tr>';				
				
            $resultado.='<tr class="modo1">';
                $resultado.='<td>';
                    $resultado.="COEFICIENTES <br> POR ESTAMENTO";
                $resultado.='</td>';
                $resultado.='<td>';
                $resultado.='</td>';
                //Resultados de votos por estamento
                for($r=0;$r<count($resultadoTipoEstamentos);$r++)
                {
                    $resultado.='<td>';
                        //Si el número de votos por estamento es diferente a 0
                        if($cuentaEstamento[$r] > 0){
                            //Calculo el coeficiente
                            $coeficiente[$r]=($pond[$r]/100)*$totales/$cuentaEstamento[$r];
                            $resultado.=round($coeficiente[$r],4);
                        }else{
                            $resultado.=0;
                        }
                    $resultado.='</td>';
                }
                $resultado.='<td>';
                    //$resultado.=$totales;
                $resultado.='</td>';
            $resultado.='</tr>';
        $resultado.='</table>';
        echo '<center>'.$resultado.'</center>';

        /******************************************************/
        //Tabla para ponderado
        /*******************************************************/
        echo '<br>';    
        $ponderados='<table border="0" cellpadding="0" cellspacing="0" class="tabla">';
        $ponderados.='<caption>Ponderación de votos</caption>';
            $ponderados.='<th>';
                $ponderados.='No. Plancha';
            $ponderados.='</th>';
            $ponderados.='<th>';
                $ponderados.='Candidato';
            $ponderados.='</th>';
        for($m=0;$m<count($resultadoTipoEstamentos);$m++)
        {
            $tipoEstamento .= $resultadoTipoEstamentos[$m]['idtipo']."";   
            $ponderacion .=$resultadoTipoEstamentos[$m]['ponderado'].",";

            $ponderados.='<th>';
                $ponderados.=$resultadoTipoEstamentos[$m]['descripcion'];
            $ponderados.='</th>';
        }
            $ponderados.='<th>';
                $ponderados.='Resultado final';
            $ponderados.='</th>';


        $cuentaDecod=count($resultadosDecod)-1;    
        for($n=0;$n<count($resultadosDecod);$n++)
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$n][0]);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            $ponderados.='<tr class="modo2">';
                $ponderados.='<td>';
                    $ponderados.=$resultadosDecod[$n]['nombre'];
                $ponderados.='</td>';
                $ponderados.='<td>';
                    $ponderados.=$resultadosCandidat[0][0].' '.$resultadosCandidat[0][1];
                $ponderados.='</td>';
                $variable['plancha']=$resultadosDecod[$n]['lista'];

                for($j=0;$j<count($resultadoTipoEstamentos);$j++){
                    $variable['estamento']=$tipoEstamento[$j];
                    $cadena_sql=$this->sql->cadena_sql("votacionesPorEstamento",$variable);
                    $resultadoEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

                    $cadena_sql=$this->sql->cadena_sql("cuentaPorEstamento",$variable);
                    $resultadoCuentaEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

                    $cuentaEstamento.=$resultadoCuentaEstamento[0]['cuenta']."";

                    if($tipoEstamento[$j]){
                        $ponderados.='<td>';
                        //Si resultado de voto decodificado por estamento es diferente a vacío, asigne 0;
                            if($resultadoEstamento[0]['cuenta']!=''){
                                //calcula el ponderado de las votaciones decodificadas
                                $ponderado[$j]=$resultadoEstamento[0]['cuenta']*$coeficiente[$j];
                                $ponderados.=round($ponderado[$j],4);
                            }else{
                                $ponderados.=0;
                                $ponderado[$j]=0;
                            }
                        $ponderados.='</td>';
                        //Array con los totales de ponderado por candidato
                        $resultadoFinal[$n]=$resultadoFinal[$n]+$ponderado[$j];
                    }
                }
                $ponderados.='<td>';
                    $ponderados.=round($resultadoFinal[$n],4);
                    $res[$n]=array_sum($resultadoFinal);
                $ponderados.='</td>';

            $ponderados.='</tr>';
        }
        $sumatotal=array_sum($resultadoFinal);
            $ponderados.='<tr class="modo1">';
                $ponderados.='<td>';
                    $ponderados.="TOTAL <br>PONDERADO";
                $ponderados.='</td>';
                $ponderados.='<td>';
                $ponderados.='</td>';
                for($r=0;$r<count($resultadoTipoEstamentos);$r++)
                {
                    $ponderados.='<td>';
                        //$ponderados.=$cuentaEstamento[$r];
                    $ponderados.='</td>';
                }
                //Calculo la suma de resultado final de todas las planchas
                $ponderados.='<td>';
                    $ponderados.=$sumatotal;
                $ponderados.='</td>';
            $ponderados.='</tr>';
        $ponderados.='</table>';
        echo '<center>'.$ponderados.'</center>';

        /*********************************************************/
        //Tabla para porcentaje final
        /*********************************************************/
        echo '<br>';
        $porcenajefinal='<table table border="0" cellpadding="0" cellspacing="0" class="tabla">';
        $porcenajefinal.='<caption>Porcentaje de ponderados</caption>';
            $porcenajefinal.='<th>';
                $porcenajefinal.='No. Plancha';
            $porcenajefinal.='</th>';
            $porcenajefinal.='<th>';
                $porcenajefinal.='Candidato';
            $porcenajefinal.='</th>';
            $porcenajefinal.='<th>';
                $porcenajefinal.='% final';
            $porcenajefinal.='</th>';

        $cuentaDecod=count($resultadosDecod)-1;    
        for($n=0;$n<count($resultadosDecod);$n++)
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$n][0]);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            $porcenajefinal.='<tr class="modo2">';
                $porcenajefinal.='<td>';
                    $porcenajefinal.=$resultadosDecod[$n]['nombre'];
                    $labels .= "'Lista: ".$resultadosDecod[$n]['nombre']."', ";
                $porcenajefinal.='</td>';
                $porcenajefinal.='<td>';
                    $porcenajefinal.=$resultadosCandidat[0][0].' '.$resultadosCandidat[0][1];
                $porcenajefinal.='</td>';
                $variable['plancha']=$resultadosDecod[$n]['lista'];

                $porcenajefinal.='<td>';
                    //echo round($resultadoFinal[$n],4)."<br>";
                    $rf=round($resultadoFinal[$n],4);
                    $prueba[$cuentaDecod]=$res[$cuentaDecod];

                    $ciudad = array_pop($arraySuma);
                    $rt[$n]=$prueba[$cuentaDecod];
                    $resultadoPorcentaje=$rf/$rt[$n]*100;
                    $porcenajefinal.=round($resultadoPorcentaje,4)." %";
                    $series .= $resultadoPorcentaje.", ";
                $porcenajefinal.='</td>';
            $porcenajefinal.='</tr>';
        }
        $sumatotal=array_sum($resultadoFinal);

        $porcenajefinal.='</table>';
        echo '<center>'.$porcenajefinal.'</center>';


        /*********************************************************/
        //Grafica con los porcenajes
        /*********************************************************/


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

        <?php
}