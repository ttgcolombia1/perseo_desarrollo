<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlregistroCierreProceso extends sql {


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
                        case "idioma":

				$cadena_sql = "SET lc_time_names = 'es_CO' ";
			break;
                    
                        case "tiporesultados":
                            
				$cadena_sql = "SELECT ideleccion, tiporesultado, porcEstudiante, porcDocente, porcEgresado, porcFuncionario, porcDocenteVinEspecial";
                                $cadena_sql .= " FROM ".$prefijo."eleccion ";
                                $cadena_sql .= " WHERE  ideleccion = ".$variable;                                
                                
			break;
                    
                        case "consultarProcesos":
                            
				$cadena_sql = "SELECT DISTINCT nombre, ".$prefijo."procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, ".$prefijo."tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
				$cadena_sql .= "CONCAT(".$prefijo."actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto  ";
                                $cadena_sql .= ",idprocesoelectoral ";
                                $cadena_sql .= "FROM ".$prefijo."procesoelectoral ";
                                $cadena_sql .= "JOIN ".$prefijo."actoadministrativo ON ".$prefijo."procesoelectoral.tipoactoadministrativo = ".$prefijo."actoadministrativo.idacto  ";
                                $cadena_sql .= "JOIN ".$prefijo."tipovotacion ON ".$prefijo."procesoelectoral.tipovotacion = ".$prefijo."tipovotacion.idtipo  ";
                                $cadena_sql .= " WHERE  1=1 ";                                
                                
			break;
                    
                        case "eleccionesProceso":
                            
				$cadena_sql = "SELECT DISTINCT ideleccion, nombre, descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, fechainicio as fechainiciobd, fechafin as fechafinbd ";
                                $cadena_sql .= "FROM ".$prefijo."eleccion ";
                                $cadena_sql .= " WHERE  procesoelectoral_idprocesoelectoral = ".$variable;                                
                                
			break;
                    
                        case "eleccionesProcesoIdEleccion":
                            
				$cadena_sql = "SELECT DISTINCT PE.nombre AS nombreProceso, ideleccion, EL.nombre AS nombreEleccion, EL.descripcion, DATE_FORMAT(EL.fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(EL.fechafin,'%d de %M de %Y %r')  as fechafin,  ";
				$cadena_sql .= " EL.fechainicio as fechainiciobd, EL.fechafin as fechafinbd, DATE_FORMAT(EL.fechafin,'%r') as horafin, DATE_FORMAT(EL.fechafin,'%d') as diafin, DATE_FORMAT(EL.fechafin,'%c') as mesfin, DATE_FORMAT(EL.fechafin,'%Y') as anniofin ";
                                $cadena_sql .= "FROM ".$prefijo."eleccion EL ";
                                $cadena_sql .= "JOIN ".$prefijo."procesoelectoral PE ON  EL.procesoelectoral_idprocesoelectoral = PE.idprocesoelectoral ";
                                $cadena_sql .= " WHERE  procesoelectoral_idprocesoelectoral = ".$variable[0];                                
                                $cadena_sql .= " AND  ideleccion = ".$variable[1];                                
                                
			break;
                        
                        case "infoElecciones":
                            
				$cadena_sql = "SELECT DISTINCT ideleccion, ";
                                $cadena_sql .= " EL.nombre AS nombreEleccion, ";
                                $cadena_sql .= " EL.descripcion, ";
                                $cadena_sql .= " DATE_FORMAT(EL.fechainicio,'%d de %M de %Y %r') as fechainicio, ";
                                $cadena_sql .= " DATE_FORMAT(EL.fechafin,'%d de %M de %Y %r')  as fechafin , ";
                                $cadena_sql .= " EL.porcEstudiante, ";
                                $cadena_sql .= " EL.porcDocente, ";
                                $cadena_sql .= " EL.porcEgresado, ";
                                $cadena_sql .= " EL.porcFuncionario, ";
                                $cadena_sql .= " EL.porcDocenteVinEspecial";
                                $cadena_sql .= " FROM ".$prefijo."eleccion EL ";
                                $cadena_sql .= " WHERE  ideleccion = ".$variable;                                
                                
			break;
                    
                        case "verificarDecodificados":
                            
				$cadena_sql = "SELECT idvoto, ideleccion, idlista, ip ";
                                $cadena_sql .= "FROM ".$prefijo."votodecodificado ";
                                $cadena_sql .= " WHERE  ideleccion = ".$variable;                                
                                
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
                       
                       case "llavePrivadaProceso":
                                $cadena_sql = " SELECT";
                                $cadena_sql.= " ll.tipollave, ";
                                $cadena_sql.= " ll.nombrellave, ";
                                $cadena_sql.= " el.procesoelectoral_idprocesoelectoral proceso,";
                                $cadena_sql.= " el.fechafin ";
                                $cadena_sql.= " FROM";
                                $cadena_sql.= " ".$prefijo."llave_seguridad ll ";
                                $cadena_sql.= " JOIN ".$prefijo."eleccion el ON ll.idproceso = el.procesoelectoral_idprocesoelectoral ";
                                $cadena_sql.= " WHERE";
                                $cadena_sql.= " ideleccion = ".$variable;
                                $cadena_sql.= " AND tipollave = 2";
                                break;     

                       case "contarVotosCodificados":
				$cadena_sql="SELECT ";
				$cadena_sql.="count(*) as total ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."votocodificado ";
				$cadena_sql.="WHERE ideleccion = ".$variable;
				break;                              
                            
                       case "contarVotosDecodificados":
				$cadena_sql="SELECT ";
				$cadena_sql.="count(*) as total ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."votodecodificado ";
				$cadena_sql.="WHERE ideleccion = ".$variable;
				break;     
                            
                       case "buscarVotos":
				$cadena_sql="SELECT ";
				$cadena_sql.="idvoto, ";
				$cadena_sql.='ideleccion,';
				$cadena_sql.='voto, ';
				$cadena_sql.='ip, ';
				$cadena_sql.='estamento ';
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."votocodificado ";
                                $cadena_sql.="WHERE ideleccion = ".$variable;
				break;     
                    
                       case "guardarVotoDecodificado":
				$cadena_sql="INSERT INTO ";
				$cadena_sql.=$prefijo.'votodecodificado';
				$cadena_sql.='(idvoto,';
				$cadena_sql.='ideleccion, ';
				$cadena_sql.='idlista, ';
				$cadena_sql.='ip, ';
				$cadena_sql.='estamento ';
				$cadena_sql.=') ';
				$cadena_sql.="VALUES( ";
				$cadena_sql.=" '', ";
				$cadena_sql.=" ".$variable[0].", ";
				$cadena_sql.=" ".$variable[1].", ";
				$cadena_sql.=" '".$variable[2]."', ";
				$cadena_sql.=" '".$variable[3]."' ";
				$cadena_sql.=")";
				break; 
                            
                           case "cerrarEleccion":
				$cadena_sql="UPDATE ";
				$cadena_sql.=$prefijo."eleccion ";
				$cadena_sql.="SET ";
				//$cadena_sql.=" fechafin = '".date('Y-m-d H:m:s')."' ";
				$cadena_sql.=" fechafin = '".$variable['fechafin']."' ";
                                $cadena_sql.=" WHERE ideleccion = ".$variable['eleccion'];
				break;   
                            
                        case "votaciones":
				$cadena_sql="SELECT ";
				$cadena_sql.=$prefijo."lista.idlista, ";
				$cadena_sql.=$prefijo."lista.nombre, ";
				$cadena_sql.='COUNT(*) ';
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."votodecodificado ";
				$cadena_sql.=" JOIN ".$prefijo."lista ON  ".$prefijo."lista.idlista = ".$prefijo."votodecodificado.idlista ";
                                $cadena_sql.="WHERE ideleccion = ".$variable;
                                $cadena_sql.=" GROUP BY 2 ";
				break; 
                            
                        case "candidatos":
				$cadena_sql="SELECT ";
				$cadena_sql.=" nombre, apellido ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."candidato ";
				$cadena_sql.="WHERE lista_idlista = ".$variable;
				$cadena_sql.=" ORDER BY reglon ";
				break;    
                            
                        case "tipoEstamentos":
				$cadena_sql="SELECT ";
				$cadena_sql.=" idtipo, descripcion, ponderado ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."tipoestamento ";
				//$cadena_sql.="WHERE ponderado > 0 ";
				$cadena_sql.=" ORDER BY idtipo ";
				break;        

                        case "votosxcandidato":
                            $cadena_sql="SELECT ";
                            $cadena_sql.="lst.idlista as lista, ";
                            $cadena_sql.="lst.nombre as nombre, ";
                            $cadena_sql.='COUNT(*) as total ';
                            $cadena_sql.="FROM ";
                            $cadena_sql.=$prefijo."votodecodificado voto ";
                            $cadena_sql.=" JOIN ".$prefijo."lista lst ON lst.idlista = voto.idlista ";
                            $cadena_sql.="WHERE voto.ideleccion = ".$variable;
                            $cadena_sql.=" GROUP BY 1,2"; 
                            break;    
                            ///Revisando
                        
                        case "votacionesPonderada":
                            $cadena_sql="SELECT ";
                            $cadena_sql.=$prefijo."lista.idlista as lista, ";
                            $cadena_sql.=$prefijo."lista.nombre as nombre, ";
                            $cadena_sql.='estamento, ';
                            $cadena_sql.='idtipo, ';
                            $cadena_sql.='COUNT(*) as cuenta, ';
                            $cadena_sql.='COUNT(*)* (ponderado/100) as ponderado ';
                            $cadena_sql.="FROM ";
                            $cadena_sql.=$prefijo."votodecodificado ";
                            $cadena_sql.=" JOIN ".$prefijo."lista ON  ".$prefijo."lista.idlista = ".$prefijo."votodecodificado.idlista ";
                            $cadena_sql.=" JOIN ".$prefijo."tipoestamento ON  ".$prefijo."votodecodificado.estamento = ".$prefijo."tipoestamento.idtipo ";
                            $cadena_sql.="WHERE ideleccion = ".$variable;
                            $cadena_sql.=" GROUP BY 1,2"; 
                            break;    
                            ///Revisando
                        
                        case "votacionesPorEstamento":
                           $cadena_sql="SELECT ";
                            $cadena_sql.=$prefijo."lista.idlista as lista, ";
                            $cadena_sql.=$prefijo."lista.nombre as nombre, ";
                            $cadena_sql.='estamento, ';
                            $cadena_sql.='idtipo, ';
                            $cadena_sql.='COUNT(*) as cuenta, ';
                            $cadena_sql.='COUNT(*)* (ponderado/100) as ponderado ';
                            $cadena_sql.="FROM ";
                            $cadena_sql.=$prefijo."votodecodificado ";
                            $cadena_sql.=" JOIN ".$prefijo."lista ON  ".$prefijo."lista.idlista = ".$prefijo."votodecodificado.idlista ";
                            $cadena_sql.=" JOIN ".$prefijo."tipoestamento ON  ".$prefijo."votodecodificado.estamento = ".$prefijo."tipoestamento.idtipo ";
                            $cadena_sql.=" WHERE ideleccion = ".$variable['ideleccion'] ;
                            $cadena_sql.=" AND idtipo = ".$variable['estamento'] ;
                            $cadena_sql.=" AND ".$prefijo."lista.idlista = ".$variable['plancha'];
                            $cadena_sql.=" GROUP BY 1,2"; 
                            break;  
                        
                        case "cuentaPorEstamento":
                           $cadena_sql="SELECT ";
                            $cadena_sql.=$prefijo."lista.idlista as lista, ";
                            $cadena_sql.=$prefijo."lista.nombre as nombre, ";
                            $cadena_sql.='estamento, ';
                            $cadena_sql.='idtipo, ';
                            $cadena_sql.='COUNT(*) as cuenta, ';
                            $cadena_sql.='COUNT(*)* (ponderado/100) as ponderado ';
                            $cadena_sql.="FROM ";
                            $cadena_sql.=$prefijo."votodecodificado ";
                            $cadena_sql.=" JOIN ".$prefijo."lista ON  ".$prefijo."lista.idlista = ".$prefijo."votodecodificado.idlista ";
                            $cadena_sql.=" JOIN ".$prefijo."tipoestamento ON  ".$prefijo."votodecodificado.estamento = ".$prefijo."tipoestamento.idtipo ";
                            $cadena_sql.=" WHERE ideleccion = ".$variable['ideleccion'] ;
                            $cadena_sql.=" AND idtipo = ".$variable['estamento'] ;
                            //$cadena_sql.=" AND ".$prefijo."lista.idlista = ".$variable['plancha'];
                            //$cadena_sql.=" GROUP BY 1,2"; 
                            break;  
                    
                        case "totalvotaciones":
				$cadena_sql="SELECT ";
				$cadena_sql.='COUNT(*) as total ';
                                $cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."votodecodificado ";
				$cadena_sql.="WHERE ideleccion = ".$variable;
                                break;        
                        
                        case "datosProceso":
                            
				$cadena_sql = "SELECT DISTINCT nombre, ".$prefijo."procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, ".$prefijo."tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
				$cadena_sql .= "CONCAT(".$prefijo."actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto  ";
                                $cadena_sql .= ",idprocesoelectoral, dependenciasresponsables, fechafin as fechaTermina ";
                                $cadena_sql .= "FROM ".$prefijo."procesoelectoral ";
                                $cadena_sql .= "JOIN ".$prefijo."actoadministrativo ON ".$prefijo."procesoelectoral.tipoactoadministrativo = ".$prefijo."actoadministrativo.idacto  ";
                                $cadena_sql .= "JOIN ".$prefijo."tipovotacion ON ".$prefijo."procesoelectoral.tipovotacion = ".$prefijo."tipovotacion.idtipo  ";
                                $cadena_sql .= " WHERE  idprocesoelectoral= ".$variable;
                                
			break; 
			

			case "buscarFechasProceso":
				$cadena_sql = 'SELECT ';
				$cadena_sql.='id_proceso, ';
				$cadena_sql.='fecha_inicio, ';
				$cadena_sql.='fecha_fin ';
				$cadena_sql.='FROM ';
				$cadena_sql.=$prefijo.'proceso';
				break;

			case "resultados":
				$cadena_sql="SELECT ";
				$cadena_sql.=" id_voto, ";
				$cadena_sql.="vot_votacion, ";
				$cadena_sql.="vot_subvotacion, ";
				$cadena_sql.="vot_plancha, ";
				$cadena_sql.="vot_ip, ";
				$cadena_sql.="vot_tipo_registrado ";
				$cadena_sql.="FROM ";
				$cadena_sql.="voto_voto_decodificado ";
				break;

			case "resultadosDecodificados":
				$cadena_sql="SELECT vp.nombre, count( * ) ";
				$cadena_sql.="FROM voto_voto_decodificado vvd ";
				$cadena_sql.="JOIN voto_votacion vv ON vv.id_votacion = vvd.vot_votacion ";
				$cadena_sql.="JOIN voto_subvotacion vsv ON vsv.id_subvotacion = vvd.vot_subvotacion ";
				$cadena_sql.="JOIN voto_plancha vp ON vp.id_plancha = vvd.vot_plancha ";
				$cadena_sql.="GROUP BY 1 ";
				
				break;
				
			case "resultadosDecodificadosNombres":
				$cadena_sql="SELECT CONCAT(vc.nombre,' ',vc.apellido), vp.nombre, count( * ) ";
				$cadena_sql.="FROM voto_voto_decodificado vvd ";
				$cadena_sql.="JOIN voto_votacion vv ON vv.id_votacion = vvd.vot_votacion ";
				$cadena_sql.="JOIN voto_subvotacion vsv ON vsv.id_subvotacion = vvd.vot_subvotacion ";
				$cadena_sql.="JOIN voto_plancha vp ON vp.id_plancha = vvd.vot_plancha ";
				$cadena_sql.="JOIN voto_candidato vc ON vc.votacion = vv.id_votacion AND vc.id_plancha = vvd.vot_plancha ";
				$cadena_sql.="GROUP BY 1,2 ";
				
				break;	
				
			case "candidatosNombres":

				$cadena_sql="SELECT  CONCAT(vc.nombre,' ',vc.apellido), vp.nombre ";
				$cadena_sql.="FROM voto_candidato vc  ";
				$cadena_sql.="JOIN voto_votacion vv ON vv.id_votacion = vc.votacion ";
				$cadena_sql.="JOIN voto_plancha vp ON vp.id_plancha = vc.id_plancha ";
				$cadena_sql.="WHERE vv.id_votacion = 5  ";
				$cadena_sql.="group by 2 ";
				$cadena_sql.="order by 2 ";
				
				break;	
				
			case "resultadosPorPlancha":
				$cadena_sql="SELECT vp.nombre, count( * ) ";
				$cadena_sql.="FROM voto_voto_decodificado vvd ";
				$cadena_sql.="JOIN voto_votacion vv ON vv.id_votacion = vvd.vot_votacion ";
				$cadena_sql.="JOIN voto_subvotacion vsv ON vsv.id_subvotacion = vvd.vot_subvotacion ";
				$cadena_sql.="JOIN voto_plancha vp ON vp.id_plancha = vvd.vot_plancha ";
				$cadena_sql.="WHERE vp.nombre = '".$variable."' ";
				$cadena_sql.="GROUP BY 1 ";
				
				break;	

			case "cerrarProceso":
				$cadena_sql="UPDATE ";
				$cadena_sql.="voto_votacion ";
				$cadena_sql.="SET ";
				$cadena_sql.='estado="I" ';
				break;

			case "buscarProcesoAbierto":
				$cadena_sql="SELECT ";
				$cadena_sql.="* ";
				$cadena_sql.="FROM ";
				$cadena_sql.="voto_votacion ";
				$cadena_sql.="WHERE ";
				$cadena_sql.='estado="A" ';
				break;
					
					
			

			case "contarVotosDecodificados":
				$cadena_sql="SELECT ";
				$cadena_sql.="count(*) as total ";
				$cadena_sql.="FROM ";
				$cadena_sql.=$prefijo."decodificado ";
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
                        case "idioma":
				$cadena_sql="SET lc_time_names = 'es_CO'";
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
