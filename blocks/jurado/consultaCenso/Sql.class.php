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
            	$cadena_sql .= "voto.ip ";
            	$cadena_sql .= "FROM evoto_censo usu ";
            	$cadena_sql .= "INNER JOIN evoto_tipoestamento estam  ";
            	$cadena_sql .= "   ON estam.idtipo=usu.idtipo ";
            	$cadena_sql .= "INNER JOIN evoto_eleccion elec  ";
            	$cadena_sql .= "   ON  elec.ideleccion=usu.ideleccion  ";
            	$cadena_sql .= "   AND estado=1 ";
            	$cadena_sql .= "LEFT OUTER JOIN evoto_datovoto voto   ";
            	$cadena_sql .= "   ON voto.idusuario=usu.identificacion  ";
            	$cadena_sql .= "   AND voto.ideleccion=usu.ideleccion ";
            	$cadena_sql .= "WHERE ";
            	$cadena_sql .= "usu.identificacion IN (".$variable['idUsuario'].") ";
            	$cadena_sql .= "OR usu.segunda_identificacion IN (".$variable['idUsuario'].") ";
            	
                break;

            case "actualizarCenso":
                
                $cadena_sql = "UPDATE censo SET ";
                $cadena_sql .= ", censo_fecha_actualizacion='" . date("d-M-Y  h:i:s A") . "',    
                               censo_clave= md5('" . $_REQUEST["clave"] . "') " . "
                             WHERE censo_id_registro=" . $_REQUEST['idRegistro'];
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
