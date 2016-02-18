<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

$tab=1;
//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"]=$nombreFormulario;
$atributos["tipoFormulario"]="multipart/form-data";
$atributos["metodo"]="POST";
$atributos["nombreFormulario"]=$nombreFormulario;
$verificarFormulario="1";
echo $this->miFormulario->formulario("inicio",$atributos);

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

?>
<div name="divDatos" id="divDatos">
    <?php 
    
    
    //-------------Control Lista Desplegable-----------------------
    $esteCampo = "textoBitacora";
    $atributos["id"] = $esteCampo;
    $atributos["tabIndex"] = $tab++;
    $atributos["columnas"] = 50;
    $atributos["filas"] = 5;
    $atributos["estilo"] = "jqueryui";
	$atributos["textoEnriquecido"] = true;
    $atributos["etiqueta"] = $this->lenguaje->getCadena($esteCampo);
    echo $this->miFormulario->campoTextArea($atributos);
    unset($atributos);

    //------------------Division para los botones-------------------------
	$atributos["id"]="botones";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo="botonAceptar";
	$atributos["id"]=$esteCampo;
	$atributos["tabIndex"]=$tab++;
	$atributos["tipo"]="boton";
	$atributos["onclick"]="guardarNota('".$miSesion->getSesionUsuarioId()."')";
	$atributos["valor"]=$this->lenguaje->getCadena($esteCampo);
	$atributos["nombreFormulario"]=$nombreFormulario;
	echo $this->miFormulario->campoBoton($atributos);
	unset($atributos);
	//-------------Fin Control Boton----------------------
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
    
	$cadena_sql = $this->sql->cadena_sql("consultarNotas", $miSesion->getSesionUsuarioId());
	$registroNotas = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

        if($registroNotas)
            {
                $respuesta = "<table width='100%' class='jqueryui' border='1'>";	
                $respuesta .= "<tr>";
                $respuesta .= "<th>ID</th>";
                $respuesta .= "<th>Fecha</th>";
                $respuesta .= "<th>Nota</th>";
                $respuesta .= "</tr>";	

                for($i=0;$i<count($registroNotas);$i++)
                {
                        $respuesta .= "<tr>";
                        $respuesta .= "<td align='center'>".$registroNotas[$i][0]."</td>";
                        $respuesta .= "<td align='center'>".$registroNotas[$i][1]."</td>";
                        $respuesta .= "<td align='center'>".$registroNotas[$i][2]."</td>";
                        $respuesta .= "</tr>";	
                }
                $respuesta .= "</table>";	
            }else
                {
                    $respuesta = "No existen registros";
                }	
    ?>
    
    <div name="notasTodos" id="notasTodos" class="jqueryui"> 
        <?php echo $respuesta;?>
    </div>     
    
   
</div>    
 
    <?php
  

//Fin del Formulario
echo $this->miFormulario->formulario("fin");


?>
