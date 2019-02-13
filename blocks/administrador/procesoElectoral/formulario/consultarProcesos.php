<?php

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

include_once("core/crypto/Encriptador.class.php");

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque .= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio .= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio .= $this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$nombreFormulario = $esteBloque["nombre"];

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("idioma", "");
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

$cadena_sql = $this->sql->cadena_sql("consultarProcesosActivos", "");
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$variableNuevo = "pagina=procesoElectoral"; //pendiente la pagina para modificar parametro
$variableNuevo .= "&opcion=nuevo";
$variableNuevo .= "&usuario=" . $miSesion->getSesionUsuarioId();
$variableNuevo = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableNuevo, $directorio);


echo "<h1> Gestión de Procesos Electorales </h1>";

if ($resultadoProcesos) {
    //-----------------Inicio de Conjunto de Controles----------------------------------------
    $esteCampo = "marcoDatosResultadoParametrizar";
    $atributos["estilo"] = "jqueryui";
    $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
    //echo $this->miFormulario->marcoAgrupacion("inicio", $atributos);
    unset($atributos);

    echo "<div class='datagrid'><table id='tablaProcesos'>";

    echo "<thead>
                <tr align='center'>
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>
                    <th>Cantidad Elecciones</th>
                    <th>Editar Candidatos</th>
                    <th>Editar Detalles Proceso</th>
                    <th>Ver Tarjeton</th>
                    <th>Inhabilitar</th>
                    <th>Resumen</th>
                </tr>
            </thead>
            <tbody>";

    for ($i = 0; $i < count($resultadoProcesos); $i++) {
        $variableEditar = "pagina=procesoElectoral"; //pendiente la pagina para modificar parametro
        $variableEditar .= "&opcion=editar";
        $variableEditar .= "&usuario=" . $miSesion->getSesionUsuarioId();
        $variableEditar .= "&proceso=" . $resultadoProcesos[$i][7];
        $variableEditar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableEditar, $directorio);

        $variableVerTarjeton = "pagina=procesoElectoral"; //pendiente la pagina para modificar parametro
        $variableVerTarjeton .= "&opcion=armarTarjeton";
        $variableVerTarjeton .= "&usuario=" . $miSesion->getSesionUsuarioId();
        $variableVerTarjeton .= "&proceso=" . $resultadoProcesos[$i][7];
        $variableVerTarjeton = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableVerTarjeton, $directorio);


        $variableInhabilitar = "pagina=procesoElectoral"; //pendiente la pagina para modificar parametro
        $variableInhabilitar .= "&opcion=inhabilitar";
        $variableInhabilitar .= "&usuario=" . $miSesion->getSesionUsuarioId();
        $variableInhabilitar .= "&proceso=" . $resultadoProcesos[$i][7];
        $variableInhabilitar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableInhabilitar, $directorio);

        $variableResumen = "pagina=procesoElectoral"; //pendiente la pagina para modificar parametro
        $variableResumen .= "&action=" . $esteBloque["nombre"];
        $variableResumen .= "&bloque=" . $esteBloque["id_bloque"];
        $variableResumen .= "&bloqueGrupo=" . $esteBloque["grupo"];
        $variableResumen .= "&opcion=resumen";
        $variableResumen .= "&usuario=" . $miSesion->getSesionUsuarioId();
        $variableResumen .= "&proceso=" . $resultadoProcesos[$i][7];
        $variableResumen = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableResumen, $directorio);

        $variableParametrizar = "pagina=parametrizarProcesoElectoral"; //pendiente la pagina para modificar parametro
        $variableParametrizar .= "&opcion=parametrizar";
        $variableParametrizar .= "&usuario=" . $miSesion->getSesionUsuarioId();
        $variableParametrizar .= "&proceso=" . $resultadoProcesos[$i][7];
        $variableParametrizar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableParametrizar, $directorio);

         /*
          * nombre
          * fecha inicio
          * fecha final
          * cantidad de elecciones
          *
          * */

        $mostrarHtml = "<tr align='center'>
                    <td>" . $resultadoProcesos[$i][0] . "</td>
                    <td>" . $resultadoProcesos[$i][2] . "</td>
                    <td>" . $resultadoProcesos[$i][3] . "</td>
                    <td>" . $resultadoProcesos[$i][5] . "</td><td>";

        if ($resultadoProcesos[$i][8] < date('Y-m-d H:i:s') && (isset($resultadoProcesos[$i][9]) && $resultadoProcesos[$i][9] < date('Y-m-d H:i:s'))) {
            $mostrarHtml .= "El proceso ha finalizado, no se puede parametrizar";
        } else if ($resultadoProcesos[$i][8] < date('Y-m-d H:i:s') && (isset($resultadoProcesos[$i][9]) && $resultadoProcesos[$i][9] > date('Y-m-d H:i:s'))) {
            $mostrarHtml .= "El proceso ha iniciado, no se puede parametrizar";
        } else {
            $mostrarHtml .= "<a href='" . $variableParametrizar . "'>
                                            <img src='" . $rutaBloque . "/images/edit.png' width='25px'>
                                        </a>";
        }
        $mostrarHtml .= "</td>";

        if ($resultadoProcesos[$i][8] < date('Y-m-d H:i:s')) {
            $mostrarHtml .= "<td>";
            $mostrarHtml .= "El proceso no se puede editar, ya inicio el proceso";
            $mostrarHtml .= "</td>";
            $mostrarHtml .= "<td>";
            $mostrarHtml .= "<a href='".$variableVerTarjeton."'><img src='".$rutaBloque."/images/info.png' width='25px'></a></td>";
            $mostrarHtml .= "</td>";
            $mostrarHtml .= "<td>";
            $mostrarHtml .= "El proceso no se puede inhabilitar, ya inicio el proceso";
            $mostrarHtml .= "</td>";
        } else {
            $mostrarHtml .= "<td>";
            $mostrarHtml .= "<a href='".$variableEditar."'><img src='".$rutaBloque."/images/edit.png' width='25px'></a>";
            $mostrarHtml .= "</td>";
            $mostrarHtml .= "<td>";
            $mostrarHtml .= "<a href='" . $variableVerTarjeton . "'><img src='" . $rutaBloque . "/images/info.png' width='25px'></a>";
            $mostrarHtml .= "</td>";
            $mostrarHtml .= "<td>";
            $mostrarHtml .= "<a href='" . $variableInhabilitar . "'><img src='" . $rutaBloque . "/images/cancel.png' width='25px'></a>";
            $mostrarHtml .= "</td>";
        }



        $mostrarHtml .= "<td>";
        $mostrarHtml .= "<a href='" . $variableResumen . "'>
                                       <img src='" . $rutaBloque . "/images/acroread.png' width='25px'>
                                   </a>";
        $mostrarHtml .= "</td>";

        $mostrarHtml .= "</tr>";
        echo $mostrarHtml;
        unset($mostrarHtml);
        unset($variable);
    }

    echo "</tbody>";

    echo "</table></div>";

    //Fin de Conjunto de Controles
    //echo $this->miFormulario->marcoAgrupacion("fin");

} else {
    $nombreFormulario = $esteBloque["nombre"];

    $cripto = Encriptador::singleton();
    $directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque") . "/imagen/";

    $miPaginaActual = $this->miConfigurador->getVariableConfiguracion("pagina");

    $tab = 1;
    //---------------Inicio Formulario (<form>)--------------------------------
    $atributos["id"] = $nombreFormulario;
    $atributos["tipoFormulario"] = "multipart/form-data";
    $atributos["metodo"] = "POST";
    $atributos["nombreFormulario"] = $nombreFormulario;
    $verificarFormulario = "1";
    echo $this->miFormulario->formulario("inicio", $atributos);

    $atributos["id"] = "divNoEncontroEgresado";
    $atributos["estilo"] = "marcoBotones";
    //$atributos["estiloEnLinea"]="display:none";
    echo $this->miFormulario->division("inicio", $atributos);

    //-------------Control Boton-----------------------
    $esteCampo = "noEncontroProcesos";
    $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
    $atributos["etiqueta"] = "";
    $atributos["estilo"] = "centrar";
    $atributos["tipo"] = 'error';
    $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
    echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos);

    $valorCodificado = "pagina=" . $miPaginaActual;
    $valorCodificado .= "&bloque=" . $esteBloque["id_bloque"];
    $valorCodificado .= "&bloqueGrupo=" . $esteBloque["grupo"];
    $valorCodificado = $cripto->codificar($valorCodificado);
    //-------------Fin Control Boton----------------------

    //------------------Fin Division para los botones-------------------------
    echo $this->miFormulario->division("fin");
    //------------------Division para los botones-------------------------
    $atributos["id"] = "botones";
    $atributos["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);

    //-------------Control Boton-----------------------
    $esteCampo = "regresar";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["tipo"] = "boton";
    $atributos["estilo"] = "jquery";
    $atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
    $atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["nombreFormulario"] = $nombreFormulario;
    echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);
    //-------------Fin Control Boton----------------------


    //------------------Fin Division para los botones-------------------------
    echo $this->miFormulario->division("fin");

    //-------------Control cuadroTexto con campos ocultos-----------------------
    //Para pasar variables entre formularios o enviar datos para validar sesiones
    $atributos["id"] = "formSaraData"; //No cambiar este nombre
    $atributos["tipo"] = "hidden";
    $atributos["obligatorio"] = false;
    $atributos["etiqueta"] = "";
    $atributos["valor"] = $valorCodificado;
    echo $this->miFormulario->campoCuadroTexto($atributos);
    unset($atributos);

    //Fin del Formulario
    echo $this->miFormulario->formulario("fin");
}
echo "<div class='datagrid'>
    <table align='center' id='proceso'>
        <tr align='center'>
            <td align='center'>
                <a href='" . $variableNuevo . "'>
                    <img src='" . $rutaBloque . "/images/new.png' width='45px'> <br> <b>Crear Nuevo <br>Proceso Electoral</b>
                </a>
            </td>
        </tr>
      </table></div> ";


