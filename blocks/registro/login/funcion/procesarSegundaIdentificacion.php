<?php

// $this->miConfigurador->fabricaConexiones->crypto->codificar(
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	
	// 0. Se van a utilizar conexiones a bases de datos, verificarlas antes de hace cualquier cosa:
	$conexion = "estructura";
	$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
        
        if (! $esteRecursoDB) {
		
		// Este se considera un error fatal
		exit ();
	}

        if (isset ( $_REQUEST [sha1 ( "segundaIdentificacion" . $_REQUEST ['tiempo'] )] ) ) {
		
		$variable ['usuario'] = $_REQUEST ['usuario'];
		$variable ['segIdent'] = $_REQUEST [sha1 ( "segundaIdentificacion" . $_REQUEST ['tiempo'] )];
		
		
			// Verificar que el usuario esté registrado en el sistema
			
			$cadena_sql = $this->sql->cadena_sql ( "validarSegundaIdentificacion", $variable );
			$registro = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "busqueda" );
			
			//Si no es un usuario del sistema verificar si es un votante
			if ($registro) {
                                $arreglo = array('id_usuario' => $variable ['usuario'],
                                            'sesionID' => $_REQUEST['sesionID']                                        
                                        );
				$this->funcion->redireccionar ( "indexVotante", $arreglo );				
                        }else
                            {
                                // Registrar el error por clave no válida
					$arregloLogin = array (
							'segundaIdentificacionNoValida',
							$variable ['usuario'],
							$_SERVER ['REMOTE_ADDR'],
							$_SERVER ['HTTP_USER_AGENT'] 
					);
                                        
                                        $argumento = json_encode ( $arregloLogin );
                                        $cadena_sql = $this->sql->cadena_sql ( 'registrarEvento', $argumento );
                                        $registroAccesoClave = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );

                                        // Redirigir a la página de inicio con mensaje de error en usuario/clave
                                        $this->funcion->redireccionar ( 'paginaPrincipal', $arregloLogin[0] );
                            }
			
		
	} else {
		
		// Registrar evento por no existir los controles del formulario
		$arregloLogin = array (
				'formularioErroneo',
				$_SERVER ['REMOTE_ADDR'],
				$_SERVER ['HTTP_USER_AGENT'] 
		);
                
                $argumento = json_encode ( $arregloLogin );
                $cadena_sql = $this->sql->cadena_sql ( 'registrarEvento', $argumento );
                $registroAccesoClave = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, "acceso" );

                // Redirigir a la página de inicio con mensaje de error en usuario/clave
                $this->funcion->redireccionar ( 'paginaPrincipal', $arregloLogin[0] );
	}
	
	
}
?>