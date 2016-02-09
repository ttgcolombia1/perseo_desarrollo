<?php

// Evitar un acceso directo a este archivo
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

// Se van a utilizar conexiones a bases de datos, verificarlas antes de hace cualquier cosa:
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );

if (! $esteRecursoDB) {
	
	// Este se considera un error fatal
	exit ();
}

// Rescatar el objeto de sesión
$miSesion = Sesion::singleton ();

// 1. Buscar las elecciones presentes o futuras en las que este inscrito el votante

$cadena_sql = $this->sql->cadena_sql ( 'buscarEleccionesVotante', $miSesion->getSesionUsuarioId () );

$registro = $esteRecursoDB->ejecutarAcceso ( $cadena_sql, 'busqueda' );

if ($registro) {
	
	// 2. Recorrer el arreglo registro y crear las divisiones correspondientes a cada elección
	
	foreach ( $registro as $indice => $eleccion ) {
		// Para este bloque es necesario crear las reglas dinámicamente:
		{
			$reglasCSS = "<style>
					div.divEleccion" . $indice . "{
		
					border:1px solid #AAAAAA;
					width:90%;
					margin:0 auto;
					padding:25px;	
                                        font-size: 15px;
						
				}						
						
				a.textoVoto" . $indice . "{
						
					width:50%;
					margin:10px auto;
					padding:10px;
					text-align:center;			
						
				}								
				div.divEleccion" . $indice . ":hover{
						
					background-color:#D9E6F7;
				}
						</style>";
			
			$js = "<script>
					$(function() {
						$('#divEleccion" . $indice . "').hover(function() {
						$('.textoVoto" . $indice . "').slideDown();
						},function() {
						$('.textoVoto" . $indice . "').slideUp();
						});					
					});
					</script>";
			
			echo $reglasCSS;
			// echo $js;
		}
		// ------------------Division-------------------------
		{
			$esteCampo = 'divEleccion' . $indice;
			$atributos ["id"] = $esteCampo;
			$atributos ['estilo'] = $esteCampo;
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			// -------------Control campoTexto-----------------------
			{
				//var_dump ( $eleccion );
				$esteCampo = 'texto' . $indice;
				$atributos ['id'] = $esteCampo;
				$atributos ['estilo'] = $esteCampo;
				// Armar el contenido:
				$contenido = '<span class="textoGrande textoNegrita">' . $eleccion ['nombre'] . '</span><br>';
				$contenido .= 'Fecha y hora de inicio: ' . $eleccion ['fechainicio'] . '<br>';
				$contenido .= 'Fecha y hora de cierre: ' . $eleccion ['fechafin'] . '<br>';
				$contenido .= 'Esta elección tiene ' . $eleccion ['candidatostarjeton'] . ' listas inscritas.<br>';
				if ($eleccion ['utilizarsegundaclave'] == 1) {
					$contenido .= '<span class="textoNegrita">Para participar requiere segunda clave</span>';
				}
				
				$atributos ['texto'] = $contenido;
				echo $this->miFormulario->campoTexto ( $atributos );
				unset ( $atributos );
			}
			
			
			// ------------------Fin Division-------------------------
			echo $this->miFormulario->division ( "fin" );
		}
	}
} else {
	
	// Notificar que no está inscrito en ningún proceso presente ni futuro
}



