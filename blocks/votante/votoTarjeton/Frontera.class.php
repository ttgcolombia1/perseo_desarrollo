<?php

include_once("core/manager/Configurador.class.php");

class FronteravotoTarjeton {

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
        $this->funcion = new FuncionvotoTarjeton();

        if (isset($_REQUEST['opcion'])) {

            $accion = $_REQUEST['opcion'];

            switch ($accion) {

                case "votar":

                    $votaciones['eleccion'] = $_REQUEST['eleccion'];
                    $usuario = $_REQUEST['usuario'];

                    $votoVerificado = $this->funcion->verificarVoto($usuario, $votaciones);

                    if ($votoVerificado[0]['datovoto'] == '') {

                        include_once($this->ruta . "formulario/armarTarjeton.php");
                    } else {
                        $_REQUEST['mensaje'] = "Usted ya ejerció su derecho al voto para esta elección.";
                        $_REQUEST['error'] = "information";
                        include_once($this->ruta . "formulario/mensajes.php");
                    }
                    break;

                case "mostrarMensaje":
                    include_once($this->ruta . "formulario/mostrarMensaje.php");
                    break;

                case "mensajes":
                    $accion = "nuevo";
                    include_once($this->ruta . "formulario/mensajes.php");
                    include_once($this->ruta . "formulario/nuevo.php");

                    break;

                case "vertarjeton":
                    include_once($this->ruta . "formulario/armarTarjeton.php");
                    break;
            }
        } else {
            $accion = "nuevo";
            include_once($this->ruta . "/formulario/nuevo.php");
        }
    }

}

?>