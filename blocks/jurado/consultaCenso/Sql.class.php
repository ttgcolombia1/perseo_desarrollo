<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlConsultaCenso extends sql {

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
        $idSesion = "123";

        switch ($tipo) {


            case "consultarVotante":
            	
            	$cadena_sql = "SELECT DISTINCT ";
            	$cadena_sql .= "usu.identificacion, ";
            	$cadena_sql .= "usu.nombre, ";
            	$cadena_sql .= "usu.segunda_identificacion, ";
            	$cadena_sql .= "estam.idtipo, ";
            	$cadena_sql .= "estam.descripcion AS estamento, ";
            	$cadena_sql .= "elec.ideleccion, ";
            	$cadena_sql .= "elec.nombre AS eleccion, ";
            	$cadena_sql .= "elec.estado, ";
            	$cadena_sql .= "voto.fecha, ";
            	$cadena_sql .= "voto.ip, ";
            	$cadena_sql .= "tvoto.descripcion tipoEleccion ";
            	$cadena_sql .= "FROM ";
               	$cadena_sql .= $prefijo . "censo usu ";
            	$cadena_sql .= "INNER JOIN ";
                $cadena_sql .= $prefijo . "tipoestamento estam  ";
            	$cadena_sql .= "   ON estam.idtipo=usu.idtipo ";
            	$cadena_sql .= "INNER JOIN ";
               	$cadena_sql .= $prefijo . "eleccion elec  ";
            	$cadena_sql .= "   ON  elec.ideleccion=usu.ideleccion  ";
            	$cadena_sql .= "   AND estado=1 ";
                $cadena_sql .=" INNER JOIN " . $prefijo . "tipovotacion tvoto  ";
                $cadena_sql .=" ON tvoto.idtipo=elec.tipovotacion ";
            	$cadena_sql .= " LEFT OUTER JOIN ";
               	$cadena_sql .= $prefijo . "datovoto voto   ";
            	$cadena_sql .= "   ON voto.idusuario=usu.identificacion  ";
            	$cadena_sql .= "   AND voto.ideleccion=usu.ideleccion ";
            	$cadena_sql .= "WHERE ";
            	$cadena_sql .= "usu.identificacion IN (".$variable['idUsuario'].") ";
            	$cadena_sql .= "OR usu.segunda_identificacion IN (".$variable['idUsuario'].") ";
            	
                break;

            case "actualizarContrasena":
                $password= sha1(md5($variable['contrasena']));
                $cadena_sql = "UPDATE ";
                $cadena_sql .= $prefijo."censo SET ";
                //$cadena_sql .= " clave= SHA1(MD5('".$variable['contrasena']."')), ";
                $cadena_sql .= " clave= '".$password."', ";
                $cadena_sql .= " expira_clave='".$variable['expiracion']."' ";
                $cadena_sql .= " WHERE identificacion=". $_REQUEST['idUsuario'];
                
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

            case "iniciarTransaccion":
                $cadena_sql = "START TRANSACTION";
                break;

            case "finalizarTransaccion":
                $cadena_sql = "COMMIT";
                break;

            case "cancelarTransaccion":
                $cadena_sql = "ROLLBACK";
                break;


    
        }
        return $cadena_sql;
    }

}

?>
