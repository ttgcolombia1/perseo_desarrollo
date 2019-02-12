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
                    <font size='18px'><b>FRANCISCO JOS&Eacute; DE CALDAS OTR</b></font>
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
        <table>
            <tr>
                <td>
                <p><h5>Nombre del proceso Electoral: ".$resultadoProceso[0]['nombre']."</h5></p>
                <p><h5>Descripci&oacute;n: ".$resultadoProceso[0]['descripcion']."</h5></p> 
                <p><h5>Fecha de Inicio: ".$resultadoProceso[0]['fechainicio']."</h5></p>
                <p><h5>Fecha de Finalizaci&oacute;n: ".$resultadoProceso[0]['fechafin']."</h5></p>
                <p><h5>Tipo de Votaci&oacute;n: ".$resultadoProceso[0]['tipoVotacion']."</h5></p>
                <p><h5>Cantidad de Elecciones: ".$resultadoProceso[0]['cantidadelecciones']."</h5></p>
                <p><h5>Acto Administrativo: ".$resultadoProceso[0]['acto']."</h5></p>
                </td>
            </tr>
        </table>
    ";
    
    $contenidoPagina .= "</page>";
    
    $html2pdf = new HTML2PDF('P','LETTER','es');
    $res = $html2pdf->WriteHTML($contenidoPagina);
    $html2pdf->Output('resumenProceso.pdf','D');
    //$html2pdf->Output('certificado.pdf');
?>