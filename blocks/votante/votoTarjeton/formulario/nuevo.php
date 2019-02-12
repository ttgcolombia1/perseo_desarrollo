<?php

if (!isset($GLOBALS["autorizado"])) {
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

$nombreFormulario=$esteBloque["nombre"];

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$cadena_sql = $this->sql->cadena_sql("consultarProcesosVotante", $miSesion->getSesionUsuarioId());
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoProcesos)
{	
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
        $atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->campoMensaje($atributos);
        unset($atributos);
        
        echo $this->miFormulario->campoEspacio();
        
    
        echo "<div class='datagrid'><table id='tablaProcesosActivos'>";
        echo "<thead>
                <tr>
                    <th>Proceso Electoral</th>
                    <th>Elección</th>                    
                    <th>Fecha Inicial</th>                    
                    <th>Fecha Final</th>                    
                    <th>Votar</th>
                    <th>Certificado</th>
                </tr>
            </thead>
            <tbody>";
        
        for($i=0;$i<count($resultadoProcesos);$i++)
        {
            $variable = "pagina=votacionesVotante"; //pendiente la pagina para modificar parametro                                                        
            $variable.= "&opcion=votar";
            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
            $variable.= "&eleccion=" . $resultadoProcesos[$i][2];
            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
            
            $variableCertificado = "pagina=votacionesVotante"; //pendiente la pagina para modificar parametro                                                        
            $variableCertificado.= "&action=".$esteBloque["nombre"];
            $variableCertificado.= "&bloque=" . $esteBloque["id_bloque"];
            $variableCertificado.= "&bloqueGrupo=" . $esteBloque["grupo"];
            $variableCertificado.= "&opcion=certificado";
            $variableCertificado.= "&usuario=" . $miSesion->getSesionUsuarioId();
            $variableCertificado.= "&eleccion=" . $resultadoProcesos[$i][2];
            $variableCertificado = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableCertificado, $directorio);
            
            
            $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            
            
            $hora=date('h:i A',strtotime($resultadoProcesos[$i]['elefechainicio']));
            $dia= date('d',strtotime($resultadoProcesos[$i]['elefechainicio']));
            $mes= $meses[date('n',strtotime($resultadoProcesos[$i]['elefechainicio']))-1];
            $anno= date('Y',strtotime($resultadoProcesos[$i]['elefechainicio']));
            
            $fechaInicio=$hora." del ".$dia.' de '.$mes.' de '.$anno;
            
            $hora=date('h:i A',strtotime($resultadoProcesos[$i]['elefechafin']));
            $dia= date('d',strtotime($resultadoProcesos[$i]['elefechafin']));
            $mes= $meses[date('n',strtotime($resultadoProcesos[$i]['elefechafin']))-1];
            $anno= date('Y',strtotime($resultadoProcesos[$i]['elefechafin']));
            
            $fechaFin=$hora." del ".$dia.' de '.$mes.' de '.$anno;
            
            
            
            
            
            $mostrarHtml = "<tr>
                    <td>".$resultadoProcesos[$i][6]."</td>
                    <td>".$resultadoProcesos[$i][8]."</td>
                    <td>".$fechaInicio."</td>
                    <td>".$fechaFin."</td>
                    <td>";
            if($resultadoProcesos[$i][5] != '')
                {
                     $mostrarHtml .= $this->lenguaje->getCadena('yaVoto');;
                     $mostrarHtml .= "</td>";
                     $mostrarHtml .= "<td>";
                     $mostrarHtml .= "<button type='button' onclick=\"location.replace('".$variableCertificado."')\" >
                                        Generar Certificado
                                      </button>";
                     $mostrarHtml .= "</td>";
                }else
                    {
                    $mostrarHtml .= "<button type='button' onclick=\"location.replace('".$variable."')\" >
                                        Votar
                                      </button>";
                     $mostrarHtml .= "</td>";
                     $mostrarHtml .= "<td>";
                     $mostrarHtml .= $this->lenguaje->getCadena('noHaVotado');
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
   
}else
{
	$atributos["id"]="divNoEncontroEgresado";
	$atributos["estilo"]="marcoBotones";
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroEgresado";
	$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = 'error';
	$atributos["mensaje"] = "No existen procesos activos";
	echo $this->miFormulario->cuadroMensaje($atributos);
        unset($atributos); 
	//-------------Fin Control Boton----------------------
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
}
    

?>