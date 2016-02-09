<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlResultados extends sql {


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

			/**
			 * Clausulas específicas
			 */
			case "calendario":
				$cadena_sql="SELECT ";
				$cadena_sql.="fecha_inicio,fecha_fin ";
				$cadena_sql.="FROM ";
				$cadena_sql.="voto_votacion ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="id_votacion=".$variable." ";
				$cadena_sql.="AND ";
				$cadena_sql.=time()." BETWEEN fecha_inicio AND fecha_fin ";				
			break;
			
			case "votaciones":
				$cadena_sql="SELECT ";
				$cadena_sql.="id_votacion,descripcion,fecha_fin ";
				$cadena_sql.="FROM ";
				$cadena_sql.="voto_votacion ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="estado='A' ";
				$cadena_sql.="ORDER BY posicion ASC";
			break;
					
			case "resultados":
				$cadena_sql="SELECT ";
				$cadena_sql.=" id_voto, vot_votacion, vot_subvotacion, vot_plancha, vot_ip, vot_tipo_registrado ";
				$cadena_sql.="FROM ";
				$cadena_sql.="voto_voto_decodificado ";
			break;	
			
			case "resultadosDecod":
				$cadena_sql="SELECT vp.nombre, count( * ) ";
				$cadena_sql.="FROM voto_voto_decodificado vvd ";
				$cadena_sql.="JOIN voto_votacion vv ON vv.id_votacion = vvd.vot_votacion ";
				$cadena_sql.="JOIN voto_subvotacion vsv ON vsv.id_subvotacion = vvd.vot_subvotacion ";
				$cadena_sql.="JOIN voto_plancha vp ON vp.id_plancha = vvd.vot_plancha ";
				$cadena_sql.="GROUP BY 1 ";
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
