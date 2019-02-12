<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

//El tiempo que se utiliza para agregar al nombre del campo se declara en ready.php


/**
 * Este script está incluido en el método html de la clase Frontera.class.php.
 *
 * La ruta absoluta del bloque está definida en $this->ruta
 */
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );

$nombreFormulario = sha1($esteBloque ['nombre'].$_REQUEST['tiempo']);

$valorCodificado = "action=" . $esteBloque ["nombre"];
$valorCodificado .= "&opcion=segundaIdent";
$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
$valorCodificado .= "&tiempo=" . $_REQUEST ['tiempo'];
$valorCodificado .= "&usuario=" . $_REQUEST ['usuario'];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );

$tab = 1;

// ---------------Inicio Formulario (<form>)--------------------------------
$atributos ["id"] = $nombreFormulario;
$atributos ["tipoFormulario"] = "multipart/form-data";
$atributos ["metodo"] = "POST";
$atributos ["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario ( "inicio", $atributos );

// ------------------Division-------------------------
$atributos ["id"] = "datos";
$atributos ["estilo"] = "jquery centrar ancho";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control cuadroTexto-----------------------
$esteCampo = sha1('segundaIdentificacion'.$_REQUEST['tiempo']);
$atributos ["id"] = $esteCampo;
$atributos ["etiqueta"] = "No Identificación: ";
$atributos ["anchoEtiqueta"] ='150'; //sobreescribe el ancho predeterminado que es de 120px
$atributos["estiloEtiqueta"]='textoGris';
$atributos ["titulo"] = "La segunda identificación corresponde al código o número de identificación";
$atributos ["tabIndex"] = $tab ++;
$atributos ["obligatorio"] = true;
$atributos ["tamanno"] = "25";
$atributos ["tipo"] = "";
$atributos ["estilo"] = "jqueryui";
$atributos ["validar"] = "required";

echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );


if (isset ( $_REQUEST ['mostrarMensaje'] )) {    
    
        switch($_REQUEST ['mostrarMensaje']){
            case 'usuarioNoValido':
            case 'claveNoValida':
                $atributos ["mensaje"] =$this->lenguaje->getCadena('error:loginIncorrecto');
                    break;
            case 'cerrarSesion':
                $atributos ["mensaje"] =$this->lenguaje->getCadena('mensaje:cerrarSesion');
            
            case 'sesionExpirada':
                $atributos ["mensaje"] =$this->lenguaje->getCadena('mensaje:sesionExpirada');
            
            
        }
        
        // ------------------Division para los botones-------------------------
	$atributos ['id'] = 'divMensaje';
	$atributos ['estilo'] = 'marcoBotones';
	echo $this->miFormulario->division ( "inicio", $atributos );
	
	// -------------Control texto-----------------------
	$esteCampo = 'mostrarMensaje';
	$atributos ["tamanno"] = '';
	$atributos ["estilo"] = 'errorLogin';
	$atributos ["etiqueta"] = '';
	$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
	echo $this->miFormulario->campoMensaje ( $atributos );
	unset ( $atributos );
	
	// ------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division ( "fin" ); 
}       
    



// ------------------Division para los botones-------------------------
$atributos ["id"] = "botones";
$atributos ["estilo"] = "marcoBotones";
echo $this->miFormulario->division ( "inicio", $atributos );

// -------------Control Boton-----------------------
$esteCampo = "botonAceptar";
$atributos ["id"] = $esteCampo;
$atributos ["tabIndex"] = $tab ++;
$atributos ["tipo"] = "boton";
$atributos ['submit'] = true; //No se coloca si se desea un tipo button
$atributos ["estilo"] = "";
$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
$atributos ["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton ( $atributos );
unset ( $atributos );
// -------------Fin Control Boton----------------------

// ------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division ( "fin" );

// -------------Control texto-----------------------
$esteCampo = 'mostrarMensaje';
$atributos ["id"] = $esteCampo;
$atributos ["estilo"] = '';
$atributos ["tipo"]='message';
$atributos ["mensaje"] =$this->lenguaje->getCadena('mensaje:datosEsperadosEstudiante');
echo $this->miFormulario->cuadroMensaje ( $atributos );
unset ( $atributos );


//------------Fin división principal --------------------------------------

echo $this->miFormulario->division ( "fin" );

// -------------Control cuadroTexto con campos ocultos-----------------------
// Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos ["id"] = "formSaraData"; // No cambiar este nombre
$atributos ["tipo"] = "hidden";
$atributos ["obligatorio"] = false;
$atributos ["etiqueta"] = "";
$atributos ["valor"] = $valorCodificado;
echo $this->miFormulario->campoCuadroTexto ( $atributos );
unset ( $atributos );



// Fin del Formulario
echo $this->miFormulario->formulario ( "fin" );



?>