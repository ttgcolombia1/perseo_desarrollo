<?php 

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];

$valorCodificado="&action=" . $esteBloque["nombre"];
$valorCodificado.="&opcion=procesarSegundaClave";
$valorCodificado.="&bloque=" . $esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=" . $esteBloque["grupo"];
$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);

$tab = 1;
//------------------Division para los botones-------------------------
$atributos["id"]="divformuClave";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio",$atributos);


//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);
unset($atributos);


//-----------------Inicio de Conjunto de Controles-------------------------
$esteCampo = "marcoClave";
$atributos["estilo"] = "jqueryui";
$atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);


//-------------Control cuadroTexto-------------------------------------
$esteCampo = "clave";
$atributos["id"] = $esteCampo;
$atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
$atributos["etiquetaObligatorio"] = true;
$atributos["tabIndex"] = $tab++;
$atributos["obligatorio"] = true;
$atributos["tamanno"] = "4";
$atributos["tipo"] = "";
$atributos["estilo"] = "jqueryui";
$atributos["columnas"] = "1"; //El control ocupa 32% del tamaño del formulario
$atributos["validar"] = "required, minSize[4], maxSize[4], custom[integer], number";
$atributos["categoria"] = "";
$atributos["tipo"] = "password";
$atributos["deshabilitado"] = true;
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);
//------------------Fin Division para las pestañas-------------------------
echo $this->miFormulario->division("fin");
//------------------Division para los botones-------------------------
$atributos["id"]="digitaClave";
$atributos["estilo"]="marcoBotones";
echo $this->miFormulario->division("inicio",$atributos);
//--------------------- Creación de la grilla de clave ---------------------------------------
echo "<div align='center'>";

$valores = array(9);
$j = 0;

do {
    $numero = rand(0, 9);
    if (!in_array($numero, $valores)) {
        $valores[$j] = $numero;


        echo "<input class='botonTeclado' onclick=\"escribirClave('" . $numero . "')\" type='button' value='" . $numero . "' name='numero" . $numero . "' id='numero" . $numero . "'>";
        $j++;
        if (($j % 3) == 0) {
            echo "<br>";
        }
    }
} while ($j < 10);

echo "<input class='botonTeclado' onclick=\"reiniciar(this)\" type='button' value='Limpiar' name='limpiar' id='lipiar'>";

echo "</div>";

//------------------Fin Division para los botones-------------------------
echo $this->miFormulario->division("fin");

//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

//-------------Control Boton-----------------------
$esteCampo = "botonContinuarSegundaClave";
$atributos["id"] = $esteCampo;
$atributos["tabIndex"] = $tab++;
$atributos["tipo"] = "boton";
$atributos["estilo"] = "";
$atributos["verificar"] = "true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
$atributos["tipoSubmit"] = "jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
$atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
$atributos["nombreFormulario"] = $nombreFormulario;
echo $this->miFormulario->campoBoton($atributos);
unset($atributos);
//-------------Fin Control Boton----------------------
//
//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"] = "eleccion"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = false;
$atributos["etiqueta"] = "";
$atributos["valor"] = $_REQUEST['eleccion'];
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
?>

<script language="Javascript" type="text/javascript">
    var contador = 0;
</script>

