<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlConsultaProceso extends sql {


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
			case "usuarioAcceso":

				$cadena_sql="SELECT ";
                                $cadena_sql.="DATE_FORMAT(from_unixtime(fecha),'%Y %m %d'), ";
                                $cadena_sql.="DATE_FORMAT(from_unixtime(fecha),'%H'), ";
                                $cadena_sql.="DATE_FORMAT(from_unixtime(fecha),'%l %p') , ";
				$cadena_sql.="COUNT(*) ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."logger ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="evento like '%autenticacionExitosa%' ";
                                $cadena_sql.="AND fecha > ".strtotime(date('Ymd'))." ";
				$cadena_sql.="group by 2 ";
				$cadena_sql.="order by 1,2 ";
				break;
                        case 'zonaHoraria':
                            $cadena_sql="SET time_zone='-5:00'";
                            break;

			case "usuarioNoExiste":

				$cadena_sql="SELECT DATE_FORMAT(from_unixtime(fecha),'%Y %m %d'),DATE_FORMAT(from_unixtime(fecha),'%H'), DATE_FORMAT(from_unixtime(fecha),'%l %p') , ";
				$cadena_sql.="COUNT(*) ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."logger ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="(evento like '%usuarioNoValido%' ";
                                $cadena_sql.="OR evento like '%inexistente%') ";
                                $cadena_sql.="AND fecha > ".strtotime(date('Ymd'))." ";
				$cadena_sql.="group by 2 ";
				$cadena_sql.="order by 1,2 ";

				break;

			case "usuarioClave":

				$cadena_sql="SELECT DATE_FORMAT(from_unixtime(fecha),'%Y %m %d'),DATE_FORMAT(from_unixtime(fecha),'%H'), DATE_FORMAT(from_unixtime(fecha),'%l %p') , ";
				$cadena_sql.="COUNT(*) ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."logger ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="evento like '%claveNoValida%' ";
                                $cadena_sql.="AND fecha > ".strtotime(date('Ymd'))." ";
				$cadena_sql.="group by 2 ";
				$cadena_sql.="order by 1,2 ";

				break;

			case "certificadosGenerados":

				$cadena_sql="SELECT DATE_FORMAT(from_unixtime(fecha),'%Y %m %d'),DATE_FORMAT(from_unixtime(fecha),'%H'), DATE_FORMAT(from_unixtime(fecha),'%l %p') , ";
				$cadena_sql.="COUNT(*) ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."logger ";
				$cadena_sql.="WHERE ";
				$cadena_sql.="evento like '%certificadoGenerado%' ";
                                $cadena_sql.="AND fecha > ".strtotime(date('Ymd'))." ";
				$cadena_sql.="group by 2 ";
				$cadena_sql.="order by 1,2 ";

				break;

			case "totalVotaciones":
				$cadena_sql="SELECT DATE_FORMAT(from_unixtime(fecha),'%Y %m %d'),DATE_FORMAT(from_unixtime(fecha),'%H'), DATE_FORMAT(from_unixtime(fecha),'%l %p') , ";
				$cadena_sql.="COUNT(*) ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."datovoto ";
                                $cadena_sql.="WHERE fecha > ".strtotime(date('Ymd'))." ";
				$cadena_sql.="group by 2 ";
				$cadena_sql.="order by 1,2 ";
				break;

			case "totalVotantes":
					$cadena_sql="SELECT ";
					$cadena_sql.="'Votantes' as tipo, ";
                                        $cadena_sql.="count(DISTINCT idusuario) as conteo ";
					$cadena_sql.="FROM ";
					$cadena_sql.=$prefijo."datovoto";
					$cadena_sql.=" UNION ";
					$cadena_sql.="SELECT ";
                                        $cadena_sql.="'Censo' as tipo, ";
					$cadena_sql.="count(DISTINCT identificacion) conteo ";
					$cadena_sql.="FROM ";
					$cadena_sql.=$prefijo."censo";
					break;


                        case "totalPorEstamento":
                                        $cadena_sql="select count(*) as conteo, et.descripcion ";
                                        $cadena_sql.="FROM ";
                                        $cadena_sql.=$prefijo."votocodificado";
                                        $cadena_sql.=" as ev, ".$prefijo."tipoestamento as et ";
                                        $cadena_sql.="where et.idtipo = ev.estamento group by ev.estamento";
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
