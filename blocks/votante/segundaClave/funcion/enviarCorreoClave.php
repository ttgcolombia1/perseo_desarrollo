<?php

include_once($this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/classes/mail/class.phpmailer.php");
include_once($this->miConfigurador->getVariableConfiguracion("raizDocumento") . "/classes/mail/class.smtp.php");

$mail = new phpmailer();
$mail->From = "condor@udistrital.edu.co";
$mail->FromName = "Sistema de egresados Universidad Distrital Francisco Jose de Caldas";
$mail->Host = "mail.udistrital.edu.co";
$mail->Mailer = "smtp";
$mail->SMTPAuth = true;
$mail->Username = "condor@udistrital.edu.co";
$mail->Password = "CondorOAS2012";
$mail->Timeout = 120;
$mail->Charset = "utf-8";
$mail->IsHTML(false);


$fecha = date("d-M-Y  h:i:s A");
$comen = "Mensaje generado automaticamente por el servidor de la Oficina Asesora de Sistemas. \n";
$comen.= "Asignación o Cambio de segunda clave.\n\n";
$comen .= "Universidad Distrital Francisco José de Caldas PBX: (057) (1) 3239300 - 3238400 Sede principal: Carrera 7 No. 40B - 53 Oficina Asesora de Sistema Ext. 1112 \n";


$sujeto = "Datos de Acceso";
$cuerpo = "Fecha de envio: " . $fecha . "\n\n";

$cuerpo.="Estimado ".$nombre.":\n\n";
$cuerpo.="Usted ha solicitado generar o actualizar la segunda clave, el proceso se ha realizado exitosamente. \n\n";
$cuerpo.="Si usted no ha solicitado esta actualización, y ha recibido este correo, por favor comuniquese inmediatamente \n";
$cuerpo.="con la oficina asesora de sistema ya que puede ser victima de plagio.\n\n";
//$cuerpo.="Usuario:        " . $usuario . "\n";
//$cuerpo.="Clave Acceso:   " . $clave . "\n\n";
//$cuerpo.="\n\nPor favor ingrese al siguiente enlace para cambiar su contraseña ó copie la dirección en su navegador.\n";
//$cuerpo.=$vinculo."\n\n";

$cuerpo.=$comen . "\n\n";

$mail->Body = $cuerpo;
$mail->Subject = $sujeto;
$mail->AddAddress($correo);

if (!$mail->Send()) {
    $mensaje = "\nLos datos se intentaron enviar al correo electronico: <b>{$correo}</b> pero el envio no fue exitoso<br/>";
} else {
    $mensaje = "\nEstos datos fueron enviados al correo electronico registrado en el sistema.<br/>";
}
$mail->ClearAllRecipients();
?>
