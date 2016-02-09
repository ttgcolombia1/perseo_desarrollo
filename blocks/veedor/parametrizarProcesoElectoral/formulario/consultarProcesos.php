<?

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

//validamos los datos que llegan

if(isset($_REQUEST['nombreProceso']) && $_REQUEST['nombreProceso']!='')
    {
        $nombreProceso = $_REQUEST['nombreProceso'];
    }else
        {
            $nombreProceso = "";
        }
if(isset($_REQUEST['fechaInicio']) && $_REQUEST['fechaInicio']!='')
    {
        $fechaInicioProceso = $_REQUEST['fechaInicio'];
    }else
        {
            $fechaInicioProceso = "";
        }
if(isset($_REQUEST['tipovotacion']) && $_REQUEST['tipovotacion']!='')
    {
        $tipoVotacionProceso = $_REQUEST['tipovotacion'];
    }

    $arreglo = array($nombreProceso,$fechaInicioProceso,$tipoVotacionProceso);

$cadena_sql = $this->sql->cadena_sql("idioma", $arreglo);
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    
   
$cadena_sql = $this->sql->cadena_sql("consultarProcesos", $arreglo);
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoProcesos)
{	
        echo "<table id='tablaProcesos'>";
        
        echo "<thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>                    
                    <th>Tipo Votación</th>
                    <th>Cantidad Elecciones</th>
                    <th>Acto Administrativo</th>
                    <th>Parametrizar</th>
                </tr>
            </thead>
            <tbody>";
        
        for($i=0;$i<count($resultadoProcesos);$i++)
        {
            $variable = "pagina=parametrizarProcesoElectoral"; //pendiente la pagina para modificar parametro                                                        
            $variable.= "&opcion=parametrizar";
            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
            $variable.= "&proceso=" .$resultadoProcesos[$i][7];
            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
            
            echo "<tr>
                    <td>".$resultadoProcesos[$i][0]."</td>
                    <td>".$resultadoProcesos[$i][1]."</td>
                    <td>".$resultadoProcesos[$i][2]."</td>
                    <td>".$resultadoProcesos[$i][3]."</td>
                    <td>".$resultadoProcesos[$i][4]."</td>
                    <td>".$resultadoProcesos[$i][5]."</td>
                    <td>".$resultadoProcesos[$i][6]."</td>
                    <td><a href='".$variable."'>                        
                        <img src='".$rutaBloque."/images/edit.png' width='15px'> 
                        </a></td>
                </tr>";
            unset($variable);
        }
               
        echo "</tbody>";
        
        echo "</table>";	
   
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
	$atributos["mensaje"] = $this->lenguaje->getCadena($esteCampo);;
	echo $this->miFormulario->cuadroMensaje($atributos);
    unset($atributos); 
	//-------------Fin Control Boton----------------------
	
	//------------------Fin Division para los botones-------------------------
	echo $this->miFormulario->division("fin");
}
    

?>