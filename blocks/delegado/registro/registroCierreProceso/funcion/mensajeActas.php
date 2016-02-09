<?php


/****************************************************************************************/
setlocale(LC_ALL,"es_ES");
$fecha=strftime("%A %d de %B del %Y");
$hora = date("g:i a");
/****************************************************************************************/



$indice=0;
$parrafo[0]="En Bogotá D.C., a los quince (15) días del mes de agosto de 2013, mediante el 
sistema de voto electrónico y de urna y tarjetón virtual en la modalidad no presencial; siendo las ".$hora.", 
se llevo a cabo la jornada de votación, conforme a lo determinado en la Normatividad Electoral establecida para estos 
procesos electorales, CIERRAN la votación y de inmediato se procede a realizar el escrutinio ante los testigos electorales acreditados, 
con los siguientes resultados:";



if(isset($_REQUEST['observacion']) && $_REQUEST['observacion']!=''){

	$parrafo[$indice++]=utf8_decode("Luego de deliberar, los presentes deciden consignar en el acta las siguientes observaciones:");
	
	$parrafo[$indice]=$_REQUEST['observacion'];
	$noLimpiar[$indice++]=true;
	
	
}
$indice=1;
$parrafo[$indice++]="En constancia de lo anterior, siendo las ".$hora.", a los quince (15) días del mes de agosto de 2013, la presente acta se firma por quienes en ella intervinieron.";
$parrafo[$indice++]= "Jurado. Nombre: ________________________ Firma: ________________";
$parrafo[$indice++]= "Jurado. Nombre: ________________________ Firma: ________________";
$parrafo[$indice++]= "Delgado. Nombre: _______________________ Firma: ________________";
$parrafo[$indice++]= "Delgado. Nombre: _______________________ Firma: ________________";
$parrafo[$indice++]= "Secretario del Consejo Participación Universitaria Provisional";
$parrafo[$indice++]= "Nombre: ________________________________ Firma: ________________";
$parrafo[$indice++]= "Delegado del Consejo Participación Universitaria Provisional";
$parrafo[$indice++]= "Nombre: ________________________________ Firma: ________________";

		






