<?php
if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
} else {
	$miSesion = Sesion::singleton ();
	
	if (isset ( $_REQUEST ['sesionId'] ) || isset ( $_REQUEST ['usuario'] )) {
        // unset cookies
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }

		$miSesion->terminarSesion ( $_REQUEST ['sesionID'], $_REQUEST['usuario']);

	}

	session_destroy();
	// Redirigir a la página de inicio con mensaje de error en usuario/clave
	$this->funcion->redireccionar ( "paginaPrincipal" );
        
}
?>