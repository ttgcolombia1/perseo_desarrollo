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

$rutaHash = $this->miConfigurador->getVariableConfiguracion("raizDocumento");

$sha1File = sha1_file($rutaHash); 
echo "<br>Sha1 archivo ".$rutaHash."<br>".$sha1File;


$nombreFormulario=$esteBloque["nombre"];

$conexion="estructura";
$esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

$fechaActual = date('Y-m-d H:i:s'); 

$cadena_sql = $this->sql->cadena_sql("idioma", $fechaActual);
$resultadoIdioma = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");    

$cadena_sql = $this->sql->cadena_sql("consultarProcesosActivos", $fechaActual);
$resultadoProcesos = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

if($resultadoProcesos)
{
    echo "<div id='plantilla'><a href='".$rutaBloque."/archivos/plantilla_censo.xls'><img src='".$rutaBloque."/images/excel.png'><br>Descargar Plantilla</a></div>";
        echo "<div class='datagrid'><table id='tablaProcesosActivos'>";
        
        echo "<thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>                    
                    <th>Tipo Votación</th>
                    <th>Cantidad Elecciones</th>
                    <th>Acto Administrativo</th>
                    <th>Cargar</th>
                </tr>
            </thead>
            <tbody>";
        
        for($i=0;$i<count($resultadoProcesos);$i++)
        {
            $variable = "pagina=subirCenso"; //pendiente la pagina para modificar parametro                                                        
            $variable.= "&opcion=elecciones";
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
                    <td>
                        <button type='button' onclick=\"location.replace('".$variable."')\">Cargar Censo</button> 
                    </td>
                </tr>";
            unset($variable);
        }
               
        echo "</tbody>";
        
        echo "</table></div>";	
   
}else
{
        echo "<div id='plantilla'><a href='".$rutaBloque."/archivos/plantilla_censo.xls'><img src='".$rutaBloque."/images/excel.png'><br>Descargar Plantilla</a></div>";
	$atributos["id"]="divNoEncontroEgresado";
	$atributos["estilo"]="marcoBotones";
   //$atributos["estiloEnLinea"]="display:none"; 
	echo $this->miFormulario->division("inicio",$atributos);
	
	//-------------Control Boton-----------------------
	$esteCampo = "noEncontroProcesos";
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