<?php
/**
 * Bootstrap.class.php
 *
 * Administra el inicio de la aplicacion.
 *
 * @author 	Paulo Cesar Coronado - Karen Palacios
 *
 */

require_once("core/manager/Configurador.class.php");
require_once("core/auth/Sesion.class.php");
require_once("core/connection/FabricaDbConexion.class.php");
require_once("core/crypto/Encriptador.class.php");
require_once("core/builder/Mensaje.class.php");



class Bootstrap
{


    /**
     * Objeto.
     * Con los atributos y métodos para gestionar la sesión de usuario
     * @var Sesion
     */

    public $sesionUsuario;


    /**
     *
     * Objeto.
     * Encargado de inicializar las variables globales. Su atributo $configuracion contiene los valores necesarios
     * para gestionar la aplicacion.
     * @var Configurador
     */
    public $miConfigurador;


    /**
     *
     * Objeto, con funciones miembro generales que encapsulan funcionalidades
     * básicas.
     * @var FuncionGeneral
     */
    private $miFuncion;

    /**
     *
     * Objeto. Gestiona conexiones a bases de datos.
     * @var FabricaDBConexion
     */
    private $manejadorDB;

    /**
     * Objeto de la clase Encriptador se encarga de codificar/decodificar cadenas de texto.
     * @var Encriptador
     */
    private $cripto;


    /**
     *
     * Objeto. Actua como controlador del modulo de instalación del framework/aplicativo
     * @var Instalador
     */
    public $miInstalador;

    /**
     *
     * Objeto. Instancia de la pagina que se está visitando
     * @var Pagina
     */
    public $miPagina;

    /**
     *
     * Arreglo.Ruta de acceso a los archivos, se utilizan porque aún no se ha rescatado las
     * variables de configuración.
     *
     * @var string
     */
    public $misVariables;

    /**
     * Objeto que se encarga de mostrar los mensajes de error fatales.
     * @var Mensaje
     */
    public $cuadroMensaje;




    /**
     * Contructor
     * @param none
     * @return integer
     * */

    public function __construct()
    {
        $this->cuadroMensaje=Mensaje::singleton();
        $this->conectorDB = FabricaDbConexion::singleton();
        $this->cripto = Encriptador::singleton();

        /**
         * Importante conservar el orden de creación de los siguientes objetos porque tienen
         * referencias cruzadas.
         */
        $this->miConfigurador=Configurador::singleton();
        $this->miConfigurador->setConectorDB($this->conectorDB);

        /**
         * El objeto del a clase Sesion es el último que se debe crear.
         */
        $this->sesionUsuario=Sesion::singleton();
    }

    /**
     *
     * Iniciar la aplicación.
     */

    public function iniciar()
    {

        // Poblar el atributo miConfigurador->configuracion
        $this->miConfigurador->variable();

        if (!$this->miConfigurador->getVariableConfiguracion("instalado")) {
            $this->instalarAplicativo();
        } else {
            $this->ingresar();
        }
    }

    /**
     *
     * Asigna los valores a las variables que indican las rutas predeterminadas.
     * @param strting array $variables
     */

    public function setMisVariables($variables)
    {
        $this->misVariables=$variables;
        $this->miConfigurador->setRutas($variables);
    }

    /**
     *
     * Ingresar al aplicativo.
     * @param Ninguno
     * @return int
     */
    private function ingresar()
    {

        /**
         * @global boolean $GLOBALS['autorizado']
         * @name $autorizado
         */
        $GLOBALS["autorizado"]=true;

        $pagina=$this->determinarPagina();

        $this->miConfigurador->setVariableConfiguracion("pagina", $pagina);


        /**
         * Verificar que se tenga una sesión válida
        */

        require_once($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/core/auth/Autenticador.class.php");
        $this->autenticador=Autenticador::singleton();
        $this->autenticador->setPagina($pagina);

        if ($this->autenticador->iniciarAutenticacion()) {

                        /**
             * Procesa la página solicitada por el usuario
             */
            require_once($this->miConfigurador->getVariableConfiguracion("raizDocumento")."/core/builder/Pagina.class.php");
            $this->miPagina=new Pagina();

            if ($this->miPagina->inicializarPagina($pagina)) {
                return true;
            } else {
                $this->mostrarMensajeError($this->miPagina->getError());
                return false;
            }
        } else {
            if ($this->autenticador->getError()=='sesionNoExiste') {
                unset($_REQUEST);
                $this->redireccionar('indice', 'pagina=index&mostrarMensaje=sesionExpirada');
            } else {
                $this->mostrarMensajeError($this->autenticador->getError());
                return false;
            }
        }
    }

    private function mostrarMensajeError($mensaje, $tipoMensaje='')
    {
        $this->miConfigurador->setVariableConfiguracion("error", true);
        if ($tipoMensaje=='') {
            $this->cuadroMensaje->mostrarMensaje($mensaje, "error");
        } else {
            $this->cuadroMensaje->mostrarMensaje($mensaje, $tipoMensaje);
        }
    }

    private function mostrarMensajeRedireccion($mensaje, $tipoMensaje='', $url)
    {
        if ($tipoMensaje=='') {
            $this->cuadroMensaje->mostrarMensajeRedireccion($mensaje, "error", $url);
        } else {
            $this->cuadroMensaje->mostrarMensajeRedireccion($mensaje, $tipoMensaje, $url);
        }
    }


    private function determinarPagina()
    {
        /**
         * Determinar la página que se desea cargar
         */

        if (isset($_REQUEST[$this->miConfigurador->getVariableConfiguracion("enlace")])) {
            $this->miConfigurador->fabricaConexiones->crypto->decodificar_url($_REQUEST[$this->miConfigurador->getVariableConfiguracion("enlace")]);
            unset($_REQUEST[$this->miConfigurador->getVariableConfiguracion("enlace")]);
            if (isset($_REQUEST["redireccionar"])) {
                $this->redireccionar();
                return false;
            }
            if (isset($_REQUEST["pagina"])) {
                return $_REQUEST["pagina"];
            } else {
                return "";
            }
        } else {
            return "index";
        }
    }

    /**
     *
     * Instalar el aplicativo.
     */

    private function instalarAplicativo()
    {
        require_once("install/Instalador.class.php");
        $this->miInstalador=new Instalador();
        if (isset($_REQUEST["instalador"])) {
            $this->miInstalador->procesarInstalacion();
        } else {
            $this->miInstalador->mostrarFormularioDatosConexion();
        }
        return 0;
    }
    /**
     * Redireccionar a otra página
     * @return number
     */

    public function redireccionar($pagina='', $opciones='')
    {
        $enlace=$this->miConfigurador->getVariableConfiguracion("enlace");

        switch ($pagina) {
                case '':
        $variable="";

        foreach ($_REQUEST as $clave=> $val) {
            if ($clave !="redireccionar" && $clave!= $enlace) {
                $variable.="&".$clave."=".$val;
            }
        }

        $variable=substr($variable, 1);
        $variable=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $enlace);
        $indice=$this->miConfigurador->configuracion["host"].$this->miConfigurador->configuracion["site"]."/index.php?";
        echo "<script>location.replace('".$indice.$variable."')</script>";
                break;

                case 'indice':
                    $indice=$this->miConfigurador->configuracion["host"].$this->miConfigurador->configuracion["site"]."/index.php?";
                    $opciones=$this->miConfigurador->fabricaConexiones->crypto->codificar_url($opciones, $enlace);
                    echo "<script>location.replace('".$indice.$opciones."')</script>";
                break;

            default:
                echo "<script>location.replace('".$pagina."')</script>";
                break;
            }
    }
};
