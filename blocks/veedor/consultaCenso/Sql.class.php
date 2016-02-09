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

            case "buscarTipoDocumento":
                $cadena_sql = "SELECT DISTINCT censo_tipo_doc_graduado AS id,censo_tipo_doc_graduado AS tipo FROM censo WHERE  censo_tipo_doc_graduado <> ''";
                break;

            case "consultarCenso":
                $cadena_sql = "SELECT censo_id_registro, censo_tipo_doc_graduado, censo_num_doc_graduado, 
                                    censo_tipo_doc_actual, censo_num_doc_actual, censo_nombre, censo_correo, 
                                    censo_correo_ud, censo_tel_fijo, censo_tel_celular, censo_direccion, 
                                    censo_cod_estudiante, censo_facultad_graduado, censo_carrera_graduado, 
                                    censo_ano_graduado, censo_periodo_graduacion, censo_clave, censo_habilitado, 
                                    censo_estado, censo_tipo, censo_votacion, v.votacion_nombre, v.votacion_mensaje
                             FROM censo c,
                             votacion v
                             WHERE c.censo_num_doc_graduado = " . $variable . "
                             and c.censo_votacion = v.votacion_id";
                break;

            case "actualizarCenso":
                
                $cadena_sql = "UPDATE censo SET ";

                if ($_REQUEST['tipoDocAnterior'] != '' && $_REQUEST['tipoDocAnterior'] != null) {
                    $cadena_sql .= " censo_tipo_doc_graduado='" . $_REQUEST['tipoDocAnterior'] . "'";
                }
                if ($_REQUEST['numeroDocAnterior'] != 0 && $_REQUEST['numeroDocAnterior'] != null) {
                    $cadena_sql .= ", censo_num_doc_graduado=" . $_REQUEST['numeroDocAnterior'];
                }
                if ($_REQUEST['tipoDocNuevo'] != '' && $_REQUEST['tipoDocNuevo'] != null) {
                    $cadena_sql .= ", censo_tipo_doc_actual='" . $_REQUEST['tipoDocNuevo'] . "'";
                }
                if ($_REQUEST['numeroDocNuevo'] != 0 && $_REQUEST['numeroDocNuevo'] != null) {
                    $cadena_sql .= ", censo_num_doc_actual=" . $_REQUEST['numeroDocNuevo'];
                }
                if ($_REQUEST['nombre'] != '' && $_REQUEST['nombre'] != null) {
                    $cadena_sql .= ", censo_nombre='" . $_REQUEST['nombre'] . "'";
                }
                if ($_REQUEST['correoPrincipal'] != '' && $_REQUEST['correoPrincipal'] != null) {
                    $cadena_sql .= ", censo_correo='" . $_REQUEST['correoPrincipal'] . "'";
                }
                if ($_REQUEST['correoInstitucional'] != '' && $_REQUEST['correoInstitucional'] != null) {
                    $cadena_sql .= ", censo_correo_ud='" . $_REQUEST['correoInstitucional'] . "'";
                }
                if ($_REQUEST['telefonoFijo'] != 0 && $_REQUEST['telefonoFijo'] != null) {
                    $cadena_sql .= ", censo_tel_fijo=" . $_REQUEST['telefonoFijo'];
                }
                if ($_REQUEST['telefonoCelular'] != 0 && $_REQUEST['telefonoCelular'] != null) {
                    $cadena_sql .= ", censo_tel_celular=" . $_REQUEST['telefonoCelular'];
                }
                if ($_REQUEST['direccion'] != '' && $_REQUEST['direccion'] != null) {
                    $cadena_sql .= ", censo_direccion='" . $_REQUEST['direccion'] . "'";
                }
                if ($_REQUEST['codigo'] != 0 && $_REQUEST['codigo'] != null) {
                    $cadena_sql .= ", censo_cod_estudiante=" . $_REQUEST['codigo'];
                }
                if ($_REQUEST['facultad'] != '' && $_REQUEST['facultad'] != null) {
                    $cadena_sql .= ", censo_facultad_graduado='" . $_REQUEST['facultad'] . "'";
                }
                if ($_REQUEST['carrera'] != '' && $_REQUEST['carrera'] != null) {
                    $cadena_sql .= ", censo_carrera_graduado='" . $_REQUEST['carrera'] . "'";
                }
                if ($_REQUEST['anoGraduado'] != 0 && $_REQUEST['anoGraduado'] != null) {
                    $cadena_sql .= ", censo_ano_graduado=" . $_REQUEST['anoGraduado'];
                }
                if ($_REQUEST['periodoGraduado'] != 0 && $_REQUEST['periodoGraduado'] != null) {
                    $cadena_sql .= ", censo_periodo_graduacion=" . $_REQUEST['periodoGraduado'];
                }
                if ($_REQUEST['acta'] != '' && $_REQUEST['acta'] != null) {
                    $cadena_sql .= ", censo_acta='" . $_REQUEST['acta']."'";
                }
                if ($_REQUEST['folio'] != '' && $_REQUEST['folio'] != null) {
                    $cadena_sql .= ", censo_folio='" . $_REQUEST['folio']."'";
                }

                $cadena_sql .= ", censo_fecha_actualizacion='" . date("d-M-Y  h:i:s A") . "',    
                               censo_clave= md5('" . $_REQUEST["clave"] . "') " . "
                             WHERE censo_id_registro=" . $_REQUEST['idRegistro'];
                break;

            case "insertarCensoNoRegistrado":
                $cadena_sql = "INSERT INTO no_registrado(
                                censon_num_identificacion, 
                                censon_tipo_documento, 
                                censon_nombre, 
                                censon_correo_principal, 
                                censon_correo_alternativo, 
                                censon_tel_fijo, 
                                censon_tel_celular, 
                                censon_direccion, 
                                censon_codigo, 
                                censon_facultad, 
                                censon_carrera, 
                                censon_anno, 
                                censon_periodo,
                                censon_acta,
                                censon_folio)
                                VALUES ("
                        . $_REQUEST['numeroDocNuevo'] . ", '"
                        . $_REQUEST['tipoDocNuevo'] . "', '"
                        . $_REQUEST['nombre'] . "','"
                        . $_REQUEST['correoPrincipal'] . "','"
                        . $_REQUEST['correoInstitucional'] . "', "
                        . $_REQUEST['telefonoFijo'] . ", "
                        . $_REQUEST['telefonoCelular'] . ", '"
                        . $_REQUEST['direccion'] . "', "
                        . $_REQUEST['codigo'] . ", '"
                        . $_REQUEST['facultad'] . "', '"
                        . $_REQUEST['carrera'] . "', "
                        . $_REQUEST['anoGraduado'] . ", "
                        . $_REQUEST['periodoGraduado'] . ",'"
                        . $_REQUEST['acta'] . "','"
                        . $_REQUEST['folio'] . "');";
                break;

            //Se usa para verificar si un usuario ya actualizó los datos básicos
            case "consultarActualizacionNoRegistrado":
                $cadena_sql = "SELECT censon_num_identificacion FROM no_registrado where censon_num_identificacion = " . $variable;
                break;

            case "buscarFacultades":
                $cadena_sql = "SELECT DEP_NOMBRE, DEP_NOMBRE FROM GEDEP WHERE DEP_NOMBRE LIKE 'FACULTAD%'";
                break;

            case "buscarFacultadesPostgres":
                $cadena_sql = "SELECT DISTINCT censo_facultad_graduado, censo_facultad_graduado FROM censo;";
                break;

            case "buscarCarreras":
                $cadena_sql = "SELECT CRA_NOMBRE, CRA_NOMBRE FROM ACCRA";
                break;

            case "buscarCarrerasPostgres":
                $cadena_sql = "select id, descripcion from carreras order by descripcion";
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
