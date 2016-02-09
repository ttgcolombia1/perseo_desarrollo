<?php
include_once("core/manager/Configurador.class.php");

class FronterasegundaClave {

    var $ruta;
    var $sql;
    var $funcion;
    var $lenguaje;
    var $formulario;
    var $miConfigurador;

    function __construct() {

        $this->miConfigurador = Configurador::singleton();
    }

    public function setRuta($unaRuta) {
        $this->ruta = $unaRuta;
    }

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function setFormulario($formulario) {
        $this->formulario = $formulario;
    }

    function frontera() {
        $this->html();
    }

    function setSql($a) {
        $this->sql = $a;
    }

    function setFuncion($funcion) {
        $this->funcion = $funcion;
    }

    function redireccionar($opcion, $datos) {
        include_once($this->ruta . "formulario/redireccionar.php");
    }

    function validarPreguntas() {
        
        $miSesion= Sesion::singleton();
        $identificacion = $miSesion->getSesionUsuarioId();
        
        $conexion = "estructura";
        $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if ($esteRecursoDB == false) {
            $mensaje = "...No se pudo establecer conexión con la base de datos, por favor contacte al administrador del sistema...";
            $error = "error";
            $datos = array("mensaje" => $mensaje, "error" => $error);
        } else {
            $cadena_sql = trim($this->sql->cadena_sql("validarSegundaClave", $identificacion));            
            $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
			
            if ($resultado) {

                $preguntas['idpregunta'] = $resultado[0]['idpregunta'];
                $preguntas['respuesta'] = unserialize($this->miConfigurador->fabricaConexiones->crypto->decodificar($resultado[0]['respuesta']));
                                
                $preguntas['opcion'] = 'actualizarSegundaClave';
                return $preguntas;
            } else {
                $preguntas['opcion'] = 'nuevo';
                return $preguntas;
            }
        }
    }

    function html() {
        include_once("core/builder/FormularioHtml.class.php");

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        $this->miFormulario = new formularioHtml();

        if (isset($_REQUEST['opcion'])) {

            $accion = $_REQUEST['opcion'];

            switch ($accion) {

                case "nuevo":
                    include_once($this->ruta . "/formulario/" . $_REQUEST['opcion'] . ".php");
                    break;

                case "mostrarMensaje":
                    include_once($this->ruta . "formulario/mostrarMensaje.php");
                    break;
            }
        } else {

            $accion = "nuevo";
            $preguntas = $this->validarPreguntas();
            include_once($this->ruta . "/formulario/" . $preguntas['opcion'] . ".php");
        }
    }

}

?>