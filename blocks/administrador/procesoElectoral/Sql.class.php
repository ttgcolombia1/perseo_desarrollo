<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlProcesoElectoral extends sql
{


    var $miConfigurador;


    function __construct()
    {
        $this->miConfigurador = Configurador::singleton();
    }


    function cadena_sql($tipo, $variable = "")
    {

        /**
         * 1. Revisar las variables para evitar SQL Injection
         *
         */

        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            case "idioma":

                $cadena_sql = "SET lc_time_names = 'es_ES' ";
                break;

            case "buscaProcesoNombre":
                $cadena_sql = "SELECT DISTINCT idprocesoelectoral, ";
                $cadena_sql .= " nombre, ";
                $cadena_sql .= " descripcion, ";
                $cadena_sql .= " fechainicio, ";
                $cadena_sql .= " fechafin, ";
                $cadena_sql .= " idactoadministrativo, ";
                $cadena_sql .= " tipovotacion ";
                $cadena_sql .= " FROM " . $prefijo . "procesoelectoral ";
                $cadena_sql .= " WHERE nombre = '" . $variable[0]. "' ";
                $cadena_sql .= " AND fechainicio= '" . $variable[2]. "' ";
                $cadena_sql .= " AND fechafin= '" . $variable[3]. "' ";
                $cadena_sql .= " AND idactoadministrativo= '" . $variable[5]. "' ";
                $cadena_sql .= " AND tipovotacion= '" . $variable[9]. "' ";
                break;     
            
            case "datosProceso":

                $cadena_sql = "SELECT DISTINCT nombre, " . $prefijo . "procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, " . $prefijo . "tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
                $cadena_sql .= "CONCAT(" . $prefijo . "actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto  ";
                $cadena_sql .= ",idprocesoelectoral, dependenciasresponsables ";
                $cadena_sql .= "FROM " . $prefijo . "procesoelectoral ";
                $cadena_sql .= "JOIN " . $prefijo . "actoadministrativo ON " . $prefijo . "procesoelectoral.tipoactoadministrativo = " . $prefijo . "actoadministrativo.idacto  ";
                $cadena_sql .= "JOIN " . $prefijo . "tipovotacion ON " . $prefijo . "procesoelectoral.tipovotacion = " . $prefijo . "tipovotacion.idtipo  ";
                $cadena_sql .= " WHERE  idprocesoelectoral= " . $variable;

                break;

            case "infoEleccion":
                $cadena_sql = " SELECT nombre, descripcion, listatarjeton ";
                $cadena_sql.= " FROM ".$prefijo."eleccion ";
                $cadena_sql.= " WHERE ideleccion = ".$variable."";
                break;

            case "listaCandidatos":
                $cadena_sql = " SELECT lis.idlista,";
                $cadena_sql.= "  can.idcandidato,";
                $cadena_sql.= "  can.identificacion,";
                $cadena_sql.= "  can.nombre,";
                $cadena_sql.= "  can.apellido,";
                $cadena_sql.= "  can.foto,";
                $cadena_sql.= "  can.reglon";
                $cadena_sql.= " FROM ".$prefijo."lista lis ";
                $cadena_sql.= " JOIN evoto_candidato can ON can.lista_idlista = lis.idlista";
                $cadena_sql.= " WHERE eleccion_ideleccion = ".$variable[0]."";
                $cadena_sql.= " AND lis.idlista = ".$variable[1]."";
                $cadena_sql.= " ORDER BY  can.reglon ";
                break;

            case "listaTarjetones":

                $cadena_sql = " SELECT DISTINCT ";
                $cadena_sql.= " lis.idlista, ";
                $cadena_sql.= " lis.nombre, ";
                $cadena_sql.= " lis.eleccion_ideleccion, ";
                $cadena_sql.= " lis.posiciontarjeton ";
                $cadena_sql.= " FROM ".$prefijo."lista lis ";
                $cadena_sql.= " WHERE eleccion_ideleccion = ".$variable."";
                $cadena_sql.= " ORDER BY lis.posiciontarjeton ASC,lis.idlista ASC";
                break;

            case "dependencias":

                $cadena_sql = "SELECT id_dependencia, nombre ";
                $cadena_sql .= "FROM " . $prefijo . "dependencias ";
                $cadena_sql .= "ORDER BY id_dependencia";
                break;

            case "tipovotacion":

                $cadena_sql = "SELECT idtipo, descripcion ";
                $cadena_sql .= "FROM " . $prefijo . "tipovotacion ";
                $cadena_sql .= "WHERE IDTIPO != 4 ";
                $cadena_sql .= "ORDER BY idtipo";
                break;

            case "actoadministrativo":

                $cadena_sql = "SELECT idacto, descripcion ";
                $cadena_sql .= "FROM " . $prefijo . "actoadministrativo ";
                $cadena_sql .= "ORDER BY idacto";
                break;

            case "insertarProceso":

                $cadena_sql = "INSERT INTO " . $prefijo . "procesoelectoral VALUES ( ";
                $cadena_sql .= "DEFAULT, ";
                $cadena_sql .= "'" . $variable[0] . "', ";
                $cadena_sql .= "'" . $variable[1] . "', ";
                $cadena_sql .= "'" . $variable[2] . "', ";
                $cadena_sql .= "'" . $variable[3] . "', ";
                $cadena_sql .= "1, ";
                $cadena_sql .= "" . $variable[7] . ", ";
                $cadena_sql .= "'" . $variable[8] . "', ";
                $cadena_sql .= "'" . $variable[4] . "', ";
                $cadena_sql .= "" . $variable[5] . ", ";
                $cadena_sql .= "'" . $variable[6] . "', ";
                $cadena_sql .= "" . $variable[9] . ") ";
                break;

            case "idioma":

                $cadena_sql = "SET lc_time_names = 'es_ES' ";
                break;

            case "consultarProcesosActivos":

                $cadena_sql = "SELECT DISTINCT nombre, " . $prefijo . "procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, " . $prefijo . "tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
                $cadena_sql .= "CONCAT(" . $prefijo . "actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto  ";
                $cadena_sql .= ",idprocesoelectoral, fechainicio as fechabase ";
                $cadena_sql .= "FROM " . $prefijo . "procesoelectoral ";
                $cadena_sql .= "JOIN " . $prefijo . "actoadministrativo ON " . $prefijo . "procesoelectoral.tipoactoadministrativo = " . $prefijo . "actoadministrativo.idacto  ";
                $cadena_sql .= "JOIN " . $prefijo . "tipovotacion ON " . $prefijo . "procesoelectoral.tipovotacion = " . $prefijo . "tipovotacion.idtipo  ";
                $cadena_sql .= " WHERE  estado = 1 ";

                break;

            case "consultarProcesoEditar":

                $cadena_sql = "SELECT DISTINCT nombre, descripcion, fechainicio, fechafin, tipoactoadministrativo, cantidadelecciones,  ";
                $cadena_sql .= "tipovotacion, idactoadministrativo,  fechaactoadministrativo, dependenciasresponsables ";
                $cadena_sql .= ",idprocesoelectoral ";
                $cadena_sql .= "FROM " . $prefijo . "procesoelectoral ";
                $cadena_sql .= " WHERE  idprocesoelectoral = " . $variable;

                break;

            case "actualizarProceso":

                $cadena_sql = "UPDATE " . $prefijo . "procesoelectoral SET ";
                $cadena_sql .= " nombre = '" . $variable[0] . "', ";
                $cadena_sql .= " descripcion = '" . $variable[1] . "', ";
                $cadena_sql .= " fechainicio = '" . $variable[2] . "', ";
                $cadena_sql .= " fechafin = '" . $variable[3] . "', ";
                $cadena_sql .= " tipoactoadministrativo = '" . $variable[4] . "', ";
                $cadena_sql .= " idactoadministrativo = '" . $variable[5] . "', ";
                $cadena_sql .= " fechaactoadministrativo = '" . $variable[6] . "', ";
                $cadena_sql .= " cantidadelecciones = '" . $variable[7] . "', ";
                $cadena_sql .= " dependenciasresponsables = '" . $variable[8] . "', ";
                $cadena_sql .= " tipovotacion = '" . $variable[9] . "' ";
                $cadena_sql .= " WHERE idprocesoelectoral = " . $variable[10] . " ";
                break;

            case "inhabilitarProceso":

                $cadena_sql = "UPDATE " . $prefijo . "procesoelectoral SET ";
                $cadena_sql .= " estado = 2 ";
                $cadena_sql .= " WHERE idprocesoelectoral = " . $variable . " ";
                break;

            case "consultaEleccion":
                $cadena_sql = "SELECT ideleccion, nombre, tipoestamento, descripcion, fechainicio, fechafin, ";
                $cadena_sql .= " listaTarjeton, tipovotacion, estado, candidatostarjeton, utilizarsegundaclave, eleccionform, tiporesultado, ";
                $cadena_sql .= " porcEstudiante, porcDocente, porcEgresado, porcFuncionario, porcDocenteVinEspecial ";
                $cadena_sql .= " FROM " . $prefijo . "eleccion ";
                $cadena_sql .= " WHERE procesoelectoral_idprocesoelectoral = " . $variable[0];
                break;
            /**
             * Clausulas genéricas. se espera que estén en todos los formularios
             * que utilicen esta plantilla
             */

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
                $cadena_sql .= "FROM ";
                $cadena_sql .= $prefijo . "tempFormulario ";
                $cadena_sql .= "WHERE ";
                $cadena_sql .= "id_sesion = '" . $variable . "' ";
                break;

            case "insertarTemp":
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

                foreach ($_REQUEST as $clave => $valor) {
                    $cadena_sql .= "( ";
                    $cadena_sql .= "'" . $idSesion . "', ";
                    $cadena_sql .= "'" . $variable['formulario'] . "', ";
                    $cadena_sql .= "'" . $clave . "', ";
                    $cadena_sql .= "'" . $valor . "', ";
                    $cadena_sql .= "'" . $variable['fecha'] . "' ";
                    $cadena_sql .= "),";
                }

                $cadena_sql = substr($cadena_sql, 0, (strlen($cadena_sql) - 1));
                break;

            case "rescatarTemp":
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