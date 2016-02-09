<?php
$miSesion= Sesion::singleton();
$conexion = "estructura";
$esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);

if ($esteRecursoDB == false) {
    $mensaje = "...No se pudo establecer conexión con la base de datos, por favor contacte al administrador del sistema...";
    $error = "error";
    $datos = array("mensaje" => $mensaje, "error" => $error);
    $this->redireccionar("mostrarMensaje", $datos);
} else {
    $id_usuario = $miSesion->getSesionUsuarioId();
    $cadena_sql = trim($this->sql->cadena_sql("validarSegundaClave", $id_usuario));
    $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    if ($resultado)
        {

        $preguntas['idpregunta'] = $resultado[0]['idpregunta'];
        $preguntas['respuesta'] = unserialize($this->miConfigurador->fabricaConexiones->crypto->decodificar($resultado[0]['respuesta']));
		
        if ($preguntas['respuesta'] == $_REQUEST['respuesta1']) {
            $this->redireccionar("actualizarSegundaClave", "");
        } else {
            $mensaje = "La pregunta/respuesta no es la misma registrada anteriormente!!!.";
            $error = "alerta";
            $datos = array("mensaje" => $mensaje, "error" => $error);
            $this->redireccionar("mostrarMensaje", $datos);
        }
    }
}
?>
