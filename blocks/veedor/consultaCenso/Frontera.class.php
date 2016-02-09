<?

include_once("core/manager/Configurador.class.php");

class FronteraConsultaCenso {

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

    function html() {
        include_once("core/builder/FormularioHtml.class.php");

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");


        $this->miFormulario = new formularioHtml();

        if (isset($_REQUEST['opcion'])) {

            $accion = $_REQUEST['opcion'];
            
            switch ($accion) {

                case "nuevo":
                    include_once($this->ruta . "formulario/nuevo.php");
                    break;
                
                case "actualizarNoRegistrado":
                    include_once($this->ruta . "formulario/frmActualizacionDatosNoRegistro.php");
                    break;

                case "mostrarMensaje":
                    include_once($this->ruta . "formulario/mostrarMensaje.php");
                    break;

                case "mostrarActualizacion":
                    include_once($this->ruta . "formulario/nuevo.php");
                    break;

                case "mostrarMensajeNoRegistro":
                    include_once($this->ruta . "formulario/frmMostrarMensajeNoRegistro.php");
                    break;
                
                case "mostrarMensajeRegistro":
                    include_once($this->ruta . "formulario/frmMostrarMensajeRegistro.php");
                    break;
            }
        } else {

            if (count($_REQUEST) === 2) {
                foreach ($_REQUEST as $key => $value) {
                    if ($key != "jquery") {
                        $pagina = $this->miConfigurador->fabricaConexiones->crypto->decodificar($key);
                    }
                }
                $this->funcion->redireccionar("cambiarClave", $pagina);
                
            } else {
                $accion = "nuevo";
                include_once($this->ruta . "/formulario/nuevo.php");
            }
        }
    }

}

?>
