<?php

if(!isset($GLOBALS["autorizado"])) {
	include("../index.php");
	exit;
}
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

//$directorio = $this->miConfigurador->getVariableConfiguracion("host");
//$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
//$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque");

$directorioEnlace = $this->miConfigurador->getVariableConfiguracion("host");
$directorioEnlace.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorioEnlace.=$this->miConfigurador->getVariableConfiguracion("enlace");

include_once("core/crypto/Encriptador.class.php");
$cripto=Encriptador::singleton();
$valorCodificado="action=".$esteBloque["nombre"];
$valorCodificado.="&opcion=guardarEleccion"; 
$valorCodificado.="&bloque=".$esteBloque["id_bloque"];
$valorCodificado.="&bloqueGrupo=".$esteBloque["grupo"];
$valorCodificado=$cripto->codificar($valorCodificado);
$directorio=$this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/imagen/";

$miSesion = Sesion::singleton();
$nombreFormulario="Eleccion".$idEleccion;

$arrayEleccion = array($proceso, $idEleccion);

$this->cadena_sql = $this->sql->cadena_sql("consultaEleccion", $arrayEleccion);
$resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
        
        $tab=1;
        //---------------Inicio Formulario (<form>)--------------------------------
        $atributos["id"]=$nombreFormulario;
        $atributos["tipoFormulario"]="multipart/form-data";
        $atributos["metodo"]="POST";
        $atributos["nombreFormulario"]=$nombreFormulario;
        $atributos["titulo"]=$nombreFormulario;
        echo $this->miFormulario->formulario("inicio",$atributos); 
        unset($atributos);
       
    //-------------Control cuadroTexto-----------------------
	$esteCampo="nombreEleccion".$idEleccion;
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]="Digite el nombre de la elección: ";
	$atributos["titulo"]="Digite el nombre de la elección ";
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]=40;
        $atributos["columnas"] = 1;
        $atributos["etiquetaObligatorio"] = false;
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
        $atributos["anchoEtiqueta"] = 250;
	$atributos["validar"]="required, minSize[5]";
	$atributos["categoria"]="";
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["valor"] = $resultadoEleccion[0]['nombre'];
            }
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
        
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "tipoestamento".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["tabIndex"] = $tab++;        
        $atributos["evento"] = 2;
        $atributos["columnas"] = "1";
        $atributos["limitar"] = false;
        $atributos["tamanno"] = 1;
        $atributos["ancho"] = "250px";
        $atributos["estilo"] = "jqueryui";
        $atributos["etiquetaObligatorio"] = true;
        $atributos["validar"] = "required";
        $atributos["anchoEtiqueta"] = 250;
        $atributos["obligatorio"] = true;
        $atributos["etiqueta"] = "Tipo de estamento: ";
        
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["seleccion"] = $resultadoEleccion[0]['tipoestamento'];
            }
        
        //-----De donde rescatar los datos ---------
        $atributos["cadena_sql"] = $this->sql->cadena_sql("tipoestamento");
        $atributos["baseDatos"] = "estructura";
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
        
        //-------------Control cuadroTexto-----------------------
	$esteCampo="descripcion".$idEleccion;
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]="Digite la descripción de la elección: ";
	$atributos["titulo"]="Digite la descripción de la elección ";
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]=40;
        $atributos["etiquetaObligatorio"] = true;
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
        $atributos["anchoEtiqueta"] = 250;
	$atributos["validar"]="required, minSize[5]";
	$atributos["categoria"]="";
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["valor"] = $resultadoEleccion[0]['descripcion'];
            }
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
   
        
    //-------------Control cuadroTexto-----------------------
	$esteCampo="fechaInicio".$idEleccion;
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]="Fecha de inicio: ";
	$atributos["titulo"]="Fecha de inicio de la elección ";
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]=25;
        $atributos["etiquetaObligatorio"] = true;
        $atributos["deshabilitado"] = true;
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
        $atributos["anchoEtiqueta"] = 250;
	$atributos["validar"] = "required";
	$atributos["categoria"]="fecha";
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["valor"] = $resultadoEleccion[0]['fechainicio'];
            }
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos); 
        
        //-------------Control cuadroTexto-----------------------
	$esteCampo="fechaFin".$idEleccion;
	$atributos["id"]=$esteCampo;
	$atributos["etiqueta"]="Fecha de finalización: ";
	$atributos["titulo"]="Fecha de finalización de la elección ";
	$atributos["tabIndex"]=$tab++;
	$atributos["obligatorio"]=true;
	$atributos["tamanno"]=25;
        $atributos["etiquetaObligatorio"] = true;
        $atributos["deshabilitado"] = true;
	$atributos["tipo"]="";
	$atributos["estilo"]="jqueryui";
        $atributos["anchoEtiqueta"] = 250;
	$atributos["validar"]="required";
	$atributos["categoria"]="fecha";
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["valor"] = $resultadoEleccion[0]['fechafin'];
            }
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);  
              
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "restricciones".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["nombre"] = "restricciones".$idEleccion."[]";
        $atributos["tabIndex"] = $tab++;
        $atributos["seleccion"] = 0;
        $atributos["evento"] = 2;
        $atributos["columnas"] = "1";
        $atributos["limitar"] = false;
        $atributos["tamanno"] = 1;
        $atributos["ancho"] = 550;
        $atributos["estilo"] = "jqueryui";
        $atributos["etiquetaObligatorio"] = true;
        $atributos["anchoEtiqueta"] = 250;
        $atributos["validar"] = "required,minListOptions[1]";
        $atributos["multiple"] = true;
        $atributos["obligatorio"] = true;
        $atributos["etiqueta"] = "Restricciones";
        
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["seleccion"] = $resultadoEleccion[0]['restricciones'];
            }
        //-----De donde rescatar los datos ---------
        $atributos["cadena_sql"] = $this->sql->cadena_sql("datosRestricciones");
        $atributos["baseDatos"] = "estructura";
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
        
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "segundaClave".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["nombre"] = $esteCampo;
        $atributos["tabIndex"] = $tab++;
        $atributos["etiquetaObligatorio"] = true;
        $atributos["anchoEtiqueta"] = 250;
        $atributos["validar"] = "required";
        $atributos["obligatorio"] = true;
        $atributos["etiqueta"] = "Uso segunda clave:";
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["seleccionado"] = true;
                if($resultadoEleccion[0]['utilizarsegundaclave'] == 1)
                    {
                        $atributos["valor"] = "on";                        
                    }else
                        {
                            $atributos["valor"] = "off";   
                        }
                
            }
        echo $this->miFormulario->campoCuadroSeleccion($atributos);
        unset($atributos);
        
        //------------------Control Lista Desplegable------------------------------
        $esteCampo = "tipovotacion".$idEleccion;
        $atributos["id"] = $esteCampo;
        $atributos["tabIndex"] = $tab++;
        $atributos["seleccion"] = 0;
        $atributos["evento"] = 2;
        $atributos["columnas"] = "1";
        $atributos["limitar"] = false;
        $atributos["tamanno"] = 1;
        $atributos["ancho"] = "250px";
        $atributos["estilo"] = "jqueryui";
        $atributos["etiquetaObligatorio"] = true;
        $atributos["validar"] = "required";
        $atributos["anchoEtiqueta"] = 250;
        $atributos["obligatorio"] = true;
        $atributos["etiqueta"] = "Tipo de Votación";
        if($resultadoEleccion)
            {
                $atributos["deshabilitado"] = true;
                $atributos["seleccion"] = $resultadoEleccion[0]['tipovotacion'];
            }
        //-----De donde rescatar los datos ---------
        $atributos["cadena_sql"] = $this->sql->cadena_sql("tipovotacion");
        $atributos["baseDatos"] = "estructura";
        echo $this->miFormulario->campoCuadroLista($atributos);
        unset($atributos);
        
        //------------------Division para los botones-------------------------
        $atributos["id"]="gestionar";
        $atributos["estilo"]="marcoBotones";
        echo $this->miFormulario->division("inicio",$atributos);

 
        //-----------------Inicio de Conjunto de Controles----------------------------------------
        $esteCampo = "marcoDatosCandidatos";
        $atributos["estilo"] = "jqueryui";
        $atributos["leyenda"] = $this->lenguaje->getCadena($esteCampo);
        echo $this->miFormulario->marcoAGrupacion("inicio", $atributos);
        unset($atributos);
        
        if($resultadoEleccion)
            {
                $arrayCandidatos = array($proceso, $resultadoEleccion[0]['ideleccion']);

                $this->cadena_sql = $this->sql->cadena_sql("consultaCandidatos", $arrayCandidatos);
                $resultadoCandidatos = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");
            
            }
        
        
        ?>
        
        <table id="tablaCandidatos<?php echo $idEleccion?>" width="100%">
	<!-- Cabecera de la tabla -->
	<thead>
		<tr>
			<th>Lista</th>
			<th>Posición</th>
			<th>Identificación</th>
			<th>Nombres</th>
			<th>Apellidos</th>
			<th>Borrar</th>
		</tr>
	</thead>
 
	<!-- Cuerpo de la tabla con los campos -->
	<tbody> 
            
                <?php
                
                if($resultadoEleccion)
                {
                    if($resultadoCandidatos)
                    {
                        for($can = 0; $can < count($resultadoCandidatos); $can++)
                        {
                            ?>
                                
                            <tr>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][0]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][1]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][2]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][3]?>
                                </td>
                                <td>
                                    <?php echo $resultadoCandidatos[$can][4]?>
                                </td>
                            </tr>        
            
                            <?
                        }
                    }
                }
                ?>
               	<!-- fila base para clonar y agregar al final -->
		<tr class="fila-base">
                        <td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="nombreLista".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=10;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[3]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="identificacion" name='identificacion<?php echo $idEleccion;?>[]' id='identificacion<?php echo $idEleccion;?>[]'/>-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="posicionLista".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=2;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, custom[integer]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="nombres" name='nombres<?php echo $idEleccion;?>[]' id='nombres<?php echo $idEleccion;?>[]' />-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="identificacion".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=15;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[5], custom[integer]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="identificacion" name='identificacion<?php echo $idEleccion;?>[]' id='identificacion<?php echo $idEleccion;?>[]'/>-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="nombres".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=15;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[5]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="nombres" name='nombres<?php echo $idEleccion;?>[]' id='nombres<?php echo $idEleccion;?>[]' />-->
                        </td>
			<td>
                            <?php                             
                            //-------------Control cuadroTexto-----------------------
                            $esteCampo="apellidos".$idEleccion."[]";
                            $atributos["id"]=$esteCampo;
                            $atributos["tabIndex"]=$tab++;
                            $atributos["obligatorio"]=true;
                            $atributos["tamanno"]=15;
                            $atributos["columnas"] = 1;
                            $atributos["etiquetaObligatorio"] = false;
                            $atributos["tipo"]="";
                            $atributos["estilo"]="jqueryui";
                            $atributos["anchoEtiqueta"] = 250;
                            $atributos["validar"]="required, minSize[5]";
                            $atributos["categoria"]="";
                            echo $this->miFormulario->campoCuadroTexto($atributos);
                            unset($atributos);
                            
                            ?>
                            <!--<input type="text" class="apellidos" name='apellidos<?php echo $idEleccion;?>[]' id='apellidos<?php echo $idEleccion;?>[]' />-->
                        </td>			
			<td class="eliminar"><img src='<?php echo $rutaBloque."/images/cancel.png"?>'></td>
		</tr>
		<!-- fin de código: fila base -->
	</tbody>
</table>
<?php

if(!$resultadoEleccion)
{
?>
<!-- Botón para agregar filas -->
<input type="button" id="agregar<?php echo $idEleccion?>" value="Agregar Candidato" onclick="agregarfila('<?php echo $idEleccion?>')" />
<?php
}
?>        
        <?php
        //Fin de Conjunto de Controles
        echo $this->miFormulario->marcoAGrupacion("fin");
        
        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
        
        
        //------------------Division para los botones-------------------------
        $atributos["id"]="botones";
        $atributos["estilo"]="marcoBotones";
        echo $this->miFormulario->division("inicio",$atributos);
        
        if(!$resultadoEleccion)
            {
                //-------------Control Boton-----------------------
                $esteCampo="guardar";
                $atributos["id"]=$esteCampo;
                $atributos["tabIndex"]=$tab++;
                $atributos["tipo"]="boton";
                $atributos["estilo"]="jqueryui";
                $atributos["verificar"]="true"; //Se coloca true si se desea verificar el formulario antes de pasarlo al servidor.
                $atributos["tipoSubmit"]="jquery"; //Dejar vacio para un submit normal, en este caso se ejecuta la función submit declarada en ready.js
                $atributos["valor"]="Guardar Elección";
                $atributos["nombreFormulario"]=$nombreFormulario;
                echo $this->miFormulario->campoBoton($atributos);
                unset($atributos);
            }
        //-------------Fin Control Boton----------------------

        //------------------Fin Division para los botones-------------------------
        echo $this->miFormulario->division("fin");
               
        //-------------Control cuadroTexto con campos ocultos-----------------------
	//Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos["id"]="formSaraData"; //No cambiar este nombre
	$atributos["tipo"]="hidden";
	$atributos["obligatorio"]=false;
	$atributos["etiqueta"]="";
	$atributos["valor"]=$valorCodificado;
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
        
        //-------------Control cuadroTexto con campos ocultos-----------------------
	//Para pasar variables entre formularios o enviar datos para validar sesiones
	$atributos["id"]="idEleccion"; //No cambiar este nombre
	$atributos["tipo"]="hidden";
	$atributos["obligatorio"]=false;
	$atributos["etiqueta"]="";
	$atributos["valor"]=$idEleccion;
	echo $this->miFormulario->campoCuadroTexto($atributos);
	unset($atributos);
   	
        //Fin del Formulario
        echo $this->miFormulario->formulario("fin");


?>
