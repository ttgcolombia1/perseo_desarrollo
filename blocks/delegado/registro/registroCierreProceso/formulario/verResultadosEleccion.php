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
//muestra resultados calculo normal
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
            <h4>FECHA DE INICIO:<?php echo strtoupper($resultadosInfoEleccion[0][3]);?></h4>
            <h4>FECHA FINALIZACIÓN: <?php echo strtoupper($resultadosInfoEleccion[0][4]);?></h4>
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
    }
    
else{
        
        /******************************************************************/
        /*De aquí para abajo es el cálculo de resultados ponderado
         * Controlador para la ficha de análisis
	 * @author Jesús Neira Guio - jenegui@gmail.com
	 * @since Mayo de 2016
	 */
        $cadena_sql=$this->sql->cadena_sql("idioma");
        $esteRecursoDB->ejecutarAcceso($cadena_sql,"registro"); 
        
        $cadena_sql=$this->sql->cadena_sql("infoElecciones",$_REQUEST['eleccion']);
        $resultadosInfoEleccion=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
        
        $peso=array('Estudiantes'=>$resultadosInfoEleccion[0]['porcEstudiante'],
                    'Docentes'=>$resultadosInfoEleccion[0]['porcDocente'],
                    'Egresados'=>$resultadosInfoEleccion[0]['porcEgresado'],
                    'Administrativos'=>$resultadosInfoEleccion[0]['porcFuncionario'],
                    'Docentes vinculación especial'=>$resultadosInfoEleccion[0]['porcDocenteVinEspecial'],);
        
        $cadena_sql=$this->sql->cadena_sql("votosxcandidato",$_REQUEST['eleccion']);
        $resultadosDecod=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
        
        $cadena_sql=$this->sql->cadena_sql("totalvotaciones",$_REQUEST['eleccion']);
        $resultadosTotVotaciones=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 
        
        $variable['ideleccion']=$_REQUEST['eleccion'];
        
        $totalListas = 0;
        
        ?>    
        <center>
            <h3>RESULTADOS DE VOTACI&Oacute;N</h3>
            <h3><?php echo mb_strtoupper($resultadosInfoEleccion[0][1]);?></h3>
            
            <h4>FECHA DE INICIO:<?php echo strtoupper($resultadosInfoEleccion[0][3]);?></h4>
            <h4>FECHA FINALIZACIÓN: <?php echo strtoupper($resultadosInfoEleccion[0][4]);?></h4>
        </center>    
        <?php       
        
        //se buscan estamentos y se asignan pesos según lo registrado en la elección
        $cadena_sql=$this->sql->cadena_sql("tipoEstamentos",$variable);
        $resultadoEstamentos=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
                
        $resultadoTipoEstamentos=array();
        foreach ($resultadoEstamentos as $key => $value)
            { if($peso[$resultadoEstamentos[$key]['descripcion']]>0)
                 {$resultadoTipoEstamentos[$key]=$resultadoEstamentos[$key];
                  $resultadoTipoEstamentos[$key]['ponderado']=$peso[$resultadoEstamentos[$key]['descripcion']];
                  $resultadoTipoEstamentos[$key]['votos']=0;
                 }
        }
                
        
        /******************************************************/
        //Tabla para votos sin ponderación
        /*******************************************************/
        $resultado='<table border="0" cellpadding="0" cellspacing="0" class="tabla">';
        $resultado.='<caption>Cantidad de votos</caption>';
            $resultado.='<th>';
                $resultado.='Lista';
            $resultado.='</th>';
            $resultado.='<th>';
                $resultado.='Candidato';
            $resultado.='</th>';
        //Resultados por tipos de estamentos    
            foreach ($resultadoTipoEstamentos as $tes => $value) {
                //Asigno en un array los ponderados (peso o porcentaje)d e cada estamento
                $resultado.='<th>';
                    $resultado.=$resultadoTipoEstamentos[$tes]['descripcion'];
                $resultado.='</th>';
            }    
            $resultado.='<th>';
                $resultado.='Total votos';
            $resultado.='</th>';
    $resultadosVotacion=array();
            
    foreach ($resultadosDecod as $pkey => $plancha) 
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$pkey]['lista']);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            $resultado.='<tr class="modo2">';
            $resultado.='<td>'.$resultadosDecod[$pkey]['nombre'].'</td>';
            $resultado.='<td>'.$resultadosCandidat[0]['nombre'].' '.$resultadosCandidat[0]['apellido'].'</td>';
            $variable['plancha']=$resultadosDecod[$pkey]['lista'];
            //Resultados de votos decodificados por tipos de estamentos
           // var_dump($resultadoTipoEstamentos);
            $resultadoPlancha=array();
            $totalPonderado=0;
                foreach ($resultadoTipoEstamentos as $tes => $value) {
                    //Asigno en un array los tipos de estamento
                    $variable['estamento']=$resultadoTipoEstamentos[$tes]['idtipo'];
                    $cadena_sql=$this->sql->cadena_sql("votacionesPorEstamento",$variable);
                    $resultadoEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
                    //busca cantidad votos por estamento
                    $cadena_sql=$this->sql->cadena_sql("cuentaPorEstamento",$variable);
                    $resultadoCuentaEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
                    //Armo un array con el número de votos por estmanto
                    $resultadoTipoEstamentos[$tes]['votos']=($resultadoCuentaEstamento[0]['cuenta']!='')?$resultadoCuentaEstamento[0]['cuenta']:0;
                    $votos=($resultadoEstamento[0]['cuenta']!='')?$resultadoEstamento[0]['cuenta']:0;
                    
                    //Se realiza el calculo ponderado [%estamento x (votos plancha de estamento / total votos estamento) ]
                    if($resultadoTipoEstamentos[$tes]['votos']>0)
                            { $pondEstamento= ($resultadoTipoEstamentos[$tes]['ponderado']/100)*($votos / $resultadoTipoEstamentos[$tes]['votos']);}
                        else 
                            {$pondEstamento=0;}
                    $totalPonderado+=$pondEstamento;        
                    array_push($resultadoPlancha,array('estamento'=>$resultadoTipoEstamentos[$tes]['descripcion'],
                                                       'votos_plancha'=>$votos,
                                                       'total_estamento'=>$resultadoTipoEstamentos[$tes]['votos'],
                                                       'peso' => $resultadoTipoEstamentos[$tes]['ponderado'],
                                                       'ponderado' => $pondEstamento) 
                              );
                    //imprime resultado    
                    $resultado.='<td>'.$votos.'</td>';
                    } 
                $resultado.='<td>';
                    //total votos al candidato
                    $resultado.=$resultadosDecod[$pkey]['total'];
                $resultado.='</td>';
            $resultado.='</tr>';
            array_push($resultadosVotacion, array(  'total_ponderado'=>$totalPonderado,
                                                    'lista'=>$resultadosDecod[$pkey]['lista'],
                                                    'plancha'=>$resultadosDecod[$pkey]['nombre'],
                                                    'candidato'=>$resultadosCandidat[0]['nombre'].' '.$resultadosCandidat[0]['apellido'],
                                                    'votacion'=>$resultadoPlancha,)
            );
        }
        
            $resultado.='<tr class="modo1">';
                $resultado.='<td colspan="2">Total Votos por Estamento</td>';
                $totales=0;
                foreach ($resultadoTipoEstamentos as $tes => $value) {
                    //Asigno en un array los tipos de estamento
                    $totales+=$resultadoTipoEstamentos[$tes]['votos'];
                    $resultado.='<td>';
                       $resultado.=$resultadoTipoEstamentos[$tes]['votos'];
                    $resultado.='</td>';
                    }
                
                $resultado.='<td>'.$totales.'</td>';
            $resultado.='</tr>';
        $resultado.='</table>';
        echo '<center>'.$resultado.'</center>';

        /******************************************************/
        //Tabla para ponderado
        /*******************************************************/
        $ponderados='<table border="0" cellpadding="0" cellspacing="0" class="tabla">';
        $ponderados.='<tr class="modo2">';
            $ponderados.='<td colspan="2"> ';
                $ponderados.="PESOS POR ESTAMENTO";
            $ponderados.='</td>';
            foreach ($resultadosVotacion[0]['votacion'] as $est => $nombre) 
                { $ponderados.='<td>'.$nombre['peso'].'%</th>';}    
            $ponderados.='<td>';
                //$resultado.=$totales;
            $ponderados.='</td>';
        $ponderados.='</tr>';				

        $ponderados.='<caption>Ponderación de votos</caption>';
            $ponderados.='<th> Lista </th>';
            $ponderados.='<th> Candidato </th>';
        //imprime el nombre de los estamentos    
        foreach ($resultadosVotacion[0]['votacion'] as $est => $nombre) 
            { $ponderados.='<th>'.$nombre['estamento'].'</th>';}    
            $ponderados.='<th> Ponderado </th>';
        $totalPonderado=0;        
        $itemGrafico=array();
        foreach ($resultadosVotacion as $key => $value) {
            $ponderados.='<tr class="modo2">';
            $ponderados.='<td>'.$resultadosVotacion[$key]['plancha'].'</td>';
            $ponderados.='<td>'.$resultadosVotacion[$key]['candidato'].'</td>';
            //calcula el ponderado para cada candidato segun formula (%estamento)*(votos_plancha del estamento /total votos Estamento) 
            $aux=0;
            foreach ($resultadosVotacion[$key]['votacion'] as $pod => $votacion) 
                { $ponderados.='<td>'.number_format($votacion['ponderado'],4).'</td>';
                  $aux++;
                }    
            $ponderados.='<td>'.number_format($resultadosVotacion[$key]['total_ponderado'],4).'</td>';    
            $ponderados.='</tr>';
            $totalPonderado+=$resultadosVotacion[$key]['total_ponderado'];  
            $labels .= "'Lista: ".$resultadosVotacion[$key]['plancha']."', ";
            
            array_push($itemGrafico,array('lista'=>$resultadosVotacion[$key]['lista'],
                                          'labels'=>"'Lista: ".$resultadosVotacion[$key]['plancha']."', ",
                                          'ponderado' => $resultadosVotacion[$key]['total_ponderado'], 
                                          'porcentaje'=>0) 
                              );
            
            
        }    
        $ponderados.='<tr class="modo1">';
        $ponderados.='<td colspan="'.$aux.'"></td>';
        $ponderados.='<td colspan="2">Total Ponderado</td>';
        $ponderados.='<td>'.number_format($totalPonderado,4).'</td>';
        $ponderados.='</tr>';
        $ponderados.='</table>';
        echo '<center>'.$ponderados.'</center>';

        /*********************************************************/
        //Tabla para porcentaje final
        /*********************************************************/
        $porcenajefinal='<table border="0" cellpadding="0" cellspacing="0" class="tabla">';
        $porcenajefinal.='<caption>Resultados Votación</caption>';
            $porcenajefinal.='<th>Lista  </th>';
            $porcenajefinal.='<th>Candidato</th>';
            $porcenajefinal.='<th>Ponderado </th>';
            $porcenajefinal.='<th>Porcentaje </th>';
        //ordena el array de mayor a menos según el primer valor
        arsort($resultadosVotacion);            
        foreach ($resultadosVotacion as $fin => $value) {
            $porcTotal=number_format(($resultadosVotacion[$fin]['total_ponderado']*100)/$totalPonderado,2);    
            //asigna valo graficas
            //No soportada por version anterior a 5.4  
            //$pos = array_search($resultadosVotacion[$fin]['lista'], array_column($itemGrafico, 'lista'));
          
            //reemplaza la funcion array_column()
            foreach ($itemGrafico as $key => $value) {
                if($value['lista']==$resultadosVotacion[$fin]['lista'])
                    {$pos =$key;}
            }
            
            $itemGrafico[$pos]['porcentaje']=$porcTotal.", ";
            
            $porcenajefinal.='<tr class="modo2">';
            $porcenajefinal.='<td>'.$resultadosVotacion[$fin]['plancha'].'</td>';
            $porcenajefinal.='<td>'.$resultadosVotacion[$fin]['candidato'].'</td>';
            $porcenajefinal.='<td>'.number_format($resultadosVotacion[$fin]['total_ponderado'],4).'</td>';    
            $porcenajefinal.='<td>'.$porcTotal.' %</td>';    
            $porcenajefinal.='</tr>';
        }    
        $porcenajefinal.='</table>';
        echo '<center>'.$porcenajefinal.'</center>';
        /*********************************************************/
        //Grafica con los porcenajes
        /*********************************************************/

        $labels=$series='';
        foreach ($itemGrafico as $value) 
                {$labels .= $value['labels'];
                 $series .= $value['porcentaje'];
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
                title: 'Total Porcentaje Votación',
                axes: {
                    xaxis: {
                        renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks
                    },
                    yaxis: { tickOptions: { formatString: '%.2f' } }
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


?>
