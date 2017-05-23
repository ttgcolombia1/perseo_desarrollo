<?php
$esteBloque = $this->miConfigurador->getVariableConfiguracion("esteBloque");

$rutaBloque = $this->miConfigurador->getVariableConfiguracion("host");
$rutaBloque.=$this->miConfigurador->getVariableConfiguracion("site") . "/blocks/";
$rutaBloque.= $esteBloque['grupo'] . "/" . $esteBloque['nombre'];

$directorio = $this->miConfigurador->getVariableConfiguracion("host");
$directorio.= $this->miConfigurador->getVariableConfiguracion("site") . "/index.php?";
$directorio.=$this->miConfigurador->getVariableConfiguracion("enlace");
$miSesion = Sesion::singleton();

// Definimos todos los enlaces a crear

//Inicio pagina administrador
$enlaceIndiceAdministrador['enlace'] = "pagina=indexAdministrador";
$enlaceIndiceAdministrador['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceIndiceAdministrador['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceIndiceAdministrador['enlace'], $directorio);
$enlaceIndiceAdministrador['nombre'] = "Inicio";

//Procesos Electorales

//Primer item no tiene url asociada
$enlaceProcesoElectoral['nombre'] = "Procesos Electorales";

//Crear Proceso electoral
$enlaceCrearProceso['enlace'] = "pagina=procesoElectoral";

$enlaceCrearProceso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCrearProceso['enlace'], $directorio);
$enlaceCrearProceso['nombre'] = "Procesos Electorales";

//Parametrizar Proceso electoral
$enlaceParametrizarProceso['enlace'] = "pagina=parametrizarProcesoElectoral";
$enlaceParametrizarProceso['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceParametrizarProceso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceParametrizarProceso['enlace'], $directorio);
$enlaceParametrizarProceso['nombre'] = "Parametrizar";

//Subir el censo electoral
$enlaceCenso['nombre'] = "Gestión Censo";
$enlaceSubirCenso['enlace'] = "pagina=subirCenso";
$enlaceSubirCenso['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceSubirCenso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceSubirCenso['enlace'], $directorio);
$enlaceSubirCenso['nombre'] = "Carga Censo Electoral";

//Modificar el censo electoral
$enlaceModificarCenso['enlace'] = "pagina=votoTarjeton";
$enlaceModificarCenso['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();
$enlaceModificarCenso['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceModificarCenso['enlace'], $directorio);
$enlaceModificarCenso['nombre'] = "Ver tarjetones";

//Hash Codigo Fuente
$enlaceHash['enlace'] = "pagina=hashCodigoFuente";
$enlaceHash['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceHash['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceHash['enlace'], $directorio);
$enlaceHash['nombre'] = "Validar Código Fuente";

//Gestion de Usuarios
$enlaceGestionUsuarios['enlace'] = "pagina=gestionUsuarios";
$enlaceGestionUsuarios['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceGestionUsuarios['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceGestionUsuarios['enlace'], $directorio);
$enlaceGestionUsuarios['nombre'] = "Administrar Usuarios";

//Cambiar Clave acceso
$enlaceCambiarClave['enlace'] = "pagina=cambiarClaveAdministrador";
$enlaceCambiarClave['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceCambiarClave['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCambiarClave['enlace'], $directorio);
$enlaceCambiarClave['nombre'] = "Cambiar Contraseña";

//Cerrar Sesion
$enlaceCerrarSesion['enlace'] = "pagina=cerrarSesionAdministrador";
$enlaceCerrarSesion['enlace'].= "&usuario=" . $miSesion->getSesionUsuarioId();

$enlaceCerrarSesion['urlCodificada'] = $this->miConfigurador->fabricaConexiones->crypto->codificar_url($enlaceCerrarSesion['enlace'], $directorio);
$enlaceCerrarSesion['nombre'] = "Salir";



$atributos["id"] = "divPrincipal";
$atributos["estilo"] = "wrap";
echo $this->miFormulario->division("inicio", $atributos);

$atributos["id"] = "divContenedor";
$atributos["estilo"] = "demo-container clear";
echo $this->miFormulario->division("inicio", $atributos);

$atributos["id"] = "divMenu";
$atributos["estilo"] = "dcjq-vertical-mega-menu";
echo $this->miFormulario->division("inicio", $atributos);


?>
<ul id="mega-1" class="menu">
    <li id="menu-item-1">
        <a href="<?php echo $enlaceIndiceAdministrador['urlCodificada'];?>">
            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/home.png" ?>' style="vertical-align:text-bottom;" >
            <?php echo $enlaceIndiceAdministrador['nombre']?>
        </a>
    </li>
    <li id="menu-item-2">


                <a href="<?php echo $enlaceCrearProceso['urlCodificada'];?>">
                    <img src='<?php echo $rutaBloque . "/css/menuVertical/images/registrar.png" ?>'  style="vertical-align:text-bottom;" >
                    <?php echo $enlaceCrearProceso['nombre']?>
                </a>



    </li>
    <li id="menu-item-52">
      <a href="<?php echo $enlaceSubirCenso['urlCodificada'];?>">
          <img src='<?php echo $rutaBloque . "/css/menuVertical/images/csv.png" ?>'  style="vertical-align:text-bottom;" >
          <?php echo $enlaceSubirCenso['nombre']?>
      </a>
    </li>
    <li id="menu-item-52">
        <a href="<?php echo $enlaceHash['urlCodificada'];?>">
            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/security.png" ?>'  style="vertical-align:text-bottom;" >
            <?php echo $enlaceHash['nombre']?>
        </a>
    </li>
    <li id="menu-item-52">
        <a href="<?php echo $enlaceGestionUsuarios['urlCodificada'];?>">
            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/groupevent.png" ?>'  style="vertical-align:text-bottom;" >
            <?php echo $enlaceGestionUsuarios['nombre']?>
        </a>
    </li>
    <li id="menu-item-52">
        <a href="<?php echo $enlaceCambiarClave['urlCodificada'];?>">
            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/decrypted.png" ?>'  style="vertical-align:text-bottom;" >
            <?php echo $enlaceCambiarClave['nombre']?>
        </a>
    </li>
    <li id="menu-item-6">
        <a href="<?php echo $enlaceCerrarSesion['urlCodificada'];?>">
            <img src='<?php echo $rutaBloque . "/css/menuVertical/images/salir.png" ?>'  style="vertical-align:text-bottom;" >
            <?php echo $enlaceCerrarSesion['nombre']?>
        </a>
    </li>
</ul>

<?php

//------------------Fin Division-------------------------
echo $this->miFormulario->division("fin");

//------------------Fin Division-------------------------
echo $this->miFormulario->division("fin");

//------------------Fin Division-------------------------
echo $this->miFormulario->division("fin");



?>
