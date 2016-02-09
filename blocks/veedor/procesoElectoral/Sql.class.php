<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlProcesoElectoral extends sql {


	var $miConfigurador;


	function __construct(){
		$this->miConfigurador=Configurador::singleton();
	}


	function cadena_sql($tipo,$variable="") {
			
		/**
		 * 1. Revisar las variables para evitar SQL Injection
		 *
		 */

		$prefijo=$this->miConfigurador->getVariableConfiguracion("prefijo");
		$idSesion=$this->miConfigurador->getVariableConfiguracion("id_sesion");
			
		switch($tipo) {

			
                            
			case "dependencias":

				$cadena_sql = "SELECT id_dependencia, nombre ";
                                $cadena_sql .= "FROM ".$prefijo."dependencias ";
                                $cadena_sql .= "ORDER BY id_dependencia";
			break;
                    
			case "tipovotacion":

				$cadena_sql = "SELECT idtipo, descripcion ";
                                $cadena_sql .= "FROM ".$prefijo."tipovotacion ";
                                $cadena_sql .= "ORDER BY idtipo";
			break;
                    
                        case "actoadministrativo":

				$cadena_sql = "SELECT idacto, descripcion ";
                                $cadena_sql .= "FROM ".$prefijo."actoadministrativo ";
                                $cadena_sql .= "ORDER BY idacto";
			break;
                    
                        case "insertarProceso":
                            
				$cadena_sql = "INSERT INTO ".$prefijo."procesoelectoral VALUES ( ";
                                $cadena_sql .= "'', ";
                                $cadena_sql .= "'".$variable[0]."', ";
                                $cadena_sql .= "'".$variable[1]."', ";
                                $cadena_sql .= "'".$variable[2]."', ";
                                $cadena_sql .= "'".$variable[3]."', ";
                                $cadena_sql .= "1, ";
                                $cadena_sql .= "".$variable[7].", ";
                                $cadena_sql .= "'".$variable[8]."', ";
                                $cadena_sql .= "'".$variable[4]."', ";
                                $cadena_sql .= "".$variable[5].", ";
                                $cadena_sql .= "'".$variable[6]."', ";
                                $cadena_sql .= "".$variable[9].") ";
			break;
				/**
				 * Clausulas genéricas. se espera que estén en todos los formularios
				 * que utilicen esta plantilla
				 */

			case "iniciarTransaccion":
				$cadena_sql="START TRANSACTION";
				break;

			case "finalizarTransaccion":
				$cadena_sql="COMMIT";
				break;

			case "cancelarTransaccion":
				$cadena_sql="ROLLBACK";
				break;


			case "eliminarTemp":

				$cadena_sql="DELETE ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion = '".$variable."' ";
				break;

			case "insertarTemp":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="( ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.=") ";
				$cadena_sql.="VALUES ";

				foreach($_REQUEST as $clave => $valor) {
					$cadena_sql.="( ";
					$cadena_sql.="'".$idSesion."', ";
					$cadena_sql.="'".$variable['formulario']."', ";
					$cadena_sql.="'".$clave."', ";
					$cadena_sql.="'".$valor."', ";
					$cadena_sql.="'".$variable['fecha']."' ";
					$cadena_sql.="),";
				}

				$cadena_sql=substr($cadena_sql,0,(strlen($cadena_sql)-1));
				break;

			case "rescatarTemp":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_sesion, ";
				$cadena_sql.="formulario, ";
				$cadena_sql.="campo, ";
				$cadena_sql.="valor, ";
				$cadena_sql.="fecha ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tempFormulario ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_sesion='".$idSesion."'";
				break;



		}
		return $cadena_sql;

	}
}
?>
