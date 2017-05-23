<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

// Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
// en camel case precedida por la palabra sql
class SqlregistroInicioProceso extends sql {
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
			
			case "buscarFechasProceso":
				$cadena_sql = 'SELECT ';
				$cadena_sql.='idprocesoelectoral, ';
				$cadena_sql.='fechainicio, ';
				$cadena_sql.='fechafin ';
				$cadena_sql.='FROM ';
				$cadena_sql.=$prefijo.'procesoelectoral';
				break;
			
			case "buscarLlaves":
				$cadena_sql = 'SELECT ';
				$cadena_sql.='parametro, ';
				$cadena_sql.='valor ';
				$cadena_sql.='FROM ';
				$cadena_sql.=$prefijo.'configuracion ';
				$cadena_sql.='WHERE ';
				$cadena_sql.='parametro = "public_key" ';
				$cadena_sql.='OR ';
				$cadena_sql.='parametro = "private_key" ';
				break;
                            
			case "buscarLlavesRuta":
				$cadena_sql = 'SELECT ';
				$cadena_sql.='parametro, ';
				$cadena_sql.='valor ';
				$cadena_sql.='FROM ';
				$cadena_sql.=$prefijo.'configuracion ';
				$cadena_sql.='WHERE ';
				$cadena_sql.='parametro = "public_key" ';
				$cadena_sql.='OR ';
				$cadena_sql.='parametro = "private_key" ';
				break;
                            
			case "buscarLlavesArchivo":
				$cadena_sql = 'SELECT ';
				$cadena_sql.='tipollave, ';
				$cadena_sql.='nombrellave ';
				$cadena_sql.='FROM ';
				$cadena_sql.=$prefijo.'llave_seguridad ';
				$cadena_sql.='WHERE ';
				$cadena_sql.='idproceso = '.$variable;
				$cadena_sql.=' ORDER BY tipollave ';
				break;
			
			case "abrirProceso" :
				$cadena_sql = "UPDATE ";
				$cadena_sql .= $prefijo."procesoelectoral ";
				$cadena_sql .= "SET ";
				$cadena_sql .= 'estado=1 ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= 'idprocesoelectoral=' . $variable;
				break;
			
			case "buscarProcesoCerrado" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "* ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo."procesoelectoral ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= 'estado=0 ';
				$cadena_sql .= "AND ";
				$cadena_sql .= 'idprocesoelectoral=' . $variable;
				break;
				
			case "buscarProcesoAbierto" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "* ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo."procesoelectoral ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= 'estado="A" ';
				break;
			
			case "buscarContadores" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= 'voto_voto_codificado ';
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= 'voto_logControlAcceso ';
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= 'voto_dato_voto ';
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= 'voto_dato_ingreso ';
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= 'voto_dato_conexion ';
				
				
				break;
			
			case "buscarUsuariosAplicativo" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . 'usuario ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "tipo= 1 ";
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . 'usuario ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "tipo= 2 ";
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . 'usuario ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "tipo= 3 ";
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . 'usuario ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "tipo= 4 ";
				
				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . 'usuario ';
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "tipo= 5 ";
				

				$cadena_sql .= "UNION ALL ";
				$cadena_sql .= "SELECT ";
				$cadena_sql .= "COUNT(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= 'voto_registrado ';
				$cadena_sql .= 'WHERE ';
				$cadena_sql .= 'activo_censo="A" ';
				
				break;
                            
                        case "buscarVotos" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "* ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo."votocodificado ";
				break; 
                            
                        case "buscarVotosProceso" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "count(*) ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo."votocodificado vc ";
				$cadena_sql .= " JOIN ".$prefijo."eleccion el ON el.ideleccion = vc.ideleccion ";
				$cadena_sql .= " WHERE el.procesoelectoral_idprocesoelectoral = ".$variable;
				break;   
                            
                        case "validarLlave":

				$cadena_sql = "SELECT * FROM ".$prefijo."llave_seguridad WHERE idproceso = ".$variable;
			break; 
                    
                        case "guardarLlavePublica":

				$cadena_sql = "INSERT INTO ".$prefijo."llave_seguridad ";
				$cadena_sql .= " VALUES((SELECT MAX(llave.idllave)+1 FROM evoto_llave_seguridad llave),";
                                $cadena_sql .= " ".$variable.",'1','llavePublica".$variable.".pem')";
			break;
                    
                        case "guardarLlavePrivada":

				$cadena_sql = "INSERT INTO ".$prefijo."llave_seguridad ";
				$cadena_sql .= " VALUES((SELECT MAX(llave.idllave)+1 FROM evoto_llave_seguridad llave),";
                                $cadena_sql .= " ".$variable.",'2','llave".$variable.".pem')";
                                
			break;
                        
                        case "idioma":

				$cadena_sql = "SET lc_time_names = 'es_ES' ";
			break;    
			
                        case "consultarProcesos":
                            
				$cadena_sql = "SELECT DISTINCT nombre, ".$prefijo."procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, ".$prefijo."tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
				$cadena_sql .= "CONCAT(".$prefijo."actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto, DATE_FORMAT(fechainicio,'%d') as diainicio, DATE_FORMAT(fechainicio,'%c') as mesinicio, DATE_FORMAT(fechainicio,'%Y') as annoinicio, DATE_FORMAT(fechainicio,'%r') as horainicio  ";
                                $cadena_sql .= ",idprocesoelectoral ";
                                $cadena_sql .= "FROM ".$prefijo."procesoelectoral ";
                                $cadena_sql .= "JOIN ".$prefijo."actoadministrativo ON ".$prefijo."procesoelectoral.tipoactoadministrativo = ".$prefijo."actoadministrativo.idacto  ";
                                $cadena_sql .= "JOIN ".$prefijo."tipovotacion ON ".$prefijo."procesoelectoral.tipovotacion = ".$prefijo."tipovotacion.idtipo  ";
                                $cadena_sql .= " WHERE  1=1 ";                                
                                
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
			
			case "eliminarTemp" :
				
				$cadena_sql = "DELETE ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_sesion = '" . $variable . "' ";
				break;
			
			case "insertarTemp" :
				$cadena_sql = "INSERT INTO ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "( ";
				$cadena_sql .= "id_sesion, ";
				$cadena_sql .= "formulario, ";
				$cadena_sql .= "campo, ";
				$cadena_sql .= "valor, ";
				$cadena_sql .= "fecha ";
				$cadena_sql .= ") ";
				$cadena_sql .= "VALUES ";
				
				foreach ( $_REQUEST as $clave => $valor ) {
					$cadena_sql .= "( ";
					$cadena_sql .= "'" . $idSesion . "', ";
					$cadena_sql .= "'" . $variable ['formulario'] . "', ";
					$cadena_sql .= "'" . $clave . "', ";
					$cadena_sql .= "'" . $valor . "', ";
					$cadena_sql .= "'" . $variable ['fecha'] . "' ";
					$cadena_sql .= "),";
				}
				
				$cadena_sql = substr ( $cadena_sql, 0, (strlen ( $cadena_sql ) - 1) );
				break;
			
			case "rescatarTemp" :
				$cadena_sql = "SELECT ";
				$cadena_sql .= "id_sesion, ";
				$cadena_sql .= "formulario, ";
				$cadena_sql .= "campo, ";
				$cadena_sql .= "valor, ";
				$cadena_sql .= "fecha ";
				$cadena_sql .= "FROM ";
				$cadena_sql .= $prefijo . "tempFormulario ";
				$cadena_sql .= "WHERE ";
				$cadena_sql .= "id_sesion='" . $idSesion . "'";
				break;
		}
		
		return $cadena_sql;
	}
}
?>
