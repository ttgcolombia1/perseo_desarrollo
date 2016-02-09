<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

?>
<div class="wrap">
    <div class="demo-container clear">
        <div class="dcjq-vertical-mega-menu">
            <ul id="mega-1" class="menu">
                <li id="menu-item-0">
                    <a href="<?php 
                            $variable = 'pagina=indexDelegado'; //pendiente la pagina para modificar parametro                                                        
                            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                            echo $variable;
                            ?>">
                        <img src='<?php echo $rutaBloque . "/css/menuVertical/images/home.png" ?>' width="15px" style="vertical-align:text-bottom;" >  
                        Inicio
                    </a>
                </li> 
                </li> 
                <li id="menu-item-6">
                <a href="<?php
                            $variable = 'pagina=iniciarProceso'; //pendiente la pagina para modificar parametro                                                        
                            $variable.= '&usuario=' . $miSesion->getSesionUsuarioId();
                            $variable.= '&opcion=paso1';
                            $variable.= '&tiempo=' . time();                            
                            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                            echo $variable;
                            ?>">
                            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/votar.jpg" ?>' width="15px" style="vertical-align:text-bottom;" >
                            Iniciar Proceso</a>
                </li> 
                <li id="menu-item-6">
                <a href="<?php
                            $variable = "pagina=seguimientoProceso"; //pendiente la pagina para modificar parametro                                                        
                            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
                            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                            echo $variable;
                            ?>">
                            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/Properties24.png" ?>' width="15px" style="vertical-align:text-bottom;" >
                            Seguimiento</a>
                </li>
                <li id="menu-item-6">
                <a href="<?php
                            $variable = "pagina=cerrarProceso"; //pendiente la pagina para modificar parametro                                                        
                            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
                            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                            echo $variable;
                            ?>">
                            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/decrypted.png" ?>' width="15px" style="vertical-align:text-bottom;" >
                            Cerrar Proceso</a>
                </li>
                <li id="menu-item-6">
                <a href="<?php
                            $variable = "pagina=cambiarClaveDelegado"; //pendiente la pagina para modificar parametro                                                        
                            $variable.= "&usuario=" . $miSesion->getSesionUsuarioId();
                            $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                            echo $variable;
                            ?>">
                            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/security.png" ?>' width="15px" style="vertical-align:text-bottom;" >
                            Cambiar Clave</a>
                </li>
                <li id="menu-item-6">
                    <a href="<?php
                    $variable = "pagina=cerrarSesionDelegado"; //pendiente la pagina para modificar parametro
                    $variable.= "&sesionId=" . $miSesion->getSesionId();
                    $variable = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($variable, $directorio);
                    echo $variable;
                    ?>">
                        <img src='<?php echo $rutaBloque . "/css/menuVertical/images/salir.png" ?>' width="15px" style="vertical-align:text-bottom;" > 
                        Cerrar sesion
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php
$atributos["id"] = "clockDiv";
$atributos["estilo"] = "campoCuadroLista";
echo $this->miFormulario->division("inicio", $atributos);

echo $this->miFormulario->division("fin");

?>
   
<input type="hidden" id="horaServidor" name="horaServidor" value="<?php echo date('d M Y G:i:s');?>">
