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

$cadena_sql = $this->sql->cadena_sql("idioma", '');
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    
   
$cadena_sql = $this->sql->cadena_sql("consultarProcesos", '');
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoProcesos)
{	
    $atributos["id"]="accordion";
    $atributos["estilo"]="marcoBotones";
    echo $this->miFormulario->division("inicio",$atributos);
    
    for($i=0;$i<count($resultadoProcesos);$i++)
        {
            $atributos["id"]=$resultadoProcesos[$i]['idprocesoelectoral'];
            $atributos["estilo"]="group";
            echo $this->miFormulario->division("inicio",$atributos);
            echo "<h3>".$resultadoProcesos[$i]['nombre']."</h3>";
            
            $atributos["id"]="espacio".$i;
            $atributos["estilo"]="marcoGrupo";
            echo $this->miFormulario->division("inicio",$atributos);
            
            $cadena_sql = $this->sql->cadena_sql("eleccionesProceso",$resultadoProcesos[$i]['idprocesoelectoral']);
            $resultadoElecciones = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
             
            if($resultadoElecciones)
                {
                    echo "<div class='datagrid'><table id='tablaElecciones".$resultadoProcesos[$i]['idprocesoelectoral']."'>";
                    echo "<caption>Hora Actual del Servidor: ".date('Y-m-d H:i:s')."</caption>";
                    echo "<thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Final</th>                    
                                <th>Decodificar Votos</th>
                                <th>Ver Resultados</th>
                                <th>Acta de Cierre</th>
                            </tr>
                        </thead>
                        <tbody>";
                    for($j=0;$j<count($resultadoElecciones);$j++)
                    {
                        echo "<tr>
                                <td>".$resultadoElecciones[$j]['nombre']."</td>
                                <td>".$resultadoElecciones[$j]['descripcion']."</td>
                                <td>".$resultadoElecciones[$j]['fechainicio']."</td>
                                <td>".$resultadoElecciones[$j]['fechafin']."</td>
                             ";
                        
                        $cadena_sql = $this->sql->cadena_sql("verificarDecodificados",$resultadoElecciones[$j]['ideleccion']);
                        $resultadoDecodificados = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");    
                        
                        if($resultadoDecodificados)
                            {
                                $variableResultados = "pagina=cerrarProceso"; //pendiente la pagina para modificar parametro                                                        
                                $variableResultados.= "&opcion=verResultadosEleccion";
                                $variableResultados.= "&usuario=" . $miSesion->getSesionUsuarioId();
                                $variableResultados.= "&eleccion=" .$resultadoElecciones[$j]['ideleccion'] ;
                                $variableResultados.= "&proceso=" .$resultadoProcesos[$i]['idprocesoelectoral'];
                                $variableResultados = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableResultados, $directorio);
                                
                                $variableActa = "pagina=cerrarProceso"; //pendiente la pagina para modificar parametro                                                        
                                $variableActa.= "&opcion=actaCierre";
                                $variableActa.= "&usuario=" . $miSesion->getSesionUsuarioId();
                                $variableActa.= "&eleccion=" .$resultadoElecciones[$j]['ideleccion'] ;
                                $variableActa.= "&proceso=" .$resultadoProcesos[$i]['idprocesoelectoral'];
                                $variableActa = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableActa, $directorio);
                                
                                echo "<td>
                                        Votos Decodificados
                                      </td>
                                      <td>
                                        <button type='button' onclick=\"location.replace('".$variableResultados."')\">
                                            Ver Resultados
                                        </button>                                        
                                      </td>
                                      <td>
                                        <button type='button' onclick=\"location.replace('".$variableActa."')\" >
                                            Generar Acta de Cierre
                                        </button>                                        
                                      </td>";
                            }else
                                {
                                    $variableCerrar = "pagina=cerrarProceso"; //pendiente la pagina para modificar parametro                                                        
                                    $variableCerrar.= "&opcion=cerrarPorEleccion";
                                    $variableCerrar.= "&usuario=" . $miSesion->getSesionUsuarioId();
                                    $variableCerrar.= "&eleccion=" .$resultadoElecciones[$j]['ideleccion'] ;
                                    $variableCerrar.= "&nombreEleccion=" .$resultadoElecciones[$j]['nombre'] ;
                                    $variableCerrar.= "&proceso=" .$resultadoProcesos[$i]['idprocesoelectoral'];
                                    $variableCerrar = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableCerrar, $directorio);
                                    
                                   
                                    
                                    if($resultadoElecciones[$j]['fechafinbd'] >= date('Y-m-d H:i:s'))
                                        {
                                            echo "<td>
                                                    No se ha finalizado la elección
                                                </td>";
                                        }else
                                            {   $cadena_sql = $this->sql->cadena_sql("contarVotosCodificados",$resultadoElecciones[$j]['ideleccion']);
                                                $resultadocodificado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                                                unset($desabilita);
                                                if(isset($resultadocodificado) && $resultadocodificado[0]['total']>0)
                                                    { $deshabilita = "";
                                                      $mensaje = "Decodificar Votos";}
                                                else{ $deshabilita = "disabled='true'";
                                                      $mensaje = "No hay Votos registrados";}    
                                                echo "<td>
                                                        <button type='button' $deshabilita  onclick=\"location.replace('".$variableCerrar."')\" >
                                                            $mensaje
                                                        </button>                                                        
                                                      </td>";
                                                
                                            }
                                            echo "<td>
                                                    No hay votos decodificados
                                                  </td>
                                                  <td>
                                                    No hay votos decodificados
                                                  </td>";
                                }
                                
                        echo "</tr>";
                                               
                        unset($variableCerrar);
                        unset($variableResultados);
                    }
                    echo "</table></div>";
                    
                    $variableTodos = "pagina=cerrarProceso"; //pendiente la pagina para modificar parametro                                                        
                    $variableTodos.= "&opcion=cerrarTodos";
                    $variableTodos.= "&usuario=" . $miSesion->getSesionUsuarioId();
                    $variableTodos.= "&proceso=" .$resultadoProcesos[$i]['idprocesoelectoral'];
                    $variableTodos = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variableTodos, $directorio);

                    unset($variableTodos);
                    
                }else
                    {
                        $atributos["id"]="divNoEncontroElecciones";
                        $atributos["estilo"]="marcoBotones";
                   //$atributos["estiloEnLinea"]="display:none"; 
                        echo $this->miFormulario->division("inicio",$atributos);

                        //-------------Control Boton-----------------------
                        $esteCampo = "noEncontroEgresado";
                        $atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
                        $atributos["etiqueta"] = "";
                        $atributos["estilo"] = "centrar";
                        $atributos["tipo"] = 'error';
                        $atributos["mensaje"] = "No se encontraron elecciones para este proceso electoral";
                        echo $this->miFormulario->cuadroMensaje($atributos);
                        unset($atributos); 
                        //-------------Fin Control Boton----------------------

                        //------------------Fin Division para los botones-------------------------
                        echo $this->miFormulario->division("fin");
                    }            
            echo $this->miFormulario->division("fin");
            echo $this->miFormulario->division("fin");
        }
    
    echo $this->miFormulario->division("fin");

   
}else
{
	$atributos["id"]="divNoEncontroEgresado";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroEgresado";
	$atributos["id"] = $esteCampo; //Cambiar este nombre y el estilo si no se desea mostrar los mensajes animados
	$atributos["etiqueta"] = "";
	$atributos["estilo"] = "centrar";
	$atributos["tipo"] = 'error';
	$atributos["mensaje"] = "No se encontraron procesos electorales activos";
	echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos); 
	//-------------Fin Control Boton----------------------
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
}
    

?>
