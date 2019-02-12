<?php 

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$arreglo = array($_REQUEST['proceso'],$_REQUEST['eleccion']);

$cadena_sql = $this->sql->cadena_sql("eleccionesProcesoIdEleccion", $arreglo);
$resultadoActa = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$meses = array(" ","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$dias = array('01'=>'primero', '02'=>'dos',
              '03'=>'tres', '04'=>'cuatro',
              '05'=>'cinco', '06'=>'seis',
              '07'=>'siete', '08'=>'ocho',
              '09'=>'nueve', '10'=>'diez',
              '11'=>'once', '12'=>'doce',
              '13'=>'trece', '14'=>'catorce',
              '15'=>'quince', '16'=>'dieciséis',
              '17'=>'diecisiete', '18'=>'dieciocho',
              '19'=>'diecinueve', '20'=>'veinte',
              '21'=>'veintiuno', '22'=>'veintidós',
              '23'=>'veintitrés', '24'=>'veinticuatro',
              '25'=>'veinticinco', '26'=>'veintiséis',
              '27'=>'veintisiete', '28'=>'veintiocho',
              '29'=>'veintinueve', '30'=>'treinta',
              '31'=>'treinta y un'
            );

$hora=date('h:i A');
$dia= date('d');
$mes= $meses[date('n')];
$anno= date('Y');
$horaCierre = $resultadoActa[0]['horafin'];
$diaCierre = $resultadoActa[0]['diafin'];
$mesCierre = $meses[$resultadoActa[0]['mesfin']];
$annoCierre = $resultadoActa[0]['anniofin'];

$fecha = $dia.' de '.$mes.' de '.$anno;

$textoActa = '<p class=MsoNormal align=center style=\'text-align:center\'><a
                        name="OLE_LINK1"><span style=\'mso-bookmark:OLE_LINK2\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:16.0pt; \'>ACTA
                        DE CIERRE <o:p></o:p></span></b></span></a></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>PROCESO ELECTORAL '.mb_strtoupper($resultadoActa[0]['nombreProceso']).'<o:p></o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>'.mb_strtoupper($resultadoActa[0]['nombreEleccion']).' DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSÉ DE
                        CALDAS.<o:p></o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>'.strtoupper($fecha).'<o:p></o:p></span></b></span></span></p>

                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                        mso-bidi-font-size:10.0pt; \'>En Bogotá D.C., siendo las '.$horaCierre.' (Hora Legal de la República de Colombia) 
                        del día '.$dias[$diaCierre].' ('.$diaCierre.') del mes de '.$mesCierre.' de '.$annoCierre.', mediante el sistema de voto
                        electrónico y de urna y tarjetón virtual en la modalidad no presencial, en presencía de los firmantes 
                        se efectuó el <b style=\'mso-bidi-font-weight:normal\'><u>CIERRE Y ESCRUTINIO </u>
                        </b>de la jornada de votación, conforme a lo determinado en la normatividad electoral establecida 
                        para estos procesos electorales.<o:p></o:p></span></span></span></p>
                        
                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                        mso-bidi-font-size:10.0pt; \'>El escrutinio general de la '.$resultadoActa[0]['nombreEleccion'].', dio los siguientes resultados:<o:p></o:p></span></span></span></p>
                        ';

        
$cadena_sql=$this->sql->cadena_sql("tiporesultados",$_REQUEST['eleccion']);
$tiporesultados=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

if($tiporesultados[0][1] == 1)
{
         $textoActa.= ' <div align=center>';
        
         $textoActa.= ' <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=400
                         style=\'width:400.05pt;border-collapse:collapse;border:none;mso-border-alt:
                         solid windowtext .5pt;mso-yfti-tbllook:40;mso-padding-alt:0cm 5.4pt 0cm 5.4pt\'>
                         <tr style=\'mso-yfti-irow:0;mso-yfti-firstrow:yes\'>
                          <td width=300 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:10.0pt; ;
                          color:black\'>CANDIDATOS<o:p></o:p></span></b></span></span></p>
                          </td>
                          ';
        $textoActa.= '  <td width=100 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:10.0pt; ;
                          color:black\'>LISTA<o:p></o:p></span></b></span></span></p>
                          </td>
                          <td width=100 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:10.0pt; ;
                          color:black\'>VOTOS<o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          
                         </tr>';
    
    
    
    
    $cadena_sql = $this->sql->cadena_sql("votaciones", $_REQUEST['eleccion']);
    $resultadoVotacion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    for($l=0;$l<count($resultadoVotacion);$l++)
    {
        $candidatos="";
        $cadena_sql = $this->sql->cadena_sql("candidatos", $resultadoVotacion[$l]['idlista']);
        $resultadoCandidatos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

        for($c=0;$c<count($resultadoCandidatos);$c++)
        {
            $candidatos.="<p>".$resultadoCandidatos[$c]['nombre']." ".$resultadoCandidatos[$c]['apellido']."</p>";
        }
        $lista[$l]['candidatos']=$candidatos;
        $lista[$l]['nombre']=$resultadoVotacion[$l]['nombre'];
        $lista[$l]['resultado']=$resultadoVotacion[$l][2];

    }
    $sumaVotos = 0;
    for($i=0;$i<count($lista);$i++)
    {
        $sumaVotos += $lista[$i]['resultado'];
        $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>
                              <td width=300 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                              none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                              padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                              style=\'mso-bookmark:OLE_LINK2\'></span></span>
                              <p class=MsoNormal><span style=\'mso-bookmark:OLE_LINK1\'><span
                              style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:9.0pt;
                               ;color:black;mso-bidi-font-weight:bold\'>'.$lista[$i]['candidatos'].'</span></span></span></p>
                              </td>
                              <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                              <td width=100 style=\'width:98.7pt;border-top:none;border-left:none;
                              border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                              mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                              mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'>
                              <p class=MsoNormal align=center style=\'text-align:center\'><span
                              style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                              lang=ES-TRAD style=\'font-size:9.0pt; \'>'.$lista[$i]['nombre'].'<o:p></o:p></span></span></span></p>
                              </td>
                              <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                              <td width=100 style=\'width:98.7pt;border-top:none;border-left:none;
                              border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                              mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                              mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'>
                              <p class=MsoNormal align=center style=\'text-align:center\'><span
                              style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                              lang=ES-TRAD style=\'font-size:9.0pt; \'>'.$lista[$i]['resultado'].'<o:p></o:p></span></span></span></p>
                              </td>
                              <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                             </tr>';
    }
    
    $textoActa.='</table>';
    $textoActa.='</div>';

}                         
else{
    
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
        $textoActa.='<br>';
        $textoActa.= ' <div align=center>';
        $textoActa.='<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=350
                         style=\'width:420.05pt;border-collapse:collapse;border:none;mso-border-alt:
                         solid windowtext .5pt;mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt\'>';
        $textoActa.='<tr style=\'mso-yfti-irow:1;height:17.45pt\'>';
        $textoActa.='<td width=35 colspan=8 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
        $textoActa.='CANTIDAD DE VOTOS';
        $textoActa.='</td>';
        $textoActa.='</tr>';
        $textoActa.='<tr style=\'mso-yfti-irow:1;height:17.45pt\'>';    
        $textoActa.='<td width=18 style=\'width:75.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Lista';
            $textoActa.='</td>';
            $textoActa.='<td width=125 style=\'width:170.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Candidato';
            $textoActa.='</td>';
    $textoActa.'</tr>'; 
    
    //imprime cada estamento que participa
    foreach ($resultadoTipoEstamentos as $tes => $value) {
            $textoActa.='<td width=35 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; \'>';
            $textoActa.=$resultadoTipoEstamentos[$tes]['descripcion'];
            $textoActa.='</td>';
            }    
    
            $textoActa.='<td width=35 style=\'width:85.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Total Votos';
            $textoActa.='</td>';
            
        //Resultados de votos decodificados 
    $resultadosVotacion=array();
            
    foreach ($resultadosDecod as $pkey => $plancha) 
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$pkey]['lista']);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
            $textoActa.='  <td width=18 style=\'font-size:7.0pt; color:black\'>'.$resultadosDecod[$pkey]['nombre'].'</td>';
            $textoActa.='  <td width=125 style=\'font-size:7.0pt; color:black\'>'.$resultadosCandidat[0]['nombre'].' '.$resultadosCandidat[0]['apellido'].'</td>';
            
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
                    $textoActa.='<td width=35 style=\'font-size:7.0pt; color:black; text-align:center\'>'.$votos.'</td>';
                    } 
            
            $textoActa.='   <td width=35 style=\'font-size:8.0pt; color:black; text-align:center\'>'.$resultadosDecod[$pkey]['total'].'</td>';
            $textoActa.='</tr>';        
            array_push($resultadosVotacion, array(  'total_ponderado'=>$totalPonderado,
                                                    'lista'=>$resultadosDecod[$pkey]['lista'],
                                                    'plancha'=>$resultadosDecod[$pkey]['nombre'],
                                                    'candidato'=>$resultadosCandidat[0]['nombre'].' '.$resultadosCandidat[0]['apellido'],
                                                    'votacion'=>$resultadoPlancha,)
            );
        }
        
        //renglon totales
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=143 colspan=2 valign=top style=\'width:125.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt;
                          color:black\'>';
                    $textoActa.="Total Votos por Estamento";
                $textoActa.='</td>';
                //Resultados de número de votos por estamento
                $totales=0;
                foreach ($resultadoTipoEstamentos as $tes => $value) {
                    //Asigno en un array los tipos de estamento
                    $totales+=$resultadoTipoEstamentos[$tes]['votos'];
                    
                    $textoActa.='<td width=35 style=\'width:250.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; color:black\'>';
                    $textoActa.=$resultadoTipoEstamentos[$tes]['votos'];
                    $textoActa.='</td>';
                    }
                
                //total votos
                $textoActa.='<td width=35 style=\'width:250.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; color:black\'>';
                    $textoActa.=$totales;
                $textoActa.='</td>';
            $textoActa.='</tr>';
        $textoActa.='</table>';
        $textoActa.= ' </div>';
        //echo '<center>'.$resultado.'</center>';

        /******************************************************/
        //Tabla para ponderado
        /*******************************************************/
        //echo '<br>';    
        $textoActa.='<br>';
        $textoActa.='<div align=center>';
        $textoActa.='<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=350
                         style=\'width:420.05pt;border-collapse:collapse;border:none;mso-border-alt:
                         solid windowtext .5pt;mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt\'>';
        $textoActa.='<tr style=\'mso-yfti-irow:1;height:17.45pt\'>';
        $textoActa.='<td width=35 colspan=8 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
        $textoActa.='PONDERACIÓN DE VOTOS';
        $textoActa.='</td>';
        $textoActa.='</tr>';
        //linea para ponderacion
        $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
           $textoActa.='<td width=135 colspan=2 style=\'width:320.05pt;border:solid windowtext 1.0pt;
                      mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                      <p class=MsoNormal align=center style=\'text-align:center\'><span
                      style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                      lang=ES-TRAD style=\'font-size:7.0pt; ;
                      color:black\'>';
                $textoActa.="Pesos por estamento";
            $textoActa.='</td>';

        foreach ($resultadosVotacion[0]['votacion'] as $est => $nombre) 
                { $ponderados.='<td>'.$nombre['peso'].'%</th>';
                
                $textoActa.='<td width=35 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; \'>';
                $textoActa.=$nombre['peso'].'%';
                $textoActa.='</td>';
                }    
                $textoActa.='<td width=35 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; \'>';
                    //$resultado.=$totales;
                $textoActa.='</td>';
            $textoActa.='</tr>';

        
	$textoActa.='<tr style=\'mso-yfti-irow:1;height:17.45pt\'>';
		$textoActa.='<td width=18 style=\'width:75.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Lista';
            $textoActa.='</td>';
            $textoActa.='<td width=125 style=\'width:170.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Candidato';
            $textoActa.='</td>';
        //cabecera ponderados    
        foreach ($resultadosVotacion[0]['votacion'] as $est => $nombre) 
            {   $textoActa.='<td width=35 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; text-align:center \'>';            
            
                $textoActa.=$nombre['estamento'];
                $textoActa.='</td>';
            
            
            }    
            $textoActa.='<td width=35 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; text-align:center \'>';   
            $textoActa.='Ponderado ';
            $textoActa.='</td>';
	$textoActa.='<tr>';

        //resultados ponderados
        $totalPonderado=0;        
        foreach ($resultadosVotacion as $key => $value) {
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black; text-align:center\'>';
                $textoActa.=$resultadosVotacion[$key]['plancha'];
                $textoActa.='</td>';
                $textoActa.='<td width=170 style=\'font-size:7.0pt; color:black; text-align:center\'>';
                $textoActa.=$resultadosVotacion[$key]['candidato'];
                $textoActa.='</td>';
            //calcula el ponderado para cada candidato segun formula (%estamento)*(votos_plancha del estamento /total votos Estamento) 
            $aux=0;
            
                foreach ($resultadosVotacion[$key]['votacion'] as $pod => $votacion) 
                    {  $aux++;
                       $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black; text-align:center\'>';
                       $textoActa.=number_format($votacion['ponderado'],4);
                       $textoActa.='</td>';
                    }
                    
                $textoActa.='<td width=18 style=\'font-size:8.0pt; color:black; text-align:center\'>';
                $textoActa.=number_format($resultadosVotacion[$key]['total_ponderado'],4);
                $textoActa.='</td>';
                $textoActa.='</tr>';
                $totalPonderado+=$resultadosVotacion[$key]['total_ponderado'];            
                    
            }    
            
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
            $textoActa.='<td colspan="'.$aux.'"></td>';
            $textoActa.='<td width=135 colspan=2 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; color:black; text-align:center\'>';
            $textoActa.="TOTAL PONDERADO";
            $textoActa.='</td>';

                //Calculo la suma de resultado final de todas las planchas
            $textoActa.='<td width=18 style=\'font-size:8.0pt; color:black; text-align:center\'>';
            $textoActa.=number_format($totalPonderado,4);
            $textoActa.='</td>';
         $textoActa.='</tr>';
        $textoActa.='</table>';
        $textoActa.='</div>';
        
        /*********************************************************/
        //Tabla para porcentaje final
        /*********************************************************/
        //echo '<br>';
        
        $textoActa.='<br>';
        $textoActa.='<div align=center>';
        $textoActa.='<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=50
                         style=\'width:40.05pt;border-collapse:collapse;border:none;mso-border-alt:
                         solid windowtext .5pt;mso-yfti-tbllook:40;mso-padding-alt:0cm 5.4pt 0cm 5.4pt\'>';
        
        $textoActa.='<tr style=\'mso-yfti-irow:1;height:17.45pt\'>';
        $textoActa.='<td width=35 colspan=8 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
        $textoActa.='RESULTADO VOTACIÓN';
        $textoActa.='</td>';
        $textoActa.='</tr>';
        //$textoActa.='<caption>Porcentaje de ponderados</caption>';
            $textoActa.=' <tr style=\'mso-yfti-irow:1;height:17.45pt\'>';
		$textoActa.='<td width=18 style=\'width:75.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Lista';
            $textoActa.='</td>';
            $textoActa.='<td width=125 style=\'width:170.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Candidato';
            $textoActa.='</td>';
            $textoActa.='<td width=155 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Ponderado';
                $textoActa.='</td>';            
            $textoActa.='<td width=155 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Porcentaje';
                $textoActa.='</td>';
            $textoActa.='</tr>';

            
        arsort($resultadosVotacion);            
        foreach ($resultadosVotacion as $fin => $value) {
            $porcTotal=number_format(($resultadosVotacion[$fin]['total_ponderado']*100)/$totalPonderado,2);    
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black; text-align:center\'>';
                    $textoActa.=$resultadosVotacion[$fin]['plancha'];
                $textoActa.='</td>';
                $textoActa.='<td width=125 style=\'font-size:7.0pt; color:black; text-align:center\'>';
                    $textoActa.=$resultadosVotacion[$fin]['candidato'];
                $textoActa.='</td>';
                $textoActa.='<td width=35 style=\'font-size:7.0pt; color:black; text-align:center\'>';
                    $textoActa.=number_format($resultadosVotacion[$fin]['total_ponderado'],4);
                $textoActa.='</td>';
                $textoActa.='<td width=35 style=\'font-size:8.0pt; color:black; text-align:center\'>';
                    $textoActa.=$porcTotal." %";
                $textoActa.='</td>';                
            $textoActa.='</tr>';
            
        }    
       $textoActa.='</table>';
       $textoActa.='</div>';
}                         
$textoActa.='<br>';
$textoActa.='           <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>En constancia de lo anterior, siendo las '.$hora.', se firma por quienes en ella intervinieron a los '.$dias[$dia].' ('.$dia.') días del mes de '.$mes.' de
                        '.$anno.'.<o:p></o:p></span></span></span></p>

                        <span style=\'mso-bookmark:OLE_LINK2\'></span><span style=\'mso-bookmark:OLE_LINK1\'></span>';
           
            $textoActa.='<br> <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Jurados Electorales</b></p>
                        
                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Jurado. Nombre: ________________________ <span
                        style=\'mso-tab-count:1\'>        </span>Firma: ________________<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Jurado. Nombre: ________________________ <span
                        style=\'mso-tab-count:1\'>        </span>Firma: ________________<o:p></o:p></span></b></p>
                        
                         <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Jurado. Nombre: ________________________ <span
                        style=\'mso-tab-count:1\'>        </span>Firma: ________________<o:p></o:p></span></b></p>';
           
            $textoActa.='<br> 
                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delegados Electorales</b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delgado. Nombre: _________________________<span
                        style=\'mso-tab-count:1\'>    </span>Firma: ________________<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delgado. Nombre: _________________________<span
                        style=\'mso-tab-count:1\'>    </span>Firma: ________________<o:p></o:p></span></b></p>';
          
            $textoActa.='<br> <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Secretario del Consejo  de Participación  Universitaria<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p>';
           
            $textoActa.='<br> <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delegado del Consejo Superior Universitario<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p> ';
           
            $textoActa.='<br> 
                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delegado del Consejo de Participación Universitaria Provisional<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p>
                        ';

$nombreFormulario = 'formActaCierre';

$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado.='&opcion=generarActa';
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);
$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");
$tab=1;

//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

//-------------Control cuadroTexto-----------------------
$esteCampo='textoActa';
$atributos["id"]=$esteCampo;
$atributos["etiqueta"]="";
$atributos["estilo"]="";
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos['columnas']='80';
$atributos['valor']=$textoActa;
$atributos['filas']='40';
echo $this->miFormulario->campoTextArea($atributos);
unset($atributos);

//------------------Division para los botones-------------------------
$atributos["id"]="botones";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio",$atributos);

//-------------Control Boton-----------------------
$esteCampo="botonGenerarActa";
$atributos["id"]=$esteCampo;
$atributos["tabIndex"]=$tab++;
$atributos["tipo"]="boton";
$atributos["estilo"]="jqueryui";
$atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"]=$nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$esteCampo="formSaraData"; //No cambiar este nombre
$atributos["id"]=$esteCampo;
$atributos["tipo"]="hidden";
$atributos["obligatorio"]=false;
$atributos["etiqueta"]="";
$atributos["valor"]=$valorCodificado;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//Fin del Formulario
echo $this->miFormulario->formulario("fin");



?>