<?php

//Evitar un acceso directo a este archivo
if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.= $this->miConfigurador->getVariableConfiguracion("enlace");

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];
//$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("urlCandidatos");

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

include_once("core/crypto/Encriptador.class.php");
$cripto = Encriptador::singleton();
$valorCodificado = "action=" . $esteBloque["nombre"];
$valorCodificado.="&opcion=registrarVoto";
$valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado = $cripto->codificar($valorCodificado);

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("listaTarjetones", $_REQUEST['eleccion']);
$resultadoTarjeton = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$cadena_sql = $this->sql->cadena_sql("infoEleccion", $_REQUEST['eleccion']);
$resultadoInfoEleccion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);



$tab = 0;

if ($resultadoTarjeton) {
    //------------------Division para los botones-------------------------
    $atributos["id"] = "botones";
    $atributos["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);

    //-------------Control Boton-----------------------
    $esteCampo = "botonAceptar";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["tipo"] = "boton";
    $atributos["estilo"] = '';
    $atributos['estiloEnLinea'] = 'width:120px; height:60px; font-size:1.5em';
    $atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
    $atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["nombreFormulario"] = $nombreFormulario;
    echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);
    //-------------Fin Control Boton----------------------
    //------------------Fin Division para los botones-------------------------
    echo $this->miFormulario->division("fin");

    $atributos["id"] = "Tarjeton";
    $atributos["estilo"] = "marcoBotones";
    echo $this->miFormulario->division("inicio", $atributos);

    echo "<table width='100%'>";
    echo "<caption>
                <font size='3'>
                    <b>
                    " . strtoupper($resultadoInfoEleccion[0][0]) . "
                    </b>
                </font>
            </caption>";

    if (isset($resultadoInfoEleccion[0]['listatarjeton'])) {
        $listasPorFila = $resultadoInfoEleccion[0]['listatarjeton'];
    } else {

        $listasPorFila = 3;
    }
    $porcentajeLista = 100 / $listasPorFila;

    $idLista = 0;
    $eleActual = '';
    for ($i = 0; $i < count($resultadoTarjeton); $i++) {

        if (($i % $listasPorFila) == 0) {
            if ($i > 0) {
                echo "</tr>";
            }
            echo "<tr heigth='200px'>";
        }
        if ($resultadoTarjeton[$i][0] != $eleActual) {
            $arregloCandidatos = array($_REQUEST['eleccion'], $resultadoTarjeton[$i][0]);

            $cadena_sql = $this->sql->cadena_sql("listaCandidatos", $arregloCandidatos);
            $resultadoCandidatos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

            $voto = $cripto->codificar($_REQUEST['eleccion'] . "-" . $resultadoTarjeton[$i][0]);

            echo "<td width='" . $porcentajeLista . "%'  class='fondoLimpio' id='seleccion" . $idLista . "' onclick='seleccionarTarjeton(this.id,\"" . $voto . "\");'>";
            $idLista++;
            echo "<center><font size='5'><b>" . $resultadoTarjeton[$i][1] . "</b></font></center>";
            $atributos["id"] = "lista" . $idLista;
            $atributos["estilo"] = "marcoBotones";
            echo $this->miFormulario->division("inicio", $atributos);

            echo "<table width='100%'>";
            echo "<tr id='candidatos'>";

            for ($n = 0; $n < count($resultadoCandidatos); $n++) {
                switch ($n) {
                    case 0;
                        $posicCandidato = "Principal";
                        break;
                    case 1;
                        $posicCandidato = "Suplente";
                        break;
                    default:
                        $posicCandidato = "Candidato " . ($n + 1);
                        break;
                }
                echo "<td >
                                            
                                            <p>" . $posicCandidato . "</p>
                                            
                                            <img src='" . $directorio . $resultadoCandidatos[$n][5] . "' title='" . $resultadoCandidatos[$n][3] . " " . $resultadoCandidatos[$n][4] . "' height='150px' width='113px'>
                                            
                                            <p>" . $resultadoCandidatos[$n][3] . " " . $resultadoCandidatos[$n][4] . "</p>
                                        </td>";
            }
            echo "</tr>";
            echo "</table>";

            echo $this->miFormulario->division("fin", $atributos);
            echo "</td>";
            $eleActual = $resultadoTarjeton[$i][0];
        }
    }

    echo "</table>";

    echo $this->miFormulario->division("fin", $atributos);
}


//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

//-------------Control Boton-----------------------
$esteCampo = "botonAceptar";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["tipo"] = "boton";
$atributos["estilo"] = "jquery-ui";
$atributos['estiloEnLinea'] = 'width:120px; height:60px; font-size:1.5em';
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
$atributos["id"] = "candidatoSeleccionado"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = true;
$atributos["etiqueta"] = "";
$atributos["validar"] = "required";
$atributos["valor"] = "";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

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

//  exit;
?>
