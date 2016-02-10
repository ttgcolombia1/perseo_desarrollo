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
$this->idioma["noIncluidoCenso"] = "<p class='textoNegrita textoCentrar'>El número de identificación ".(isset($_REQUEST['idUsuario'])?$_REQUEST['idUsuario']:'').", NO se encuentra incluído en el Censo Oficial</p>";
$this->idioma["informacionNoRegistro"] = "<span class='textoNegrita textoMediano'>Usted no se encuentra en esta base de datos</span>";

//A continuación se crean los mensajes para el formulario cuando Existen datos sin permitirle la actualización de datos.
$this->idioma["incluidoCenso"] = "<p class='textoNegrita textoCentrar'>Usted se encuentra en el censo oficial.</p>";
$this->idioma["informacionRegistro"] = "<span class='textoNegrita textoMediano'>Usted se encuentra en el censo oficial</span>";
$this->idioma["yaVoto"] = "<span class='textoNegrita textoMediano'><font color='red'>Ya ejerció derecho al voto</font></span>";
$this->idioma["activo"] = "<span class='textoNegrita textoMediano'><font color='green'>Activo para votar</font></span>";
$this->idioma["inactivo"] = "<span class='textoNegrita textoMediano'><font color='red'> Inactivo para votar</font></span>";


?>