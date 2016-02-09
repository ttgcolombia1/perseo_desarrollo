<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
$rutaBloque .= $esteBloque ['grupo'] . "/" . $esteBloque ['nombre'];
$rutaImagen = $rutaBloque . '/imagenes/';

// ------------------Division-------------------------
{
	$esteCampo = 'divMenuSuperior';
	$atributos ["id"] = $esteCampo;
	$atributos ['estilo'] = $esteCampo;
	echo $this->miFormulario->division ( "inicio", $atributos );
	unset ( $atributos );
	
	// -------------Control campoTexto-----------------------
	{
	 //-------------------------------Mensaje-------------------------------------
                        $esteCampo = 'nombreUniversidad';
                        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
                        $atributos["etiqueta"] = "";
                        $atributos["estilo"] = 'jqueryui';
                        $atributos["tipo"] = '';
                        $atributos ["etiqueta"]='encabezado2';
                        $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);
                        echo $this->miFormulario->campoMensaje($atributos);
                        unset($atributos);	
	}
	// ------------------Fin Division-------------------------
	echo $this->miFormulario->division ( "fin" );
}

// ------------------Division-------------------------
{
	$esteCampo = 'divContenedor';
	$atributos ["id"] = $esteCampo;
	$atributos ['estilo'] = $esteCampo;
	echo $this->miFormulario->division ( "inicio", $atributos );
	unset ( $atributos );
        
       
        
        
	// ------------------Division-------------------------
	{
		$esteCampo = 'divTextoNombre';
		$atributos ["id"] = $esteCampo;
		$atributos ['estilo'] = $esteCampo;
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		// -------------Control cuadroTexto-----------------------
		{
			
                         //-------------------------------Mensaje-------------------------------------
                        $esteCampo = 'mensajeNombre';
                        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
                        $atributos["etiqueta"] = "";
                        $atributos["estilo"] = 'jqueryui';
                        $atributos["tipo"] = '';
                        $atributos ["etiqueta"]='simple';
                        $atributos["mensaje"] = ucwords (strtolower(trim($datosUsuario [0] ['NOMBRE'])));
                        echo $this->miFormulario->campoMensaje($atributos);
                        unset($atributos);
		}
		
		// ------------------Fin Division-------------------------
		echo $this->miFormulario->division ( "fin" );
	}
	
        /*
	// ------------------Division-------------------------
	{
		$esteCampo = 'divFoto';
		$atributos ["id"] = $esteCampo;
		$atributos ['estilo'] = $esteCampo;
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		{
			// ---------------------- Imagen -----------------------------
			$esteCampo = 'sabio';
			$atributos ['id'] = $esteCampo;
			$atributos ['estilo'] = 'mediana shadow';
			$atributos ['sinDivision'] = 'true';
			$atributos ['imagen'] = $rutaImagen . 'sabio.jpg';
			$atributos ['ancho'] = '80px';
			$atributos ['alto'] = '80px';
			echo $this->miFormulario->campoImagen ( $atributos );
			unset ( $atributos );
		}
		
		// ------------------Fin Division-------------------------
		echo $this->miFormulario->division ( "fin" );
	}
	*/
	// ------------------Fin Division-------------------------
	echo $this->miFormulario->division ( "fin" );
        
        $esteCampo = 'horaServidor';
        $atributos ['id'] = $esteCampo;
        $atributos ['tipo'] = 'hidden';
        $atributos ['valor'] = date('d M Y G:i:s');
        echo $this->miFormulario->campoCuadroTexto ( $atributos );
        
}
?>