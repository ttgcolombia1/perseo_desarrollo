<?php

$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

if(!isset($datosUsuario))
    {
        $datosUsuario[0]['NOMBRE'] = "USUARIO";
        $datosUsuario[0]['APELLIDO'] = "INVITADO";
    }
$datosUsuario[0]['imagen'] = "sabio"; 

$nombreFormulario='ActualizarDatos';

$directorioImagenes = $this->miConfigurador->getVariableConfiguracion("rutaUrlBloque")."/images";

$nombreAplicativo = $this->miConfigurador->getVariableConfiguracion("nombreAplicativo");

$rutaImagen = $rutaBloque . "/imagenesTemp/" . trim($datosUsuario[0]['imagen']) . ".jpg";

$atributos["id"] = "divPrincipal";
$atributos["estilo"] = "divPrincipal";
echo $this->miFormulario->division("inicio", $atributos);

$atributos["id"] = "divContenedor";
$atributos["estilo"] = "divContenedor";
echo $this->miFormulario->division("inicio", $atributos);

$atributos["id"] = "textoSistema";
$atributos["estilo"] = "textoSistema";
echo $this->miFormulario->division("inicio", $atributos);

            echo "<center>".$nombreAplicativo."</center>";
//------------------Fin Division-------------------------	
echo $this->miFormulario->division("fin"); 

$atributos["id"] = "textoNombre";
$atributos["estilo"] = "textoNombre";
echo $this->miFormulario->division("inicio", $atributos);

?>
    <?php echo $datosUsuario[0]['NOMBRE'] . " " . $datosUsuario[0]['APELLIDO'];

//------------------Fin Division-------------------------	
echo $this->miFormulario->division("fin");    

$atributos["id"] = "fotoUsuario";
$atributos["estilo"] = "fotoUsuario";
echo $this->miFormulario->division("inicio", $atributos);
?>
   <img class="mediana shadow " src="<? echo $rutaImagen ?>">&nbsp; &nbsp; 
<?php   

//------------------Fin Division-------------------------	
echo $this->miFormulario->division("fin");  

//------------------Fin Division-------------------------	
echo $this->miFormulario->division("fin");

//------------------Fin Division-------------------------	
echo $this->miFormulario->division("fin");
   
?>



