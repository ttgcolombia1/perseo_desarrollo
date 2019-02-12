<?php
$this->idioma["marcoConsulta"]="Ingrese su número de documento";
$this->idioma["idUsuario"]="Número de Identificación";
$this->idioma["idUsuarioTitulo"]="Número de Identificación del usuario que desea consultar en el censo.";

$this->idioma["botonAceptar"]="Consultar";
$this->idioma["botonCancelar"]="Cancelar";
$this->idioma["mensaje1"] = "Consultar Votante en el Censo Electoral";
$this->idioma["mensaje2"] = "Actualización de datos";
$this->idioma["datosUsuario"] = "Por favor ingrese número de identificación a consultar";

//Información requerida solo si la consulta del censo.
$this->idioma["botonGuardar"] = "Guardar";
$this->idioma["botonVolver"] = "Volver";
$this->idioma["botonClave"] = "Generar Contraseña";

//A continuación se crean los mensajes para el formulario cuando no existen datos.
$fechas = explode("-", $this->miConfigurador->getVariableConfiguracion("max_fecha_reclamacion"));
$meses = array(" ","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha1= date("d ",strtotime($fechas[0]))." de ".$meses[date('n',strtotime($fechas[0]))]." del ".date("Y",strtotime($fechas[0]));
$fecha2= date("d ",strtotime($fechas[1]))." de ".$meses[date('n',strtotime($fechas[1]))]." del ".date("Y",strtotime($fechas[1]));

$this->idioma["noIncluidoCenso"] = "<br><p class='textoNegrita textoCentrar'>El número de identificación ".(isset($_REQUEST['idUsuario'])?$_REQUEST['idUsuario']:'').",<br> NO se encuentra incluído en el Censo Oficial</p><br>";
//$this->idioma["noIncluidoCenso"].= "<p class='textoNegrita textoCentrar'>Conforme a lo establecido en el calendario electoral, usted tuvo desde el ".$fecha1." hasta el ".$fecha2.", para verificar su estado y solicitar a través del correo elecciones@udistrital.edu.co los ajustes correspondientes.</p>";
$this->idioma["informacionNoRegistro"] = "<span class='textoNegrita textoMediano'>Usted no se encuentra en esta base de datos</span>";
$this->idioma["noContrasena"] = "<p class='textoNegrita textoCentrar'>No fué posible generar la contraseña para el usuario ".(isset($_REQUEST['idUsuario'])?$_REQUEST['idUsuario']:'').", Por favor intente más tarde</p>";

//A continuación se crean los mensajes para el formulario cuando Existen datos sin permitirle la actualización de datos.
$this->idioma["incluidoCenso"] = "<p class='textoNegrita textoCentrar'>Usted se encuentra en el censo oficial.</p>";
$this->idioma["informacionRegistro"] = "<span class='textoNegrita textoMediano'>Usted se encuentra en el censo oficial</span>";
$this->idioma["yaVoto"] = "<span class='textoNegrita textoMediano'><font color='red'>Ya ejerció derecho al voto</font></span>";
$this->idioma["activo"] = "<span class='textoNegrita textoMediano'><font color='green'>Activo para votar</font></span>";
$this->idioma["inactivo"] = "<span class='textoNegrita textoMediano'><font color='red'> Inactivo para votar</font></span>";
?>