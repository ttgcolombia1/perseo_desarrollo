<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}	
$ruta=$this->miConfigurador->getVariableConfiguracion('raizDocumento');
include($ruta.'/classes/html2pdf/html2pdf.class.php');

//$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

$rutaCandidatos = $this->miConfigurador->getVariableConfiguracion("host");
$rutaCandidatos.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks";
$rutaCandidatos.= $this->miConfigurador->getVariableConfiguracion("rutaCandidatos");

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
                    <font size='9px'><b>1948 - ".date('Y')." ".$letras." SESENTA Y CINCO A&Ntilde;OS DE VIDA UNIVERSITARIA</b></font>
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

    $eleccion = $_REQUEST['eleccion'];
    
    $conexion = "estructura";
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    
    $cadena_sql = $this->sql->cadena_sql("idioma", '');
    $resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "accion");

    $cadena_sql = $this->sql->cadena_sql("consultaEleccionFinal", $eleccion);
    $resultadoEleccion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    $cadena_sql = $this->sql->cadena_sql("consultaCandidatosFinal", $eleccion);
    $resultadoCandidatos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
   
    $htmlCandidatos = '';
    for($i=0;$i<count($resultadoCandidatos);$i++)
    {
        $htmlCandidatos .= "<tr>";
            $htmlCandidatos .= "<td>".$resultadoCandidatos[$i][0]."</td>";
            $htmlCandidatos .= "<td>".$resultadoCandidatos[$i][1]."</td>";
            $htmlCandidatos .= "<td>".$resultadoCandidatos[$i][2]."</td>";
            $htmlCandidatos .= "<td>".$resultadoCandidatos[$i][3]."</td>";
            $htmlCandidatos .= "<td>".$resultadoCandidatos[$i][4]."</td>";
        $htmlCandidatos .= "</tr>";
    }       
    
    if($resultadoEleccion[0][8] == 1)
        { 
            $segundaClave = "Si";
        }else
            {
                $segundaClave = "No";
            }
    
    $contenidoPagina .= "
        <table>        
            <tr>
                <td>                
                <p><h5>Nombre de la Elecci&oacute;n: ".$resultadoEleccion[0][0]."<br>
                    Descripcion: ".$resultadoEleccion[0][3]."<br>
                    Tipo Estamento: ".$resultadoEleccion[0][2]."<br>
                    Fecha de Inicio: ".$resultadoEleccion[0][4]."<br>
                    Fecha de Finalizaci&oacute;n: ".$resultadoEleccion[0][5]."<br>
                    Tipo de Votaci&oacute;n: ".$resultadoEleccion[0][7]."<br>
                    Segunda Clave: ".$segundaClave."</h5></p>
                </td>
            </tr>
            <tr>                
                <td>
                    <table>
                        <tr>
                            <th>Lista</th>
                            <th>Posicion</th>
                            <th>Identificación</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                        </tr>
                        ".$htmlCandidatos."
                    </table>
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