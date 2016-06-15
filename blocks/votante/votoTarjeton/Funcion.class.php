<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/manager/Configurador.class.php");
include_once("core/builder/InspectorHTML.class.php");
include_once("core/builder/Mensaje.class.php");
include_once("core/crypto/Encriptador.class.php");
include_once("classes/Validador.class.php");

//Esta clase contiene la logica de negocio del bloque y extiende a la clase funcion general la cual encapsula los
//metodos mas utilizados en la aplicacion
//Para evitar redefiniciones de clases el nombre de la clase del archivo funcion debe corresponder al nombre del bloque
//en camel case precedido por la palabra Funcion

class FuncionvotoTarjeton {

    var $sql;
    var $funcion;
    var $lenguaje;
    var $ruta;
    var $miConfigurador;
    var $miInspectorHTML;
    var $error;
    var $miRecursoDB;
    var $crypto;
    var $validar;

    function rescatarTarjeton($votaciones) {
        include_once($this->ruta . "/funcion/rescatarTarjeton.php");
        return $tarjeton;
    }

    function obtenerIP() {
        $ip = include_once($this->ruta . "/funcion/obtenerIP.php");
        return $ip;
    }

    function redireccionar($opcion, $datos) {
        include_once($this->ruta . "/funcion/redireccionar.php");
    }

    function verificarVoto($usuario, $votaciones) {
        include_once($this->ruta . "/funcion/verificarVoto.php");
        return $votoRegistrado;
    }

    
    function rescatarSesion() {
        include_once($this->ruta . "/funcion/rescatarSesion.php");
        return $id_usuario;
    }

    function almacenarVoto() {
        //1.Verificar si ya había participado en esta elección                    
        if ($this->verificarHoraFinalizacion()) {
            //2.Verificar si ya había participado en esta elección                    
            if ($this->verificarParticipacionEleccion()) {
                //3. Obtener la llave pública del proceso
                $llavePublica = $this->obtenerLlavePublica();
                if ($llavePublica) {
                    //4. Obtener el voto
                    $voto = $this->obtenerVoto();
                    if ($voto) {
                        //5. Codificar el voto
                        $votoCodificado = $this->codificarVoto($llavePublica, $voto);
                        if ($votoCodificado) {
                            //6. Guardar el voto codificado
                            if ($this->guardarVoto($votoCodificado)) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    function guardarVoto($votoCodificado) {
        include_once($this->ruta . "/funcion/almacenarVoto/guardarVoto.php");
        return $respuesta;
    }

    function codificarVoto($llavePublica, $voto) {
        include_once($this->ruta . "/funcion/almacenarVoto/codificarVoto.php");
        return $respuesta;
    }
    
    function obtenerVoto() {
        include_once($this->ruta . "/funcion/almacenarVoto/obtenerVoto.php");
        return $arregloVoto;
    }


    function obtenerLlavePublica() {
        include_once($this->ruta . "/funcion/almacenarVoto/obtenerLlavePublica.php");
        return $resultado;
    }

    function verificarParticipacionEleccion() {
        include_once($this->ruta . "/funcion/almacenarVoto/verificarParticipacion.php");
        return $respuesta;
    }
    
    function verificarHoraFinalizacion() {
        include_once($this->ruta . "/funcion/almacenarVoto/verificarHoraFinalizacion.php");
        return $respuesta;
    }

    function action() {

        $miSesion = Sesion::singleton();

        if (isset($_REQUEST["procesarAjax"])) {
            $this->procesarAjax();
        } else {

            switch ($_REQUEST["opcion"]) {
                
                case "registrarVoto":
                    $mensajeVoto['id_usuario'] = $_REQUEST['usuario'];
                    if($this->almacenarVoto()){
                         $mensajeVoto['mensaje'] = "El voto se ha registrado exitosamente!!!";
                         $mensajeVoto['error'] = "success";                            
                    }else{
                        $mensajeVoto['mensaje'] = "El voto no ha podido ser registrado.";
                         $mensajeVoto['error'] = "error"; 
                    }
                    $this->funcion->redireccionar('mostrarMensaje', $mensajeVoto);
                    break;
                case "procesarSegundaClave":
                    include_once($this->ruta . "funcion/procesarSegundaClave.php");
                    break;
                case "certificado":
                    include_once($this->ruta . "funcion/certificado.php");
                    break;
            }
        }
    }

    function __construct() {

        $this->miConfigurador = Configurador::singleton();

        $this->miInspectorHTML = InspectorHTML::singleton();

        $this->ruta = $this->miConfigurador->getVariableConfiguracion("rutaBloque");

        $this->miMensaje = Mensaje::singleton();

        $this->validar = new Validador();

        $conexion = "aplicativo";
        $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

        if (!$this->miRecursoDB) {

            $this->miConfigurador->fabricaConexiones->setRecursoDB($conexion, "tabla");
            $this->miRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
        }
    }

    public function setRuta($unaRuta) {
        $this->ruta = $unaRuta;
        //Incluir las funciones
    }

    function setSql($a) {
        $this->sql = $a;
    }

    function setFuncion($funcion) {
        $this->funcion = $funcion;
    }

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function setFormulario($formulario) {
        $this->formulario = $formulario;
    }

}

?>
