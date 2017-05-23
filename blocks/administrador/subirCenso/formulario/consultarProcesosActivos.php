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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>";

        for($i=0;$i<count($resultadoProcesos);$i++)
        {
            $paginaSubirCenso = array("pagina"=>"subirCenso",
                                      "opcion"=>"elecciones",
                                      "usuario"=>$miSesion->getSesionUsuarioId(),
                                      "proceso"=>$resultadoProcesos[$i][7]
                                     );
            $paginaConsultarCenso = array("pagina"=>"subirCenso",
                                     "opcion"=>"consulta",
                                     "usuario"=>$miSesion->getSesionUsuarioId(),
                                     "proceso"=>$resultadoProcesos[$i][7]
                                    );
            $paginaSubirClaves = array("pagina"=>"subirCenso",
                                      "opcion"=>"cargarClaves",
                                      "usuario"=>$miSesion->getSesionUsuarioId(),
                                      "proceso"=>$resultadoProcesos[$i][7]
                                     );
            $botonSubirCenso = $this->miFormulario->enlaceBotonCifrado($paginaSubirCenso,"Cargar Censo");
            $botonConsultarCenso = $this->miFormulario->enlaceBotonCifrado($paginaConsultarCenso,"Consultar Censo");
            $parametro[0]=$resultadoProcesos[$i][7];
            $cadena_sql = $this->sql->cadena_sql("contarCensoProceso", $parametro);
            $resultadoCenso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            if($resultadoCenso && $resultadoCenso[0]['censo']>0)
                {$estilo='';}
            else{$estilo='disabled=true';}
            $botonSubirClaves = $this->miFormulario->enlaceBotonCifrado($paginaSubirClaves,"Cargar Contraseñas","",$estilo);

            echo "<tr>
                    <td>".$resultadoProcesos[$i][0]."</td>
                    <td>".$resultadoProcesos[$i][1]."</td>
                    <td>".$resultadoProcesos[$i][2]."</td>
                    <td>".$resultadoProcesos[$i][3]."</td>
                    <td>".$resultadoProcesos[$i][4]."</td>
                    <td>".$resultadoProcesos[$i][5]."</td>
                    <td>".$resultadoProcesos[$i][6]."</td>
                    <td>
                        $botonSubirCenso
                        $botonConsultarCenso
                        $botonSubirClaves 
                    </td>
                </tr>";
        }

        echo "</tbody>";
        echo "</table></div>";

}else
{
        //echo "<div id='plantilla'><a href='".$rutaBloque."/archivos/plantilla_censo.xls'><img src='".$rutaBloque."/images/excel.png'><br>Descargar Plantilla</a></div>";
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
echo "<div id='plantilla'><a href='".$rutaBloque."/archivos/plantilla_censo.xls'><img src='".$rutaBloque."/images/excel.png'><br>Descargar Plantilla</a></div>";


?>
