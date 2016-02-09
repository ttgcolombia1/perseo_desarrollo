<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlsegundaClave extends sql {

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
        //$idSesion = $this->sql->cadena_sql("rescatarValorSesion", "");

        switch ($tipo) {

            /**
             * Clausulas específicas
             */
            /** se usa para saber si el usuario habia registrado la segunda clave anteriormente**/
            case "validarSegundaClave";
                $cadena_sql = "SELECT * FROM ".$prefijo."segundaclave ";
                $cadena_sql .= " where identificacion = ".$variable." and fecha is not null";
                break;
            
            case "buscarPreguntas":
                $cadena_sql = "select idpregunta, descripcion from ".$prefijo."preguntasegundaclave ORDER BY idpregunta";
                break;
            
            case "rescatarValorSesion":
                $cadena_sql = "SELECT sesionid, variable, valor, expiracion FROM ".$prefijo."_valor_sesion";
                break;
            
            case "registrarSegundaClave":
                $cadena_sql = "INSERT INTO ".$prefijo."segundaclave (identificacion, idpregunta, respuesta, segundaclave, fecha) ";
                $cadena_sql .= "VALUES (";
                $cadena_sql .= " ".$variable["identificacion"].", ";
                $cadena_sql .= " '".$variable["idpregunta"]."',";
                $cadena_sql .= "'".$variable["respuesta"]."',";
                $cadena_sql .= "'".$variable["segundaclave"]."',";
                $cadena_sql .=" DATE_FORMAT('".date("Y/m/d H:i:s")."', '%Y/%m/%d:%H:%i:%s'))";                                
                break;
            
            case "actualizarSegundaClave":
                $cadena_sql = "UPDATE ".$prefijo."segundaclave ";
                $cadena_sql .=" SET segundaclave = '".$variable["segundaclave"]."', ";
                $cadena_sql .=" idpregunta = '".$variable["idpregunta"]."', ";
                $cadena_sql .=" respuesta = '".$variable["respuesta"]."', ";
                $cadena_sql .=" fecha = DATE_FORMAT('".date("Y/m/d H:i:s")."', '%Y/%m/%d:%H:%i:%s') ";
                $cadena_sql .=" where identificacion = ".$variable["identificacion"];          
                break;

            case "obtenerDatosEgresado":
                $cadena_sql = "select distinct egr_nombre nombre, 
                                    egr_email correo 
                                    from acegresado 
                                    where 
                                    egr_nro_iden = ".$variable." 
                                    and egr_email <> '(null)' 
                                    and egr_email is not null";
                break;
            
            
           
            /******************************************************* */
            case "iniciarTransaccion":
                $cadena_sql = "START TRANSACTION";
                break;

            case "finalizarTransaccion":
                $cadena_sql = "COMMIT";
                break;

            case "cancelarTransaccion":
                $cadena_sql = "ROLLBACK";
                break;


            case "eliminarTemp":

                $cadena_sql = "DELETE ";
                $cadena_sql.="FROM ";
                $cadena_sql.=$prefijo . "tempFormulario ";
                $cadena_sql.="WHERE ";
                $cadena_sql.="id_sesion = '" . $variable . "' ";
                break;

            case "insertarTemp":
                $cadena_sql = "INSERT INTO ";
                $cadena_sql.=$prefijo . "tempFormulario ";
                $cadena_sql.="( ";
                $cadena_sql.="id_sesion, ";
                $cadena_sql.="formulario, ";
                $cadena_sql.="campo, ";
                $cadena_sql.="valor, ";
                $cadena_sql.="fecha ";
                $cadena_sql.=") ";
                $cadena_sql.="VALUES ";

                foreach ($_REQUEST as $clave => $valor) {
                    $cadena_sql.="( ";
                    $cadena_sql.="'" . $idSesion . "', ";
                    $cadena_sql.="'" . $variable['formulario'] . "', ";
                    $cadena_sql.="'" . $clave . "', ";
                    $cadena_sql.="'" . $valor . "', ";
                    $cadena_sql.="'" . $variable['fecha'] . "' ";
                    $cadena_sql.="),";
                }

                $cadena_sql = substr($cadena_sql, 0, (strlen($cadena_sql) - 1));
                break;

            case "rescatarTemp":
                $cadena_sql = "SELECT ";
                $cadena_sql.="id_sesion, ";
                $cadena_sql.="formulario, ";
                $cadena_sql.="campo, ";
                $cadena_sql.="valor, ";
                $cadena_sql.="fecha ";
                $cadena_sql.="FROM ";
                $cadena_sql.=$prefijo . "tempFormulario ";
                $cadena_sql.="WHERE ";
                $cadena_sql.="id_sesion='" . $idSesion . "'";
                break;
        }
        return $cadena_sql;
    }

}

?>
