<?php
$this->idioma["noDefinido"]='No definido';
$this->idioma["botonAceptar"]='Generar Llaves';
$this->idioma["fraseSeguridad"]='Frase de Seguridad:';
$this->idioma["fraseSeguridadTitulo"]='Frase de seguridad que se utilizará para exportar la llave a un archivo.';

$this->idioma["fraseSeguridadConfirmar"]='Confirmar frase de Seguridad:'; 
$this->idioma["fraseSeguridadConfirmarTitulo"]='Frase de seguridad que se utilizará para exportar la llave a un archivo.';


$this->idioma["nombre"]="Nombre:";
$this->idioma["botonPDF"]="Generar PDF";
$this->idioma["botonCancelar"]="Cancelar";
$this->idioma["botonGenerarActa"]="Generar Acta";
$this->idioma["mensajeApertura"]="<p class='textoCentrar'>Acta de apertura en pdf</p>";
$this->idioma["mensajeCierre"]="<p class='textoCentrar'>Acta de cierre en pdf</p>";
$this->idioma["observacion"]="Observaciones:";

$this->idioma["contadores"]='Revisar la cantidad de registros en tablas de voto.';
$this->idioma["contarVotosTitulo"]='Revisar la cantidad de registros en tablas de voto.';
$this->idioma["botonContadores"]='Verificar';
if(isset($argumentos) && is_array($argumentos)){
	
	switch($argumentos['tipo']){
		
		case 'contadores':
			$this->idioma["totalVotos"]='<table class="tablaGeneral"><tr>
			<td>Total Votos</td>
			<td>Total Log Acceso</td>
			<td>Total Datos Ingreso</td>
			<td>Total Datos Conexión</td>
			</tr>
			<tr>
			<td>'.$argumentos[0][0].'</td>
			<td>'.$argumentos[1][0].'</td>
			<td>'.$argumentos[2][0].'</td>
			<td>'.$argumentos[3][0].'</td></tr></table>';
			break;
		case 'usuariosAplicativo':
			$this->idioma["totalUsuariosAplicativo"]='<table class="tablaGeneral"><tr>
			<td>Egresados</td>
			<td>Administradores</td>
			<td>Delegados</td>
			<td>Veedores</td>
			<td>Asistentes</td>
			<td>Censo</td>
			</tr>
			<tr>
			<td>'.$argumentos[0][0].'</td>
			<td>'.$argumentos[1][0].'</td>
			<td>'.$argumentos[2][0].'</td>
			<td>'.$argumentos[3][0].'</td>
			<td>'.$argumentos[4][0].'</td>		
			<td>'.$argumentos[5][0].'</td>
			</tr></table>';
			break;
                case 'actainicio':
                    $this->idioma["textoActaInicio"]='<h1 style="text-align: center;"><strong>ACTA DE APERTURA </strong></h1>
                    <h1 style="text-align: center;"><strong>PROCESO ELECTORAL '.strtoupper($argumentos['nombre']).'</strong></h1>
                    <h2 style="text-align: justify;"><strong>ELECCI&Oacute;N DE RECTOR </strong> DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE CALDAS.</h2>
                    <h2 style="text-align: center;">'.strtoupper($argumentos['fecha']).'</h2>
                    <p style="text-align: justify;">En Bogot&aacute; D.C., a los ('.strtoupper($argumentos['dia']).') d&iacute;as del mes de '.strtoupper($argumentos['mes']).' de '.strtoupper($argumentos['anno']).', mediante el sistema de voto electr&oacute;nico y de urna y tarjet&oacute;n virtual en la modalidad no presencial; siendo las '.strtoupper($argumentos['hora']).', los jurados y los delgados proceden a verificar el estado de las bases de datos del sistema y dan inicio a la jornada prevista, conforme a lo determinado en la Normatividad Electoral establecida para estos procesos electorales.</p>
                    <p style="text-align: justify;">&nbsp;</p>
                    <p style="text-align: justify;">OBSERVACIONES:</p>
                    <p style="text-align: justify;">fdsfafsafsfdsfdsafdsfasf</p>
                    <p style="text-align: justify;">.....................................................</p>
                    <p style="text-align: justify;">.....................................................</p>
                    <p style="text-align: justify;">.....................................................</p>
                    <p style="text-align: justify;">.....................................................</p>
                    <p style="text-align: justify;">.....................................................</p>
                    <p style="text-align: justify;">.....................................................</p>
                    <p style="text-align: justify;">&nbsp;</p>
                    <p style="text-align: center;"><strong>Jurado.</strong></p>
                    <p style="text-align: justify;">Nombre: ................................. Firma: ................</p>
                    <p style="text-align: center;"><strong>Jurado.</strong></p>
                    <p style="text-align: justify;">Nombre: ................................. Firma: ................</p>
                    <p style="text-align: center;"><strong>Delgado.</strong></p>
                    <p style="text-align: justify;">Nombre: ................................. Firma:.................</p>
                    <p style="text-align: center;"><strong>Delgado.</strong></p>
                    <p style="text-align: justify;">Nombre: ................................. Firma: ................</p>
                    <p style="text-align: center;"><strong>Secretario del Consejo Participaci&oacute;n Universitaria Provisional</strong></p>
                    <p style="text-align: justify;">Nombre: ................................. Firma: ................</p>
                    <p style="text-align: center;"><strong>Delegado del Consejo Participaci&oacute;n Universitaria Provisional</strong></p>
                    <p style="text-align: justify;">Nombre: ................................. Firma: ................</p>';

                    break;
			
	}
	
	
	
	
}


$this->idioma["usuariosAplicativo"]='Inventario de usuarios en el aplicativo.';
$this->idioma["contarVotosTitulo"]='Realizar un inventario de los usuarios del aplicativo.';
$this->idioma["botonUsuariosAplicativo"]='Verificar';

$this->idioma["aperturaRealizada"]="El proceso está abierto.";

$this->idioma["procesoAbiertoLlaves"]="Imposible generar llaves. El proceso de votación está abierto.";
$this->idioma["existenLlaves"]="Ya existen llaves generadas, para generar nuevas llaves es necesario que no existan registros de votos realizados";
$this->idioma["formatoLlaves"]='Tenga en cuenta que la frase de seguridad debe contener :<br>';
$this->idioma["formatoLlaves"].='<p style="text-align: justify;">';
$this->idioma["formatoLlaves"].='* Mínimo 8 caracteres<br>';
$this->idioma["formatoLlaves"].='* Máximo 16 caracteres<br>';
$this->idioma["formatoLlaves"].='* Al menos 2 caracteres alfanuméricos<br>';
$this->idioma["formatoLlaves"].='* Al menos 1 caracter alfanumérico en Mayúscula<br>';
$this->idioma["formatoLlaves"].='* Al menos 2 caracteres numéricos<br>';
//$this->idioma["formatoLlaves"].='* Al menos 1 de los siguientes caracteres especiales:  ! # $ % & @ * + - _ = ?';
$this->idioma["formatoLlaves"].='</p>';

$this->idioma["existenVotos"]="Existen datos de votos registrados, no se puede generar una nueva llave";


$this->idioma["abrirProceso"]='Abrir el proceso de participación.';
$this->idioma["abrirProcesoTitulo"]='Abrir el proceso de participación.';
$this->idioma["botonAbrirProceso"]='Abrir';

$this->idioma["usuariosAplicativo"]="Revisar usuarios activos";
$this->idioma["noExistenLlaves"]="Imposible iniciar el proceso. No hay llaves registradas!!!";

$this->idioma["fechaInicioExpirada"]="La fecha de inicio de este proceso ya expiró!!!";
$this->idioma["llavesGeneradas"]='Llaves de seguridad creadas con éxito. ¿Se acuerda de la frase secreta?';
$this->idioma["error"]='Fallo al momento de ejecutar la acción.';

    
?>