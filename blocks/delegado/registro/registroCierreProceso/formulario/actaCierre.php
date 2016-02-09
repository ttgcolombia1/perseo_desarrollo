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
                        mso-bidi-font-size:10.0pt; \'>El escrutinio general de la '.$resultadoActa[0]['nombreEleccion'].', dio como resultado los siguientes:<o:p></o:p></span></span></span></p>

                        <div align=center>

                        <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=560
                         style=\'width:420.05pt;border-collapse:collapse;border:none;mso-border-alt:
                         solid windowtext .5pt;mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt\'>
                         <tr style=\'mso-yfti-irow:0;mso-yfti-firstrow:yes\'>
                          <td width=560 colspan=3 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:11.0pt; ;
                          color:black\'>CANDIDATOS A LA '.strtoupper($resultadoActa[0]['nombreEleccion']).' DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE CALDAS.<o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                         <tr style=\'mso-yfti-irow:1;height:17.45pt\'>
                          <td width=287 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>NOMBRES
                          Y APELLIDOS <o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=132 style=\'width:98.7pt;border-top:none;border-left:none;
                          border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>LISTA</span></b></span></span><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'><b style=\'mso-bidi-font-weight:normal\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'><o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 style=\'width:105.8pt;border-top:none;border-left:none;
                          border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                          style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:8.0pt;
                           \'>CANTIDAD DE VOTOS<o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                         ';

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
                          <td width=287 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:9.0pt;
                           ;color:black;mso-bidi-font-weight:bold\'>'.$lista[$i]['candidatos'].'</span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=132 style=\'width:98.7pt;border-top:none;border-left:none;
                          border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:12.0pt; \'>'.$lista[$i]['nombre'].'<o:p></o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 valign=top style=\'width:105.8pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>'.$lista[$i]['resultado'].'<o:p>&nbsp;</o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>';
}

                         
                         
    $textoActa.='<tr style=\'mso-yfti-irow:5;mso-yfti-lastrow:yes;height:11.95pt\'>
                          <td width=419 colspan=2 style=\'width:314.25pt;border:solid windowtext 1.0pt;
                          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:11.95pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                          style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:9.0pt;
                           \'>TOTAL<span style=\'mso-spacerun:yes\'> 
                          </span>DE<span style=\'mso-spacerun:yes\'>  </span>VOTOS</span></b></span></span><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'><o:p></o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 valign=top style=\'width:105.8pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:11.95pt\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                          style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:8.0pt;
                           \'>'.$sumaVotos.'<o:p>&nbsp;</o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                        </table>

                        </div>

                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>En constancia de lo anterior, siendo las '.$hora.', se firma por quienes en ella intervinieron. a los '.$dias[$dia].' ('.$dia.') días del mes de '.$mes.' de
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
                         \'>Secretario del Consejo Participación
                        Universitaria Provisional<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delegado del Consejo Participación
                        Universitaria Provisional<o:p></o:p></span></b></p>

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