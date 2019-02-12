<?php
$directorio = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

if (!isset($GLOBALS["autorizado"])) {
    include("../index.php");
    exit;
}

//ini_set('display_errors', 0);
$datos = $this->miConfigurador->fabricaConexiones->crypto->decodificar($_REQUEST['datos']);
$datos = unserialize(urldecode($datos));
$datos = $datos[0];

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");
$nombreFormulario = $esteBloque["nombre"];

$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
$parametros['idUsuario']=$_REQUEST["idUsuario"];
$cadena_sql = $this->cadena_sql = $this->sql->cadena_sql("consultarVotante", $parametros);
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
//var_dump($resultadoProcesos);

	//-----------------Inicio de Conjunto de Controles----------------------------------------
	$atributos['id']='divListadoElecciones';
	$atributos['estilo']='';
	echo $this->miFormulario->division('inicio',$atributos);


	//-------------------------------Mensaje-------------------------------------
	$esteCampo = 'mensaje1';
	$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = 'jqueryui';
	$atributos["tipo"] = '';
	//$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);
	$atributos["mensaje"] = "Identificación: ".$resultadoProcesos[0]['identificacion']."";
	$atributos["mensaje"] .="<br>Nombre        : ".$resultadoProcesos[0]['nombre']."";
	$atributos["mensaje"] .= "<br>Identificación 2: ".$resultadoProcesos[0]['segunda_identificacion']."";
	
	echo $this->miFormulario->campoMensaje($atributos);
	unset($atributos);
	echo $this->miFormulario->campoEspacio();

	echo "<div><table id='tablaProcesosActivos'>";
	echo "<thead>
                <tr>
                    <th>Elección</th>
                    <th>Estamento</th>
                    <th>Tipo Elección</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>";

        foreach($resultadoProcesos as $key => $value)
		{   
                    if (isset($resultadoProcesos[$key][10]) &&  $resultadoProcesos[$key][10]=='Presencial') 
                        {$presencial=1;}
                    $mostrarHtml = "<tr>";
                    $mostrarHtml.= "<td>".$resultadoProcesos[$key][6]."</td>";
                    $mostrarHtml.= "<td>".$resultadoProcesos[$key][4]."</td>";
                    $mostrarHtml.= "<td>".$resultadoProcesos[$key][10]."</td>";

                            if(isset($resultadoProcesos[$key][8]) && $resultadoProcesos[$key][8] != '')
                                    {  $fechaVoto=date('Y/m/d h:i:sa',$resultadoProcesos[$key][8]);
                                           $mostrarHtml .= "<td>";
                                           $mostrarHtml .= $this->lenguaje->getCadena('yaVoto');
                                           $mostrarHtml .= "<br><b>".$fechaVoto."</b>";
                                           $mostrarHtml .= "</td>";
                                    }
                            elseif(isset($resultadoProcesos[$key][7]) && $resultadoProcesos[$key][7] == 1)
                                    {  $mostrarHtml .= "<td>";
                                           $mostrarHtml .= $this->lenguaje->getCadena('activo');
                                           $mostrarHtml .= "</td>";
                                    }
                           else { 	$fechaVoto=1;
                                        $mostrarHtml .= "<td>";
                                           $mostrarHtml .= $this->lenguaje->getCadena('inactivo');
                                           $mostrarHtml .= "</td>";
                                    }
                           $mostrarHtml .= "</tr>";
                           echo $mostrarHtml;
                           unset($mostrarHtml);
                           unset($variable);
		}
 
	echo "</tbody>";
	echo "</table></div>";

	//------------------Fin Division -------------------------
	echo $this->miFormulario->division("fin");

	$valorCodificado="pagina=index";
	$valorCodificado.="&action=".$esteBloque["nombre"];
	$valorCodificado.="&opcion=cambiarContrasena";
	$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
	$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];	
        $valorCodificado.="&idUsuario=" . $resultadoProcesos[0]['identificacion'];
	$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar($valorCodificado);


//---------------Inicio Formulario (<form>)--------------------------------
$atributos["id"] = $nombreFormulario;
$atributos["tipoFormulario"] = "multipart/form-data";
$atributos["metodo"] = "POST";
$atributos["nombreFormulario"] = $nombreFormulario;
$verificarFormulario = "1";
echo $this->miFormulario->formulario("inicio", $atributos);

//------------------Division para los botones-------------------------
$atributos["id"] = "botones";
$atributos["estilo"] = "marcoBotones";
echo $this->miFormulario->division("inicio", $atributos);

if ((!isset($fechaVoto) ||  $fechaVoto== '') && (isset($presencial) &&  $presencial==1)) {

//-------------Control Boton-----------------------
    $esteCampo = "botonClave";
    $atributos["verificar"] = "";
    $atributos["tipo"] = "boton";
    $atributos["id"] = $esteCampo;
    $atributos["cancelar"] = "true";
    $atributos["tabIndex"] = $tab++;
    $atributos["valor"] = $this->lenguaje->getCadena($esteCampo);
    $atributos["nombreFormulario"] = $nombreFormulario;
    //Se deshabilita boton, descomentar para habilitar
    echo $this->miFormulario->campoBoton($atributos);
    unset($atributos);
//-------------Fin Control Boton----------------------
}
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

//-------------Control cuadroTexto con campos ocultos-----------------------
//Para pasar variables entre formularios o enviar datos para validar sesiones
$atributos["id"] = "opcion"; //No cambiar este nombre
$atributos["tipo"] = "hidden";
$atributos["obligatorio"] = false;
$atributos["etiqueta"] = "";
$atributos["valor"] = "cambiarContrasena";
echo $this->miFormulario->campoCuadroTexto($atributos);
unset($atributos);

//Fin del Formulario
echo $this->miFormulario->formulario("fin");


?>
