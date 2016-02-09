<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqladminEleccionesVotante extends sql {

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
			
			case 'buscarEleccionesVotante' :
				
				$hoy= "'".date("Y-m-d", time())." 00:00:00'";
				
				$cadena_sql = 'SELECT ';
				$cadena_sql .= $prefijo . 'censo.identificacion as id_usuario, ';
				$cadena_sql .= $prefijo . 'censo.ideleccion, ';
				$cadena_sql .= $prefijo . 'censo.clave, ';
				$cadena_sql .= $prefijo . 'censo.nombre AS nombrevotante, ';
				$cadena_sql .= $prefijo . 'censo.idtipo, ';
				$cadena_sql .= $prefijo . 'censo.fechavoto, ';
				$cadena_sql .= $prefijo . 'censo.datovoto, ';
				$cadena_sql .= $prefijo . 'eleccion.nombre, ';
				$cadena_sql .= $prefijo . 'eleccion.fechainicio, ';
				$cadena_sql .= $prefijo . 'eleccion.fechafin, ';
				$cadena_sql .= $prefijo . 'eleccion.estado, ';
				$cadena_sql .= $prefijo . 'eleccion.candidatostarjeton, ';
				$cadena_sql .= $prefijo . 'eleccion.utilizarsegundaclave ';
				$cadena_sql .= 'FROM ';
				$cadena_sql .= $prefijo . 'censo, ';
				$cadena_sql .= $prefijo . 'eleccion ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= $prefijo . "censo.identificacion = '" . trim ( $variable ) . "' ";
				$cadena_sql .= 'AND ';
				$cadena_sql .= $prefijo . 'censo.ideleccion =' . $prefijo . 'eleccion.ideleccion ';
				$cadena_sql .= 'AND ';
				$cadena_sql .= $prefijo . 'eleccion.estado=1 ';
				$cadena_sql .= 'AND ';
				$cadena_sql .= $prefijo . 'eleccion.fechainicio>'.$hoy.' ';
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
