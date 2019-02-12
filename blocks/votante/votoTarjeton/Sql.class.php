<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlvotoTarjeton extends sql {

    var $miConfigurador;

    function __construct() {
        $this->miConfigurador = Configurador::singleton();
    }

    function cadena_sql($tipo, $variable = "") {

        /**
         * 1. Revisar las variables para evitar SQL Injection
         *
         */
        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {
            
            case "consultarProcesosVotante":

                $cadena_sql = "SELECT  DISTINCT ";
                $cadena_sql .= "cen.identificacion, ";
                $cadena_sql .= "cen.nombre as nombreCenso, ";
                $cadena_sql .= "cen.ideleccion, ";
                $cadena_sql .= "cen.idtipo, ";
                $cadena_sql .= "cen.fechavoto, ";
                $cadena_sql .= "cen.datovoto, ";
                $cadena_sql .= "pel.nombre as nombrePel, ";
                $cadena_sql .= "pel.descripcion, ";
                $cadena_sql .= "ele.nombre as nombreEle, ";
                $cadena_sql .= "ele.fechainicio as elefechainicio, ";
                $cadena_sql .= "ele.fechafin as elefechafin, ";
                $cadena_sql .= "DATE_FORMAT(ele.fechafin, '%d %M %Y %H:%i:%s') ";
                $cadena_sql .= "FROM ".$prefijo."censo cen  ";
                $cadena_sql .= "INNER JOIN ".$prefijo."eleccion ele ON ele.ideleccion = cen.ideleccion AND (ele.tipoestamento = cen.idtipo OR ele.tipoestamento=0)  ";
                $cadena_sql .= "INNER JOIN ".$prefijo."tipoestamento tes ON tes.idtipo = cen.idtipo  ";
                $cadena_sql .= "INNER JOIN ".$prefijo."procesoelectoral pel ON pel.idprocesoelectoral = procesoelectoral_idprocesoelectoral  ";
                $cadena_sql .= " WHERE cen.identificacion = ".$variable;
                $cadena_sql .= " AND ele.fechainicio <= '".date('Y-m-d H:i:s')."' ";
                $cadena_sql .= " AND ele.fechafin >= '".date('Y-m-d H:i:s')."' ";
                $cadena_sql .= "ORDER BY  cen.ideleccion ";
           
            break;
        
            case "verificarVoto":
                $cadena_sql = " SELECT";
                $cadena_sql.= " fechavoto,";
                $cadena_sql.= " datovoto";
                $cadena_sql.= " FROM";
                $cadena_sql.= " ".$prefijo."censo ";
                $cadena_sql.= " WHERE";
                $cadena_sql.= " identificacion='".$variable[1]."'";
                $cadena_sql.= " AND ideleccion='".$variable[0]."'";
            break;
        
            case "listaTarjetones":
    
                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.= " lis.idlista, ";
                $cadena_sql.= " lis.nombre, ";
                $cadena_sql.= " lis.eleccion_ideleccion, ";
                $cadena_sql.= " lis.posiciontarjeton ";
                $cadena_sql.= " FROM ".$prefijo."lista lis ";
                $cadena_sql.= " WHERE eleccion_ideleccion = ".$variable."";
                $cadena_sql.= " ORDER BY  lis.posiciontarjeton ASC ,lis.idlista ASC";
            break;
        
            case "infoEleccion":
    
                $cadena_sql = " SELECT nombre, descripcion, listatarjeton ";
                $cadena_sql.= " FROM ".$prefijo."eleccion ";
                $cadena_sql.= " WHERE ideleccion = ".$variable."";
            break;
        
            case "verificarSegundaClave":
    
                $cadena_sql = " SELECT utilizarsegundaclave ";
                $cadena_sql.= " FROM ".$prefijo."eleccion ";
                $cadena_sql.= " WHERE ideleccion = ".$variable."";
            break;
        
            case "listaCandidatos":
    
                $cadena_sql = " SELECT lis.idlista, can.idcandidato, can.identificacion, can.nombre, can.apellido, can.foto, can.reglon";
                $cadena_sql.= " FROM ".$prefijo."lista lis ";
                $cadena_sql.= " JOIN evoto_candidato can ON can.lista_idlista = lis.idlista";
                $cadena_sql.= " WHERE eleccion_ideleccion = ".$variable[0]."";
                $cadena_sql.= " AND lis.idlista = ".$variable[1]."";
                $cadena_sql.= " ORDER BY  can.reglon ";
                
            break;
        
            case "rutaLlavePublica":
                $cadena_sql = " SELECT";
                $cadena_sql.= " valor";
                $cadena_sql.= " FROM";
                $cadena_sql.= " ".$prefijo."configuracion";
                $cadena_sql.= " WHERE";
                $cadena_sql.= " parametro='public_key'";
                break;
            
            case "llavePublica":
                $cadena_sql = " SELECT";
                $cadena_sql.= " nombrellave";
                $cadena_sql.= " FROM";
                $cadena_sql.= " ".$prefijo."llave_seguridad";
                $cadena_sql.= " WHERE";
                $cadena_sql.= " idproceso=".$variable." ";
                $cadena_sql.= " AND ";
                $cadena_sql.= " tipollave=1";
                
                break;
            
            case "insertarDatosVoto":
                $cadena_sql = " INSERT INTO ".$prefijo."datovoto";
                $cadena_sql.= " (idusuario,";
                $cadena_sql.= " ideleccion,";
                $cadena_sql.= " fecha,";
                $cadena_sql.= " ip) ";
                $cadena_sql.= " VALUES (";
                $cadena_sql.= $variable['usuario'] . ", ";
                $cadena_sql.= $variable['eleccion'] . ", "; 
                $cadena_sql.= "'" .$variable['tiempo'] . "', "; 
                $cadena_sql.= "'" .$variable['ip'] . "')";
                break;
            
            case "insertarDatosCenso":
                $cadena_sql = " UPDATE ".$prefijo."censo";
                $cadena_sql.= " SET fechavoto = '" .$variable['fecha'] . "', ";
                $cadena_sql.= " datovoto = '" .$variable['ip'] . "' ";
                $cadena_sql.= " WHERE identificacion = '" .$variable['usuario'] . "' "; 
                $cadena_sql.= " AND ideleccion = " .$variable['eleccion'] . " "; 
                break;
            
            case "insertarVoto":
                $cadena_sql = "INSERT INTO ".$prefijo."votocodificado";
                $cadena_sql.= " (ideleccion,";
                $cadena_sql.= " voto,";
                $cadena_sql.= " ip, estamento)";
                $cadena_sql.= " VALUES (";
                $cadena_sql.= $variable['eleccion'] . ", "; //votacion
                $cadena_sql.= "'" . $variable['textoEncriptado'] . "', "; //plancha
                $cadena_sql.= "'" . $variable['ip'] . "', "; //IP
                $cadena_sql.= "'" . $variable['estamento'] . "' "; //IP
                $cadena_sql.=")";
                break;
            
            case "consultarSegundaClave":
                $cadena_sql = "SELECT segundaclave "; 
                $cadena_sql .= " FROM ".$prefijo."segundaclave ";
                $cadena_sql .= " WHERE identificacion = " . $variable;
                break;
            
            case "idioma":
                    $cadena_sql = "SET lc_time_names = 'es_ES' ";
            break;
            
            case "datosVotante":
                $cadena_sql = "SELECT nombre, identificacion, segunda_identificacion "; 
                $cadena_sql .= " FROM ".$prefijo."censo ";
                $cadena_sql .= " WHERE identificacion = " . $variable;
                break;
            
            case "datosVotoRegistrado":
                $cadena_sql = "SELECT ";
                $cadena_sql .= " idusuario, ideleccion "; 
                $cadena_sql .= " FROM " ; 
                $cadena_sql .=  $prefijo."datovoto ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "idusuario = " . $variable['usuario']." ";
                $cadena_sql .= "AND ";
                $cadena_sql .= "ideleccion = " . $variable['eleccion']. " ";
                break;
            
            case "estamentoVotante":
                $cadena_sql = "SELECT idtipo "; 
                $cadena_sql .= " FROM ".$prefijo."censo ";
                $cadena_sql .= " WHERE identificacion = '" . $variable['usuario'] . "'";
                $cadena_sql .= " AND ideleccion= '" . $variable['eleccion'] . "'";
                break;
            
            case "datosEleccion":
                $cadena_sql = "SELECT pe.nombre as nombpe, el.nombre as nomel, DATE_FORMAT(pe.fechainicio,'%d de %M de %Y %r') as fechainicia, DATE_FORMAT(pe.fechafin,'%d de %M de %Y %r')  as fechafinaliza, pe.idprocesoelectoral as idproceso "; 
                $cadena_sql .= " FROM ".$prefijo."eleccion el ";
                $cadena_sql .= " JOIN ".$prefijo."procesoelectoral pe ON pe.idprocesoelectoral = el.procesoelectoral_idprocesoelectoral ";
                $cadena_sql .= " WHERE el.ideleccion = " . $variable;
                break;
            
            case "infoElecciones":
                            
                $cadena_sql = "SELECT DISTINCT ideleccion, EL.nombre AS nombreEleccion, EL.descripcion, DATE_FORMAT(EL.fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(EL.fechafin,'%d de %M de %Y %r')  as fechafin, DATE_FORMAT(EL.fechafin,'%Y-%m-%d %H:%i:%s') as fechafinele ";
                $cadena_sql .= "FROM ".$prefijo."eleccion EL ";
                $cadena_sql .= " WHERE  ideleccion = ".$variable['eleccion'];                                

                break;
            
            default :
                $cadena_sql="";
                break;
            
        
        }
        
        return $cadena_sql;  
    }
    
}

?>
