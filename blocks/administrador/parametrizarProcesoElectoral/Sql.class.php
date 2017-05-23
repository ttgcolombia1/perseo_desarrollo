<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/connection/Sql.class.php");

//Para evitar redefiniciones de clases el nombre de la clase del archivo sqle debe corresponder al nombre del bloque
//en camel case precedida por la palabra sql

class SqlParametrizarProcesoElectoral extends sql
{

    var $miConfigurador;

    function __construct()
    {
        $this->miConfigurador = Configurador::singleton();
    }


    function cadena_sql($tipo, $variable = "")
    {

        $variable = $this->limpiarHTML($variable);

        /**
         * 1. Revisar las variables para evitar SQL Injection
         *
         */

        $prefijo = $this->miConfigurador->getVariableConfiguracion("prefijo");
        $idSesion = $this->miConfigurador->getVariableConfiguracion("id_sesion");

        switch ($tipo) {

            case "eliminarCandidato":
                $cadena_sql = "DELETE ";
                $cadena_sql .= "FROM " . $prefijo . "candidato ";
                $cadena_sql .= "WHERE identificacion=" . $variable[0];
                break;

            case "eliminarLista":
                $cadena_sql = "DELETE ";
                $cadena_sql .= "FROM " . $prefijo . "lista ";
                $cadena_sql .= "WHERE idlista=" . $variable[0];
                break;

            case "consultaCandidatoLista":
                $cadena_sql = "SELECT * ";
                $cadena_sql .= "FROM " . $prefijo . "candidato ";
                $cadena_sql .= "WHERE identificacion=" . $variable[0];
                break;

            case "consultarCandidatosLista":
                $cadena_sql = "SELECT ";
                $cadena_sql .= "COUNT(*) as conteo FROM " . $prefijo . "candidato ";
                $cadena_sql .= "WHERE lista_idlista=" . $variable[0];
                break;


            case "nodos":

                $cadena_sql = "SELECT ip_nodo, ruta_nodo, user, pass ";
                $cadena_sql .= "FROM " . $prefijo . "nodos ";
                break;

            case "dependencias":

                $cadena_sql = "SELECT id_dependencia, nombre ";
                $cadena_sql .= "FROM " . $prefijo . "dependencias ";
                $cadena_sql .= "ORDER BY id_dependencia";
                break;

            case "tipovotacion":

                $cadena_sql = "SELECT idtipo, descripcion ";
                $cadena_sql .= "FROM " . $prefijo . "tipovotacion ";
                $cadena_sql .= "ORDER BY idtipo";
                break;

            case "tiporesultados":

                $cadena_sql = "SELECT idtipo, descripcion ";
                $cadena_sql .= "FROM " . $prefijo . "tiporesultados ";
                $cadena_sql .= "ORDER BY idtipo";
                break;

            case "tipoestamento":

                $cadena_sql = "SELECT idtipo, descripcion ";
                $cadena_sql .= "FROM " . $prefijo . "tipoestamento ";
                $cadena_sql .= "ORDER BY idtipo";
                break;

            case "datosRestricciones":

                $cadena_sql = "SELECT idtipo, descripcion, nombre_campo ";
                $cadena_sql .= "FROM " . $prefijo . "tiporestriccion ";
                $cadena_sql .= "ORDER BY idtipo";
                break;

            case "actoadministrativo":

                $cadena_sql = "SELECT idacto, descripcion ";
                $cadena_sql .= "FROM " . $prefijo . "actoadministrativo ";
                $cadena_sql .= "ORDER BY idacto";
                break;

            case "idioma":

                $cadena_sql = "SET lc_time_names = 'es_ES' ";
                break;

            case "consultarProcesos":

                $cadena_sql = "SELECT DISTINCT nombre, " . $prefijo . "procesoelectoral.descripcion, DATE_FORMAT(fechainicio,'%d de %M de %Y %r') as fechainicio, DATE_FORMAT(fechafin,'%d de %M de %Y %r')  as fechafin, " . $prefijo . "tipovotacion.descripcion as tipoVotacion, cantidadelecciones,  ";
                $cadena_sql .= "CONCAT(" . $prefijo . "actoadministrativo.descripcion, ' ', idactoadministrativo, ' del ',  DATE_FORMAT(fechaactoadministrativo,'%d de %M de %Y')) as acto  ";
                $cadena_sql .= ",idprocesoelectoral, fechainicio as fechabase, fechafin as fechaterm ";
                $cadena_sql .= "FROM " . $prefijo . "procesoelectoral ";
                $cadena_sql .= "JOIN " . $prefijo . "actoadministrativo ON " . $prefijo . "procesoelectoral.tipoactoadministrativo = " . $prefijo . "actoadministrativo.idacto  ";
                $cadena_sql .= "JOIN " . $prefijo . "tipovotacion ON " . $prefijo . "procesoelectoral.tipovotacion = " . $prefijo . "tipovotacion.idtipo  ";
                $cadena_sql .= " WHERE  1=1 ";
                if ($variable[0] != '') {
                    $cadena_sql .= " AND nombre like '%" . $variable[0] . "%' ";
                }
                if ($variable[1] != '') {
                    $cadena_sql .= " AND fechainicio = '" . $variable[1] . "' ";
                }
                if ($variable[2] != 4) {
                    $cadena_sql .= " AND tipovotacion = " . $variable[2] . " ";
                }

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

            case "consultarProcesoEditar":

                $cadena_sql = "SELECT DISTINCT nombre, descripcion, fechainicio, fechafin, tipoactoadministrativo, cantidadelecciones,  ";
                $cadena_sql .= "tipovotacion, idactoadministrativo,  fechaactoadministrativo, dependenciasresponsables ";
                $cadena_sql .= ",idprocesoelectoral ";
                $cadena_sql .= "FROM " . $prefijo . "procesoelectoral ";
                $cadena_sql .= " WHERE  idprocesoelectoral = " . $variable;

                break;

            case "actualizarProceso":

                $cadena_sql = "UPDATE " . $prefijo . "procesoelectoral SET ";
                $cadena_sql .= " fechainicio = '" . $variable[0] . "', ";
                $cadena_sql .= " fechafin = '" . $variable[1] . "' ";
                $cadena_sql .= " WHERE idprocesoelectoral = " . $variable[2] . " ";
                break;

            case "insertarEleccion":

                $cadena_sql = "INSERT INTO " . $prefijo . "eleccion VALUES (  ";
                $cadena_sql .= " NULL, ";
                $cadena_sql .= " '" . $variable[0] . "', ";
                $cadena_sql .= " '" . $variable[1] . "', ";
                $cadena_sql .= " '" . $variable[2] . "', ";
                $cadena_sql .= " '" . $variable[3] . "', ";
                $cadena_sql .= " '" . $variable[4] . "', ";
                $cadena_sql .= " '" . $variable[5] . "', ";
                $cadena_sql .= " '" . $variable[6] . "', ";
                $cadena_sql .= " '" . $variable[7] . "', ";
                $cadena_sql .= " '" . $variable[8] . "', ";
                $cadena_sql .= " '" . $variable[9] . "', ";
                $cadena_sql .= " '" . $variable[10] . "', ";
                $cadena_sql .= " '" . $variable[11] . "', ";
                $cadena_sql .= " '" . $variable[12] . "', ";
                $cadena_sql .= " '" . $variable[13] . "', ";
                $cadena_sql .= " '" . $variable[14] . "', ";
                $cadena_sql .= " '" . $variable[15] . "', ";
                $cadena_sql .= " '" . $variable[16] . "', ";
                $cadena_sql .= " '" . $variable[17] . "') ";

                break;

            case "insertarLista":

                $cadena_sql = "INSERT INTO ";
                $cadena_sql .=  $prefijo . "lista(idlista, nombre, eleccion_ideleccion, posiciontarjeton)";
                $cadena_sql .= " VALUES (  ";
                $cadena_sql .= " NULL, ";
                $cadena_sql .= " '" . $variable[0] . "', ";
                $cadena_sql .= " '" . $variable[1] . "', ";
                $cadena_sql .= " '" . $variable[2] . "') ";

                break;

            case "idLista":

                $cadena_sql = "SELECT idlista, nombre, posiciontarjeton FROM " . $prefijo . "lista ";
                $cadena_sql .= " WHERE eleccion_ideleccion = " . $variable;

                break;

            case "buscarLista":
                $cadena_sql = "SELECT idlista FROM " . $prefijo . "lista ";
                $cadena_sql .= " WHERE nombre = " . $variable[0];
                if(isset($variable[1]) && $variable[1]!='')
                    {$cadena_sql .= " AND eleccion_ideleccion = " . $variable[1]; }
                break;

            case "listasHuerfanas":
                $cadena_sql = "select evoto_lista.idlista from evoto_lista where evoto_lista.idlista not in (select evoto_candidato.lista_idlista from evoto_candidato)";
                break;

            case "borrarHuerfana":
                $cadena_sql = "DELETE FROM evoto_lista WHERE idlista =".$variable;
                break;


            case "actualizaCandidatoLista":
                $cadena_sql = " UPDATE " . $prefijo . "candidato  ";
                $cadena_sql .= " SET ";
                $cadena_sql .= " nombre='" . $variable[1] . "', ";
                $cadena_sql .= " apellido='" . $variable[2] . "', ";
                $cadena_sql .= " identificacion=" . $variable[3] . ", ";
                $cadena_sql .= " reglon=" . $variable[4] . ", ";
                $cadena_sql .= " lista_idlista=" . $variable[5];
                $cadena_sql .= " WHERE ";
                $cadena_sql .= " idcandidato=" . $variable[0];
                break;


            case "insertarCandidato":

                $cadena_sql = "INSERT INTO ";
                $cadena_sql .= $prefijo . "candidato(idcandidato, identificacion, nombre, apellido, reglon, lista_idlista, foto) ";
                $cadena_sql .= " VALUES (  ";
                $cadena_sql .= " NULL, ";
                $cadena_sql .= " '" . $variable[0] . "', ";
                $cadena_sql .= " '" . $variable[1] . "', ";
                $cadena_sql .= " '" . $variable[2] . "', ";
                $cadena_sql .= " '" . $variable[3] . "', ";
                $cadena_sql .= " '" . $variable[4] . "', ";
                $cadena_sql .= " '" . $variable[5] . "') ";

                break;

            case "consultaEleccion":

                $cadena_sql = "SELECT ideleccion, nombre, tipoestamento, descripcion, fechainicio, fechafin, ";
                $cadena_sql .= " listaTarjeton, tipovotacion, estado, candidatostarjeton, utilizarsegundaclave, eleccionform, tiporesultado, ";
                $cadena_sql .= " porcEstudiante, porcDocente, porcEgresado, porcFuncionario, porcDocenteVinEspecial ";
                $cadena_sql .= " FROM " . $prefijo . "eleccion ";
                $cadena_sql .= " WHERE procesoelectoral_idprocesoelectoral = " . $variable[0];
                $cadena_sql .= " AND eleccionform = " . $variable[1];

                break;

            case "consultaCandidatos":
                
                $cadena_sql=" SELECT DISTINCT";
                $cadena_sql.=" list.nombre nombre_lista, ";
                $cadena_sql.=" list.posiciontarjeton, ";
                $cadena_sql.=" identificacion, ";
                $cadena_sql.=" cand.nombre, ";
                $cadena_sql.=" cand.apellido, ";
                $cadena_sql.=" cand.foto, ";
                $cadena_sql.=" cand.idcandidato,";
                $cadena_sql.=" cand.reglon ";
                $cadena_sql.=" FROM " . $prefijo . "lista list";
                $cadena_sql.=" JOIN " . $prefijo . "candidato cand ON list.idlista = cand.lista_idlista ";
                $cadena_sql.=" WHERE list.eleccion_ideleccion = " . $variable[1];
                $cadena_sql .= " order by cand.idcandidato ";
                
                break;

            case "consultarCandidato":
                $cadena_sql = "SELECT listas.idlista, listas.nombre lista, posiciontarjeton, identificacion, candidatos.nombre, apellido, foto, idcandidato, reglon ";
                $cadena_sql .= " FROM " . $prefijo . "lista listas  ";
                $cadena_sql .= " JOIN " . $prefijo . "candidato candidatos ON listas.idlista = candidatos.lista_idlista  ";
                $cadena_sql .= " WHERE idcandidato = " . $variable[0];
                $cadena_sql .= " AND listas.eleccion_ideleccion = " . $variable[1];
                $cadena_sql .= " order by candidatos.idcandidato ";

                break;

            case "consultaEleccionFinal":

                $cadena_sql = "SELECT ideleccion, nombre, tipoestamento.descripcion as tipoesta, eleccion.descripcion, fechainicio, fechafin, ";
                $cadena_sql .= " listaTarjeton, tipovotacion.descripcion as tipovota, utilizarsegundaclave as segclave ";
                $cadena_sql .= " FROM " . $prefijo . "eleccion eleccion ";
                $cadena_sql .= " JOIN " . $prefijo . "tipoestamento tipoestamento ON tipoestamento.idtipo = eleccion.tipoestamento  ";
                $cadena_sql .= " JOIN " . $prefijo . "tipovotacion tipovotacion ON tipovotacion.idtipo = eleccion.tipovotacion  ";
                $cadena_sql .= " WHERE ideleccion = " . $variable;

                break;

            case "consultaCandidatosFinal":
                $cadena_sql = "SELECT listas.nombre, posiciontarjeton, identificacion, candidatos.nombre, apellido, foto ";
                $cadena_sql .= " FROM " . $prefijo . "lista listas  ";
                $cadena_sql .= " JOIN " . $prefijo . "candidato candidatos ON listas.idlista = candidatos.lista_idlista  ";
                $cadena_sql .= " WHERE eleccion_ideleccion = " . $variable;
                $cadena_sql .= " order by candidatos.idcandidato ";

                break;

            case "consultaFechaProceso":

                $cadena_sql = "SELECT DATE_FORMAT(fechainicio,'%Y/%m/%d %H:%i:%s') as fechainicio, DATE_FORMAT(fechafin,'%Y/%m/%d %H:%i:%s') as fechafin ";
                $cadena_sql .= "FROM " . $prefijo . "procesoelectoral ";
                $cadena_sql .= " WHERE  idprocesoelectoral = " . $variable[0];

                break;

            case "actualizarEleccion":

                $cadena_sql = "UPDATE " . $prefijo . "eleccion SET  ";
                $cadena_sql .= " nombre = '" . $variable[1] . "', ";
                $cadena_sql .= " tipoestamento = '" . $variable[2] . "', ";
                $cadena_sql .= " descripcion = '" . $variable[3] . "', ";
                $cadena_sql .= " fechainicio = '" . $variable[4] . "', ";
                $cadena_sql .= " fechafin = '" . $variable[5] . "', ";
                $cadena_sql .= " listaTarjeton = '" . $variable[6] . "', ";
                $cadena_sql .= " tipovotacion = '" . $variable[7] . "', ";
                $cadena_sql .= " candidatostarjeton = '" . $variable[9] . "', ";
                $cadena_sql .= " utilizarsegundaclave = '" . $variable[10] . "', ";
                $cadena_sql .= " tiporesultado = '" . $variable[12] . "', ";
                $cadena_sql .= " porcEstudiante = '" . $variable[13] . "', ";
                $cadena_sql .= " porcDocente = '" . $variable[14] . "', ";
                $cadena_sql .= " porcEgresado = '" . $variable[15] . "', ";
                $cadena_sql .= " porcFuncionario = '" . $variable[16] . "', ";
                $cadena_sql .= " porcDocenteVinEspecial = '" . $variable[18] . "' ";
                $cadena_sql .= " WHERE  ideleccion = " . $variable[17];

                break;

            case "actualizarFechaEleccion":
                $cadena_sql = "UPDATE " . $prefijo . "eleccion SET  ";
                $cadena_sql .= " fechainicio = '" . $variable[0] . "', ";
                $cadena_sql .= " fechafin = '" . $variable[1] . "' ";
                $cadena_sql .= " WHERE  ideleccion = " . $variable[2];
                break;

            case "actualizarPorcentajeEstamento":

                $cadena_sql = "UPDATE " . $prefijo . "tipoestamento SET  ";
                $cadena_sql .= " ponderado = " . $variable['ponderado'] . " ";
                $cadena_sql .= " WHERE  idtipo = " . $variable['idtipo'] . " ";

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


