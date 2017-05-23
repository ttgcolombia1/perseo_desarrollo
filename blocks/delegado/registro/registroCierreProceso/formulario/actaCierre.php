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
                         \'>PROCESO ELECTORAL '.strtoupper($resultadoActa[0]['nombreProceso']).'<o:p></o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>'.strtoupper($resultadoActa[0]['nombreEleccion']).' DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE
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

                        <div align=center>

                        <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=350
                         style=\'width:350.05pt;border-collapse:collapse;border:none;mso-border-alt:
                         solid windowtext .5pt;mso-yfti-tbllook:40;mso-padding-alt:0cm 5.4pt 0cm 5.4pt\'>
                         <tr style=\'mso-yfti-irow:0;mso-yfti-firstrow:yes\'>
                          <td width=300 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:10.0pt; ;
                          color:black\'>CANDIDATOS A '.strtoupper($resultadoActa[0]['nombreEleccion']).' DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE CALDAS.<o:p></o:p></span></b></span></span></p>
                          </td>
                          <td width=100 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
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

$cadena_sql=$this->sql->cadena_sql("tiporesultados",$_REQUEST['eleccion']);
$tiporesultados=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

if($tiporesultados[0][1] == 1)
{
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

}                         
else{
    $cadena_sql=$this->sql->cadena_sql("infoElecciones",$_REQUEST['eleccion']);
    $resultadosInfoEleccion=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

    $cadena_sql=$this->sql->cadena_sql("votacionesPonderada",$_REQUEST['eleccion']);
    $resultadosDecod=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

    $cadena_sql=$this->sql->cadena_sql("votacionesPonderadaPor",$_REQUEST['eleccion']);
    $resultadosDecodPor=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda"); 

    $cadena_sql=$this->sql->cadena_sql("totalvotaciones",$_REQUEST['eleccion']);
    $resultadosTotVotaciones=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
    
    $variable['ideleccion']=$_REQUEST['eleccion'];
    
    
    
    $cadena_sql=$this->sql->cadena_sql("tipoEstamentos",$variable);
    $resultadoTipoEstamentos=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
    
    /******************************************************/
        //Tabla para votos sin ponderación
        /*******************************************************/
        
        //$textoActa.='</tr>';
        $textoActa.='<tr style=\'mso-yfti-irow:5;mso-yfti-lastrow:yes;height:11.95pt\'>';
        $textoActa.='<td align="center">';
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
        $textoActa.='NÚMERO DE VOTOS';
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
                $textoActa.='No. Plancha';
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
    
    for($m=0;$m<count($resultadoTipoEstamentos);$m++)
    {
        //Asigno en un array los tipos de estamento
        $tipoEstamento .= $resultadoTipoEstamentos[$m]['idtipo']."";
        //Asigno en un array los ponderados (peso o porcentaje)d e cada estamento
        $ponderacion .=$resultadoTipoEstamentos[$m]['ponderado'].",";
		
         $textoActa.='<td width=35 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
            $textoActa.=$resultadoTipoEstamentos[$m]['descripcion'];
        $textoActa.='</td>';
    }
    
    for($m=0;$m<count($resultadoTipoEstamentos);$m++)
        {
            //Asigno en un array los tipos de estamento
            $tipoEstamento .= $resultadoTipoEstamentos[$m]['idtipo']."";
            //Asigno en un array los ponderados (peso o porcentaje)d e cada estamento
            $ponderacion .=$resultadoTipoEstamentos[$m]['ponderado'].",";

             /*$textoActa.='<td width=287 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.=$resultadoTipoEstamentos[$m]['descripcion'];
            $textoActa.='</td>';*/
        }
            $textoActa.='<td width=35 style=\'width:85.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='Votos totales';
            $textoActa.='</td>';
        //Resultados de votos decodificados 
        for($n=0;$n<count($resultadosDecod);$n++)
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$n][0]);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                         
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$resultadosDecod[$n]['nombre'];
                $textoActa.='</td>';
                $textoActa.='<td width=170 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$resultadosCandidat[0][0].' '.$resultadosCandidat[0][1];
                $textoActa.='</td>';
                $variable['plancha']=$resultadosDecod[$n]['lista'];
                //Resultados de votos decodificados por tipos de estamentos
                for($j=0;$j<count($resultadoTipoEstamentos);$j++){
                    $variable['estamento']=$tipoEstamento[$j];
                    $cadena_sql=$this->sql->cadena_sql("votacionesPorEstamento",$variable);
                    $resultadoEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

                    $cadena_sql=$this->sql->cadena_sql("cuentaPorEstamento",$variable);
                    $resultadoCuentaEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
                    //Armo un array con el número de votos por estmanto
                    $cuentaEstamentos.=$resultadoCuentaEstamento[0]['cuenta'].",";

                    if($tipoEstamento[$j]){
                        $totales+=$resultadoEstamento[0]['cuenta'];

                        $textoActa.='<td width=25 style=\'font-size:7.0pt; color:black\'>';
                            if($resultadoEstamento[0]['cuenta']!=''){
                                $textoActa.=$resultadoEstamento[0]['cuenta'];
                            }else{
                                $textoActa.=0;
                            }
                        $textoActa.='</td>';
                    }
                }
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$resultadosDecod[$n]['cuenta'];
                $textoActa.='</td>';
            $textoActa.='</tr>';
        }

            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=125 colspan=2 valign=top style=\'width:125.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt;
                          color:black\'>';
                    $textoActa.="TOTALES";
                $textoActa.='</td>';
                //$textoActa.='<td>';
                //$textoActa.='</td>';
                //Resultados de número de votos por estamento
                $cuentaEstamento=explode(",",$cuentaEstamentos);
                for($r=0;$r<count($resultadoTipoEstamentos);$r++)
                {
                    $textoActa.='<td width=18 style=\'width:250.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:7.0pt; color:black\'>';
                        $textoActa.=$cuentaEstamento[$r];
                    $textoActa.='</td>';
                }
                $textoActa.='<td width=18 style=\'width:250.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$totales;
                $textoActa.='</td>';
            $textoActa.='</tr>';

            $pond=explode(',', $ponderacion); 
            
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=135 colspan=2 style=\'width:320.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; ;
                          color:black\'>';
                    $textoActa.="PORCENTAJE <br> POR ESTAMENTO";
                $textoActa.='</td>';
                          
                //$textoActa.='<td>';
                //$textoActa.='</td>';
                //Resultados de votos por estamento
                for($r=0;$r<count($resultadoTipoEstamentos);$r++)
                {
                    $textoActa.='<td width=18 style=\'width:250.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:7.0pt; color:black\'>';
                        //Si el número de votos por estamento es diferente a 0
                        if($cuentaEstamento[$r] > 0){
                            //Calculo el coeficiente
                            $coeficiente[$r]=($pond[$r]/100)*$totales/$cuentaEstamento[$r];
                            $textoActa.=$pond[$r]."%";
                        }else{
                            $textoActa.=0;
                        }
                    $textoActa.='</td>';
                }
                $textoActa.='<td>';
                    //$resultado.=$totales;
                $textoActa.='</td>';
            $textoActa.='</tr>';
            
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=135 colspan=2 style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; ;
                          color:black\'>';
                    $textoActa.="COEFICIENTES <br> POR ESTAMENTO";
                $textoActa.='</td>';
                          
                //$textoActa.='<td>';
                //$textoActa.='</td>';
                //Resultados de votos por estamento
                for($r=0;$r<count($resultadoTipoEstamentos);$r++)
                {
                    $textoActa.='<td width=18 style=\'width:250.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:7.0pt; color:black\'>';
                        //Si el número de votos por estamento es diferente a 0
                        if($cuentaEstamento[$r] > 0){
                            //Calculo el coeficiente
                            $coeficiente[$r]=($pond[$r]/100)*$totales/$cuentaEstamento[$r];
                            $textoActa.=round($coeficiente[$r],4);
                        }else{
                            $textoActa.=0;
                        }
                    $textoActa.='</td>';
                }
                $textoActa.='<td>';
                    //$resultado.=$totales;
                $textoActa.='</td>';
            $textoActa.='</tr>';
        $textoActa.='</table>';
        //echo '<center>'.$resultado.'</center>';

        /******************************************************/
        //Tabla para ponderado
        /*******************************************************/
        //echo '<br>';    
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
	$textoActa.='<tr style=\'mso-yfti-irow:1;height:17.45pt\'>';
		$textoActa.='<td width=18 style=\'width:75.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='No. Plancha';
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
            
        for($m=0;$m<count($resultadoTipoEstamentos);$m++)
        {
            $tipoEstamento .= $resultadoTipoEstamentos[$m]['idtipo']."";   
            $ponderacion.=$resultadoTipoEstamentos[$m]['ponderado'].",";
                $textoActa.='<td width=35 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.=$resultadoTipoEstamentos[$m]['descripcion'];
            $textoActa.='</td>';
        }
            $textoActa.='<td width=35 style=\'width:85.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
             
                $textoActa.='Resultado final';
            $textoActa.='</td>';
	$textoActa.='<tr>';

        $cuentaDecod=count($resultadosDecod)-1;    
        for($n=0;$n<count($resultadosDecod);$n++)
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$n][0]);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$resultadosDecod[$n]['nombre'];
                $textoActa.='</td>';
                $textoActa.='<td width=170 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$resultadosCandidat[0][0].' '.$resultadosCandidat[0][1];
                $textoActa.='</td>';
                $variable['plancha']=$resultadosDecod[$n]['lista'];

                for($j=0;$j<count($resultadoTipoEstamentos);$j++){
                    $variable['estamento']=$tipoEstamento[$j];
                    $cadena_sql=$this->sql->cadena_sql("votacionesPorEstamento",$variable);
                    $resultadoEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

                    $cadena_sql=$this->sql->cadena_sql("cuentaPorEstamento",$variable);
                    $resultadoCuentaEstamento=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");

                    $cuentaEstamento.=$resultadoCuentaEstamento[0]['cuenta']."";

                    if($tipoEstamento[$j]){
                        $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                        //Si resultado de voto decodificado por estamento es diferente a vacío, asigne 0;
                            if($resultadoEstamento[0]['cuenta']!=''){
                                //calcula el ponderado de las votaciones decodificadas
                                $ponderado[$j]=$resultadoEstamento[0]['cuenta']*$coeficiente[$j];
                                $textoActa.=round($ponderado[$j],4);
                            }else{
                                $textoActa.=0;
                                $ponderado[$j]=0;
                            }
                        $textoActa.='</td>';
                        //Array con los totales de ponderado por candidato
                        $resultadoFinal[$n]=$resultadoFinal[$n]+$ponderado[$j];
                    }
                }
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=round($resultadoFinal[$n],4);
                    $res[$n]=array_sum($resultadoFinal);
                $textoActa.='</td>';

            $textoActa.='</tr>';
        }
        $sumatotal=array_sum($resultadoFinal);
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=135 colspan=2 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:7.0pt; ;
                          color:black\'>';
                    $textoActa.="TOTAL <br>PONDERADO";
                $textoActa.='</td>';
                //$textoActa.='<td>';
                //$textoActa.='</td>';
                for($r=0;$r<count($resultadoTipoEstamentos);$r++)
                {
                    $textoActa.='<td>';
                        //$ponderados.=$cuentaEstamento[$r];
                    $textoActa.='</td>';
                }
                //Calculo la suma de resultado final de todas las planchas
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$sumatotal;
                $textoActa.='</td>';
            $textoActa.='</tr>';
        $textoActa.='</table>';
        //echo '<center>'.$ponderados.'</center>';
        
        /*********************************************************/
        //Tabla para porcentaje final
        /*********************************************************/
        //echo '<br>';
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
        $textoActa.='<br><br><br><br><br><br>PORCENTAJE DE PONDERADOS';
        $textoActa.='</td>';
        $textoActa.='</tr>';
        //$textoActa.='<caption>Porcentaje de ponderados</caption>';
            $textoActa.=' <tr style=\'mso-yfti-irow:1;height:17.45pt\'>';
            $textoActa.='<td width=155 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>';
                $textoActa.='No. Plancha';
            $textoActa.='</td>';
            $textoActa.='<td width=234 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
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
                $textoActa.='% final';
                $textoActa.='</td>';
            $textoActa.='</tr>';

        $cuentaDecod=count($resultadosDecod)-1;    
        for($n=0;$n<count($resultadosDecod);$n++)
        {
            $cadena_sql=$this->sql->cadena_sql("candidatos",$resultadosDecod[$n][0]);
            $resultadosCandidat=$esteRecursoDB->ejecutarAcceso($cadena_sql,"busqueda");
            $textoActa.='<tr style=\'mso-yfti-irow:2;height:14.15pt\'>';
                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$resultadosDecod[$n]['nombre'];
                    $labels .= "'Lista: ".$resultadosDecod[$n]['nombre']."', ";
                $textoActa.='</td>';
                $textoActa.='<td width=170 style=\'font-size:7.0pt; color:black\'>';
                    $textoActa.=$resultadosCandidat[0][0].' '.$resultadosCandidat[0][1];
                $textoActa.='</td>';
                $variable['plancha']=$resultadosDecod[$n]['lista'];

                $textoActa.='<td width=18 style=\'font-size:7.0pt; color:black\'>';
                    //echo round($resultadoFinal[$n],4)."<br>";
                    $rf=round($resultadoFinal[$n],4);
                    $prueba[$cuentaDecod]=$res[$cuentaDecod];

                    $ciudad = array_pop($arraySuma);
                    $rt[$n]=$prueba[$cuentaDecod];
                    $resultadoPorcentaje=$rf/$rt[$n]*100;
                    $textoActa.=round($resultadoPorcentaje,4)." %";
                    $series .= $resultadoPorcentaje.", ";
                $textoActa.='</td>';
            $textoActa.='</tr>';
        }
        $sumatotal=array_sum($resultadoFinal);

       $textoActa.='</table>';
        //echo '<center>'.$porcenajefinal.'</center>';
    $textoActa.='</td>';
    $textoActa.='</tr>';
}                         
    $textoActa.='</table>

                        </div>

                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>En constancia de lo anterior, siendo las '.$hora.', se firma por quienes en ella intervinieron a los '.$dias[$dia].' ('.$dia.') días del mes de '.$mes.' de
                        '.$anno.'.<o:p></o:p></span></span></span></p>

                        <span style=\'mso-bookmark:OLE_LINK2\'></span><span style=\'mso-bookmark:OLE_LINK1\'></span>
                        
                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
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
                        style=\'mso-tab-count:1\'>        </span>Firma: ________________<o:p></o:p></span></b></p>

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
                        style=\'mso-tab-count:1\'>    </span>Firma: ________________<o:p></o:p></span></b></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Secretario del Consejo  de Participación  Universitaria<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p>
                        
                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delegado del Consejo Superior Universitario<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p>    

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
$atributos["etiqueta"]="Información del acta de cierre";
$atributos["estilo"]="jqueryui";
$atributos["tabIndex"]=$tab++;
$atributos["obligatorio"]=true;
$atributos['columnas']='50';
$atributos['valor']=$textoActa;
$atributos['filas']='25';
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