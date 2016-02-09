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

                $cadena_sql = "SELECT cen.identificacion, cen.nombre as nombreCenso, cen.ideleccion, cen.idtipo, cen.fechavoto, cen.datovoto, pel.nombre as nombrePel, pel.descripcion, ele.nombre as nombreEle, ele.fechainicio as elefechainicio, ele.fechafin as elefechafin, DATE_FORMAT(ele.fechafin, '%d %M %Y %H:%i:%s')  ";
                $cadena_sql .= "FROM ".$prefijo."censo cen  ";
                $cadena_sql .= "JOIN ".$prefijo."eleccion ele ON ele.ideleccion = cen.ideleccion AND ele.tipoestamento = cen.idtipo ";
                $cadena_sql .= "JOIN ".$prefijo."tipoestamento tes ON tes.idtipo = cen.idtipo ";
                $cadena_sql .= "JOIN ".$prefijo."procesoelectoral pel ON pel.idprocesoelectoral = procesoelectoral_idprocesoelectoral  ";
                $cadena_sql .= " WHERE cen.identificacion = ".$variable;
                $cadena_sql .= " AND ele.fechainicio <= '".date('Y-m-d H:i:s')."' ";
                $cadena_sql .= " AND ele.fechafin >= '".date('Y-m-d H:i:s')."' ";

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
    
                $cadena_sql = " SELECT lis.idlista, lis.nombre ";
                $cadena_sql.= " FROM ".$prefijo."lista lis ";
                $cadena_sql.= " WHERE eleccion_ideleccion = ".$variable."";
            break;
        
            case "infoEleccion":
    
                $cadena_sql = " SELECT nombre, descripcion,listatarjeton ";
                $cadena_sql.= " FROM ".$prefijo."eleccion ";
                $cadena_sql.= " WHERE ideleccion = ".$variable."";
            break;
        
            case "verificarSegundaClave":
    
                $cadena_sql = " SELECT utilizarsegundaclave ";
                $cadena_sql.= " FROM ".$prefijo."eleccion ";
                $cadena_sql.= " WHERE ideleccion = ".$variable."";
            break;
        
            case "listaCandidatos":
    
                $cadena_sql = " SELECT lis.idlista, can.idcandidato, can.identificacion, can.nombre, can.apellido, can.foto ";
                $cadena_sql.= " FROM ".$prefijo."lista lis ";
                $cadena_sql.= " JOIN evoto_candidato can ON can.lista_idlista = lis.idlista";
                $cadena_sql.= " WHERE eleccion_ideleccion = ".$variable[0]."";
                $cadena_sql.= " AND lis.idlista = ".$variable[1]."";
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
                $cadena_sql = "SELECT nombre, identificacion "; 
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
            
            default :
                $cadena_sql="";
                break;
            
        
        }
        return $cadena_sql;  
    }
    
}

?>
