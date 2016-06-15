<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
}	
$ruta=$this->miConfigurador->getVariableConfiguracion('raizDocumento');
include($ruta.'/classes/html2pdf/html2pdf.class.php');

//$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/";
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaBloque");

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("idioma", '');
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");  

$cadena_sql = $this->sql->cadena_sql("consultarProcesos", '');
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

for($i=0;$i<count($resultadoProcesos);$i++)
{
    
    $meses = array(" ","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

            
            
    $hora=$resultadoProcesos[$i]['horainicio'];
    $dia= $resultadoProcesos[$i]['diainicio'];
    $mes= $meses[$resultadoProcesos[$i]['mesinicio']];
    $anno= $resultadoProcesos[$i]['annoinicio'];

    $fecha = $dia.' de '.$mes.' de '.$anno;

    $parametros = array(
                        'nombre'=>$resultadoProcesos[$i]['nombre'],
                        'fecha'=>$fecha,
                        'dia'=>$dia,
                        'mes'=>$mes,
                        'anno'=>$anno,
                        'hora'=>$hora,
                        'tipo'=>'actainicio'
                        );  
    
    
}

$contenidoPagina = "<page backtop='30mm' backbottom='50mm' backleft='20mm' backright='20mm'>";
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
                    <font size='9px'><b>1948 - ".date('Y')." SESENTA Y SEIS A&Ntilde;OS DE VIDA UNIVERSITARIA</b></font>
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
                    Carrera 8 N. 40-78 Piso 1 / PBX 3238400 - 3239300
                    <br>
                    elecciones@udistrital.edu.co                    
                </td>
            </tr>
        </table>
    </page_footer>";

//$contenidoPagina .= "<page>";
    //$contenidoPagina .= $_REQUEST['textoActa0'];
    $contenidoPagina .='<h1 style="text-align: center;"><strong>ACTA DE APERTURA </strong></h1>
                    <h1 style="text-align: center;"><strong>PROCESO ELECTORAL '.strtoupper($parametros['nombre']).'</strong></h1>
                    <h2 style="text-align: justify;"><strong>ELECCI&Oacute;N DE RECTOR </strong> DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE CALDAS.</h2>
                    <h2 style="text-align: center;">'.strtoupper($parametros['fecha']).'</h2>
                    <p style="text-align: justify;">En Bogot&aacute; D.C., a los ('.strtoupper($parametros['dia']).') d&iacute;as del mes de '.strtoupper($parametros['mes']).' de '.strtoupper($parametros['anno']).', mediante el sistema de voto electr&oacute;nico y de urna y tarjet&oacute;n virtual en la modalidad no presencial; siendo las '.strtoupper($parametros['hora']).', los jurados y los delgados proceden a verificar el estado de las bases de datos del sistema y dan inicio a la jornada prevista, conforme a lo determinado en la Normatividad Electoral establecida para estos procesos electorales.</p>
                    <p style="text-align: justify;">&nbsp;</p>
                    <p style="text-align: justify;">OBSERVACIONES:</p>
                    <p style="text-align: justify;">'.$_REQUEST['textoActa'].'</p> 
                    <p style="text-align: justify;">&nbsp;</p>
                    <p style="text-align: center;"><strong>Jurado.</strong></p>
                    <p style="text-align: justify;">Nombre: ............................................................... Firma: ............................</p>
                    <p style="text-align: center;"><strong>Jurado.</strong></p>
                    <p style="text-align: justify;">Nombre: ............................................................... Firma: ............................</p>
                    <p style="text-align: center;"><strong>Delgado.</strong></p>
                    <p style="text-align: justify;">Nombre: ............................................................... Firma:.............................</p>
                    <p style="text-align: center;"><strong>Delgado.</strong></p>
                    <p style="text-align: justify;">Nombre: ............................................................... Firma: ............................</p>
                    <p style="text-align: center;"><strong>Secretario del Consejo Participaci&oacute;n Universitaria Provisional</strong></p>
                    <p style="text-align: justify;">Nombre: ............................................................... Firma: ............................</p>
                    <p style="text-align: center;"><strong>Delegado del Consejo Participaci&oacute;n Universitaria Provisional</strong></p>
                    <p style="text-align: justify;">Nombre: ............................................................... Firma: ............................</p>';
$contenidoPagina .= "</page>";

//echo $contenidoPagina;
    $html2pdf = new HTML2PDF('P','LETTER','es');
    $res = $html2pdf->WriteHTML($contenidoPagina);
    $html2pdf->Output('actaInicio.pdf','D');
?>