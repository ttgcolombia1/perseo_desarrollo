<?php


/****************************************************************************************/
setlocale(LC_ALL,"es_ES");
$fecha=strftime("%A %d de %B del %Y");
$hora = date("g:i a");
/****************************************************************************************/

$indice=0;
$parrafo[$indice++]="En Bogotá D.C., a los quince (15) días del mes de agosto de 2013, mediante el sistema de voto electrónico y de urna y tarjetón virtual en la modalidad no 
presencial; siendo las ".$hora.", los jurados y los delgados proceden a verificar el estado de las bases de datos del sistema y dan inicio a la jornada 
prevista, conforme a lo determinado en la Normatividad Electoral establecida para estos procesos electorales.
";

if(isset($_REQUEST['observacion']) && $_REQUEST['observacion']!=''){

	$parrafo[$indice++]=utf8_decode("OBSERVACIONES:");
	
	$parrafo[$indice]=$_REQUEST['observacion'];
	$noLimpiar[$indice++]=true;
	
	
}


$parrafo[$indice++]= "Jurado. Nombre: ________________________ Firma: ________________";
$parrafo[$indice++]= "Jurado. Nombre: ________________________ Firma: ________________";
$parrafo[$indice++]= "Delgado. Nombre: _______________________ Firma: ________________";
$parrafo[$indice++]= "Delgado. Nombre: _______________________ Firma: ________________";
$parrafo[$indice++]= "Secretario del Consejo Participación Universitaria Provisional";
$parrafo[$indice++]= "Nombre: ________________________________ Firma: ________________";
$parrafo[$indice++]= "Delegado del Consejo Participación Universitaria Provisional";
$parrafo[$indice++]= "Nombre: ________________________________ Firma: ________________";