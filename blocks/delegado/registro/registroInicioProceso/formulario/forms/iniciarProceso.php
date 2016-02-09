<?php
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
if (! $esteRecursoDB) {
	// Este se considera un error fatal
	exit ();
}

$cadena_sql = $this->sql->cadena_sql ( "buscarLlaves" );
$resultado = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
if ($resultado) {
	
	if ($resultado [0] ['parametro'] == 'public_key') {
		$ubicacionLlavePublica = $resultado [0] ['valor'];
		$ubicacionLlavePrivada = $resultado [1] ['valor'];
	} else {
		$ubicacionLlavePrivada = $resultado [0] ['valor'];
		$ubicacionLlavePublica = $resultado [1] ['valor'];
	}
	
	if (file_exists ( substr ( $ubicacionLlavePrivada, strlen ( 'file://' ) ) )) {
		
		$cadena_sql = $this->sql->cadena_sql ( "buscarProcesoCerrado", 5 );
		$registro = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
		
		if ($registro) {
			
			$valorCodificado = "action=" . $esteBloque ["nombre"];
			$valorCodificado .= "&opcion=paso2";
			$valorCodificado .= "&bloque=" . $esteBloque ["id_bloque"];
			$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
			$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
			$directorio = $this->miConfigurador->getVariableConfiguracion ( "rutaUrlBloque" );
			$tab = 1;
			$nombreFormulario = 'formAbrirProceso';
			
			// ---------------Inicio Formulario (<form>)--------------------------------
			$atributos ["id"] = $nombreFormulario;
			$atributos ["tipoFormulario"] = "multipart/form-data";
			$atributos ["metodo"] = "POST";
			$atributos ["nombreFormulario"] = $nombreFormulario;
			$verificarFormulario = "1";
			echo $this->miFormulario->formulario ( "inicio", $atributos );
			
			// -------------Control cuadroTexto-----------------------
			$esteCampo = 'abrirProceso';
			$atributos ["id"] = $esteCampo;
			$atributos ['texto'] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ["titulo"] = $this->lenguaje->getCadena ( $esteCampo . "Titulo" );
			$atributos ["tabIndex"] = $tab ++;
			$atributos ["columnas"] = '2';
			$atributos ["estilo"] = "jqueryui";
			echo $this->miFormulario->campoTexto ( $atributos );
			unset ( $atributos );
			
			// ------------------Division para los botones-------------------------
			$atributos ["id"] = "botones";
			$atributos ["estilo"] = "marcoBotones";
			echo $this->miFormulario->division ( "inicio", $atributos );
			
			// -------------Control Boton-----------------------
			$esteCampo = "botonAbrirProceso";
			$atributos ["id"] = $esteCampo;
			$atributos ["tabIndex"] = $tab ++;
			$atributos ["tipo"] = "boton";
			$atributos ["estilo"] = "jqueryui";
			$atributos ["verificar"] = ""; // Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
			$atributos ["tipoSubmit"] = "jquery"; // Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
			$atributos ["valor"] = $this->lenguaje->getCadena ( $esteCampo );
			$atributos ["nombreFormulario"] = $nombreFormulario;
			echo $this->miFormulario->campoBoton ( $atributos );
			unset ( $atributos );
			// -------------Fin Control Boton----------------------
			
			// ------------------Fin Division para los botones-------------------------
			echo $this->miFormulario->division ( "fin" );
			
			// -------------Control cuadroTexto con campos ocultos-----------------------
			// Para pasar variables entre formularios o enviar datos para validar sesiones
			$esteCampo = "formSaraData"; // No cambiar este nombre
			$atributos ["id"] = $esteCampo;
			$atributos ["tipo"] = "hidden";
			$atributos ["obligatorio"] = false;
			$atributos ["etiqueta"] = "";
			$atributos ["valor"] = $valorCodificado;
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			
			// Fin del Formulario
			echo $this->miFormulario->formulario ( "fin" );
		} else {
			// -------------------------------Mensaje-------------------------------------
			$esteCampo = "aperturaRealizada";
			$atributos ["id"] = "mensaje"; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
			$atributos ["etiqueta"] = "";
			$atributos ["estilo"] = "centrar";
			$atributos ["tipo"] = "information";
			$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo, $registro );
			echo $this->miFormulario->cuadroMensaje ( $atributos );
			unset ( $atributos );
		}
	} else {
		// -------------------------------Mensaje-------------------------------------
		$esteCampo = "noExistenLlaves";
		$atributos ["id"] = "mensaje"; // Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
		$atributos ["etiqueta"] = "";
		$atributos ["estilo"] = "centrar";
		$atributos ["tipo"] = "error";
		$atributos ["mensaje"] = $this->lenguaje->getCadena ( $esteCampo, $registro );
		echo $this->miFormulario->cuadroMensaje ( $atributos );
		unset ( $atributos );
	}
}

?>