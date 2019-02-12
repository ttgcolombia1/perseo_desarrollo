<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}	
$ruta=$this->miConfigurador->getVariableConfiguracion('raizDocumento');
include($ruta.'/classes/html2pdf/html2pdf.class.php');

$directorio=$this->miConfigurador->getVariableConfiguracion("rutaBloque");



    $usuario = $_REQUEST['usuario'];
    $eleccion = $_REQUEST['eleccion'];
    
    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    
    $cadena_sql = $this->sql->cadena_sql("idioma", '');
    $resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "accion");

    $cadena_sql = $this->sql->cadena_sql("datosVotante", $usuario);
    $resultadoVotante = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
    
    //Asigna si existe segunda identificación, sino asigna la primera
    $identificacion= ($resultadoVotante[0][2]!=' ' && $resultadoVotante[0][2]>0)?$resultadoVotante[0][2]:$resultadoVotante[0][1]; 
       
    
    $cadena_sql = $this->sql->cadena_sql("datosEleccion", $eleccion);
    $resultadoEleccion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
    
    $dias = array(" ","Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $meses = array(" ","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");


    $hora=date('h:i A');
    $dia= date('d');
    $mes= $meses[date('n')];
    $anno= date('Y');

    $fecha=$hora." del ".$dia.' de '.$mes.' de '.$anno;

$unidad=['UNO','DOS','TRES','CUATRO','CINCO','SEIS','SIETE','OCHO','NUEVE'];
$decenas=['DIEZ','VEINTE','TREINTA','CUARENTA','CINCUENTA','SESENTA','SETENTA','OCHENTA','NOVENTA'];
$annos=(date('Y')-1948);
$posdec=ceil($annos/10)-1;
$posun=($annos%10);
$letras='';
if($posdec>0 && $posun>0){$letras=$decenas[$posdec-1].'  Y ';}
elseif($posdec>0 && $posun==0){$letras=$decenas[$posdec];}

if($posun>0){$letras.=' '.$unidad[$posun-1];}
    
    
$codigoSeguridad=$this->miConfigurador->fabricaConexiones->crypto->codificar($resultadoVotante[0][0],$resultadoVotante[0][1].$fecha);
$contenidoPagina = "<page backtop='40mm' backbottom='10mm' backleft='20mm' backright='20mm'>";
$contenidoPagina .= "<page_header>
        <table align='center' style='width: 100%;'>
            <tr>
                <td align='center' >
                    <img src='".$directorio."css/images/escudo.jpg'>
                </td>
                <td align='center' >
                    <font size='18px'><b>UNIVERSIDAD DISTRITAL</b></font>
                    <br>
                    <font size='18px'><b>FRANCISCO JOSÉ DE CALDAS</b></font>
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
                    Universidad Distrital Francisco José de Caldas
                    <br>
                    Todos los derechos reservados.
                    <br>
                    Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300 Ext 1013/1016
                    <br>
                    elecciones@udistrital.edu.co<br>
                </td>
            </tr>
        </table>
    </page_footer>";    
    $contenidoPagina .= "
        <table>
            <tr>
                <td>
                <p align='center'><h1>".$resultadoEleccion[0][0]."</h1></p>
                <p align=center>El presente documento certifica que:</p>
                <p align=center><h1>".$resultadoVotante[0][0]."</h1></p>
                <p> Identificado (a) con documento No ".number_format($identificacion,0,'.','.').", participó en 
                    la elección <b>".$resultadoEleccion[0][1]."</b>, en el marco del proceso:<b> ".$resultadoEleccion[0][0]."</b>
                    que se llevó a cabo entre el ".$resultadoEleccion[0][2]." y el ".$resultadoEleccion[0][3].". </p>                    
                <p>Expedido en Bogotá, D.C, a las ".$fecha.". Cualquier inquietud o inconsistencia en la información por favor remita un correo a: </p>
                <p align='center'>
                <h5>
                    <a href='mailto:elecciones@udistrital.edu.co'>
                        elecciones@udistrital.edu.co
                    </a>
                </h5>    
                </p>                
                </td>
            </tr>
        </table>
    ";
    
    $contenidoPagina .= "</page>";
    
    $html2pdf = new HTML2PDF('L','LETTER','es');
    $res = $html2pdf->WriteHTML($contenidoPagina);
    $html2pdf->Output('certificado.pdf','D');
    //$html2pdf->Output('certificado.pdf');
?>