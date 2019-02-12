<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}	
$ruta=$this->miConfigurador->getVariableConfiguracion('raizDocumento');
include($ruta.'/classes/html2pdf/html2pdf.class.php');

//$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

$unidad=['UNO','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE'];
$decenas=['DIEZ','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA'];
$annos=(date('Y')-1948);
$posdec=ceil($annos/10)-1;
$posun=($annos%10);
$letras='';
if($posdec>0 && $posun>0){$letras=$decenas[$posdec-1].'  Y ';}
elseif($posdec>0 && $posun==0){$letras=$decenas[$posdec];}

if($posun>0){$letras.=' '.$unidad[$posun-1];}

$contenidoPagina = "<page backtop='30mm' backbottom='10mm' backleft='20mm' backright='20mm'>";
$contenidoPagina .= "<page_header>
        <table align='center' style='width: 100%;'>
            <tr>
                <td align='center' >
                    <img src='".$directorio."css/images/escudo.jpg'>
                </td>
                <td align='center' >
                    <font size='18px'><b>UNIVERSIDAD DISTRITAL</b></font>
                    <br>
                    <font size='18px'><b>FRANCISCO JOS&Eacute; DE CALDAS</b></font>
                    <br>
                    <font size='9px'><b>1948 - ".date('Y')." ".$letras." A&Ntilde;OS DE VIDA UNIVERSITARIA</b></font>
                </td>
                <td align='center' >
                    <img src='".$directorio."css/images/sabio.jpg' width='60'>
                </td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table align='center' width = '100%'>
            <tr>
                <td align='center'>
                    <img src='".$directorio."css/images/escudo.jpg'>
                </td>
            </tr>
            <tr>
                <td align='center'>
                    Universidad Distrital Francisco Jos&eacute; de Caldas
                    <br>
                    Todos los derechos reservados.
                    <br>
                    Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300
                    <br>
                    elecciones@udistrital.edu.co                    
                </td>
            </tr>
        </table>
    </page_footer>";

    $proceso = $_REQUEST['proceso'];
    
    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    
    $cadena_sql = $this->sql->cadena_sql("idioma", '');
    $resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "accion");

    $cadena_sql = $this->sql->cadena_sql("datosProceso", $proceso);
    $resultadoProceso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    
    $contenidoPagina .= "
        <p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span style='font-size:18.0pt;mso-bidi-font-size:11.0pt;line-height:
107%'>RESUMEN DEL PROCESO ELECTORAL</span></b></p>

<p class=MsoNormal style='text-align:justify'><span style='font-size:12.0pt;
mso-bidi-font-size:11.0pt;line-height:107%'>A continuación se relaciona la información del proceso electoral ".$resultadoProceso[0]['nombre'].": </span></p>

<div align=center>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=107 valign=top style='width:80.55pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;background:#BDD6EE;mso-background-themecolor:
  accent1;mso-background-themetint:102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Nombre del proceso Electoral  </span></b></p>
  </td>
  <td width=602 valign=top style='width:451.45pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'><p>".$resultadoProceso[0]['nombre']."</p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=107 valign=top style='width:80.55pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BDD6EE;mso-background-themecolor:accent1;mso-background-themetint:
  102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Descripci&oacute;n  </span></b></p>
  </td>
  <td width=602 valign=top style='width:451.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid >
  <p class=MsoNormal align=center style='margin-bottom:0cm;
  text-align:center><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>".$resultadoProceso[0]['descripcion']."</span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=107 valign=top style='width:80.55pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BDD6EE;mso-background-themecolor:accent1;mso-background-themetint:
  102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Fecha de Inicio</span></b></p>
  </td>
  <td width=602 valign=top style='width:451.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>".$resultadoProceso[0]['fechainicio']."</span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3'>
  <td width=107 valign=top style='width:80.55pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BDD6EE;mso-background-themecolor:accent1;mso-background-themetint:
  102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Fecha de Finalizaci&oacute;n</span></b></p>
  </td>
  <td width=602 valign=top style='width:451.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>".$resultadoProceso[0]['fechafin']."</span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;mso-yfti-lastrow:yes'>
  <td width=107 valign=top style='width:80.55pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BDD6EE;mso-background-themecolor:accent1;mso-background-themetint:
  102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Tipo de Votaci&oacute;n</span></b></p>
  </td>
  <td width=602 valign=top style='width:451.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>".$resultadoProceso[0]['tipoVotacion']."</span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;mso-yfti-lastrow:yes'>
  <td width=107 valign=top style='width:80.55pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BDD6EE;mso-background-themecolor:accent1;mso-background-themetint:
  102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Cantidad de Elecciones</span></b></p>
  </td>
  <td width=602 valign=top style='width:451.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>".$resultadoProceso[0]['cantidadelecciones']."</span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;mso-yfti-lastrow:yes'>
  <td width=107 valign=top style='width:80.55pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#BDD6EE;mso-background-themecolor:accent1;mso-background-themetint:
  102;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-bottom:0cm;margin-bottom:.0001pt;line-height:
  normal'><b style='mso-bidi-font-weight:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>Acto Administrativo</span></b></p>
  </td>
  <td width=602 valign=top style='width:451.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='margin-bottom:0cm;margin-bottom:.0001pt;
  text-align:center;line-height:normal'><span style='font-size:12.0pt;
  mso-bidi-font-size:11.0pt'>".$resultadoProceso[0]['acto']."</span></p>
  </td>
 </tr>
</table>


</div>

    ";
    
    $contenidoPagina .= "</page>";
    
    $html2pdf = new HTML2PDF('L','LETTER','es');
    $res = $html2pdf->WriteHTML($contenidoPagina);
    $html2pdf->Output('resumenProceso.pdf','D');
    //$html2pdf->Output('certificado.pdf');
?>