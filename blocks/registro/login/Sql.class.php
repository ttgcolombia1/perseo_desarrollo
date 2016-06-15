<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlLogin extends sql {

	var $miConfigurador;

	function __construct() {

		$this->miConfigurador = Configurador::singleton ();
	
	}

	function cadena_sql($tipo, $variable = "") {

		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			
			case "buscarUsuario" :
				$cadena_sql = 'SELECT ';
				$cadena_sql .= 'id_usuario, ';
				$cadena_sql .= 'nombre, ';
				$cadena_sql .= 'apellido, ';
				$cadena_sql .= 'correo, ';
				$cadena_sql .= 'telefono, ';
				$cadena_sql .= 'imagen, ';
				$cadena_sql .= 'clave, ';
				$cadena_sql .= 'tipo, ';
				$cadena_sql .= 'estilo, ';
				$cadena_sql .= 'idioma, ';
				$cadena_sql .= 'estado ';
				$cadena_sql .= 'FROM ';
				$cadena_sql .= $prefijo . 'usuario ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_usuario = '" . trim ( $variable ["usuario"] ) . "' ";
				break;
                            
                        case "buscarSegundaIdentificacion" :
				$cadena_sql = 'SELECT ';
				$cadena_sql .= 'identificacion, ';
				$cadena_sql .= 'clave, ';
				$cadena_sql .= 'segunda_identificacion ';
				$cadena_sql .= 'FROM ';
				$cadena_sql .= $prefijo . 'censo ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "identificacion = " . trim ( $variable ["usuario"] ) . " ";
				$cadena_sql .= "AND (";
				$cadena_sql .= "segunda_identificacion != '' ";
				$cadena_sql .= "OR ";
				$cadena_sql .= "segunda_identificacion != 0 )";
				break;   
                            
                        case "validarSegundaIdentificacion" :
				$cadena_sql = 'SELECT ';
				$cadena_sql .= 'identificacion, ';
				$cadena_sql .= 'clave, ';
				$cadena_sql .= 'segunda_identificacion ';
				$cadena_sql .= 'FROM ';
				$cadena_sql .= $prefijo . 'censo ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "identificacion = " . trim ( $variable ["usuario"] ) . " ";
				$cadena_sql .= "AND ";
				$cadena_sql .= "segunda_identificacion = " . trim ( $variable ["segIdent"] ) . " ";
				break;        
			
			case "buscarVotante" :
				$cadena_sql = 'SELECT ';
				$cadena_sql .= 'identificacion as id_usuario, ';
				$cadena_sql .= 'ideleccion, ';
				$cadena_sql .= 'clave, ';
				$cadena_sql .= 'nombre, ';
				$cadena_sql .= 'idtipo ';
				$cadena_sql .= 'FROM ';
				$cadena_sql .= $prefijo . 'censo ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "identificacion = '" . trim ( $variable ['usuario'] ) . "' ";
				break; 
			
			case "registrarEvento" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "logger( ";
				$cadena_sql .= "id, ";
				$cadena_sql .= "evento, ";
				$cadena_sql .= "fecha) ";
				$cadena_sql .= "VALUES( ";
				$cadena_sql .= "NULL, ";
				$cadena_sql .= "'" . $variable . "', ";
				$cadena_sql .= "'" . time () . "') ";
				break;
			
			/**
			 * Clausulas genéricas.
			 * se espera que estén en todos los formularios
			 * que utilicen esta plantilla
			 */
			case "iniciarTransaccion" :
				$cadena_sql = "START TRANSACTION";
				break;
			
			case "finalizarTransaccion" :
				$cadena_sql = "COMMIT";
				break;
			
			case "cancelarTransaccion" :
				$cadena_sql = "ROLLBACK";
				break;
			
			
		}
		return $cadena_sql;
	
	}

}

?>
