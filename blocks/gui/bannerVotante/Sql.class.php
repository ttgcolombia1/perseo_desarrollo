<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlbannerVotante extends sql {

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
			
			case "datosUsuario" :
				$cadena_sql = 'SELECT ';
				$cadena_sql .= 'identificacion as ID, ';
				$cadena_sql .= 'ideleccion, ';
				$cadena_sql .= 'clave, ';
				$cadena_sql .= 'nombre as NOMBRE, ';
				$cadena_sql .= 'idtipo ';
				$cadena_sql .= 'FROM ';
				$cadena_sql .= $prefijo . 'censo ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "identificacion = '" . trim ( $variable ) . "' ";				
				break;
			
			case "datosCompletos" :
				$cadena_sql = " SELECT";
				$cadena_sql .= " acep_termi_tele,";
				$cadena_sql .= " acep_termi_celu,";
				$cadena_sql .= " acep_termi_direccion,";
				$cadena_sql .= " correo,";
				$cadena_sql .= " imagenBlob";
				$cadena_sql .= " FROM " . $prefijo . "usuario";
				$cadena_sql .= " WHERE id_usuario='" . $variable . "' ";
				break;
		}
		
		return $cadena_sql;
	
	}

}

?>
