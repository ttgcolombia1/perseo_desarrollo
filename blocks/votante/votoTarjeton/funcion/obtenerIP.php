<?php

//if (isset($_SERVER)) {
//    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//        echo "<br> 1";
//        return $_SERVER['HTTP_X_FORWARDED_FOR'];
//    } else {
//        echo "<br> 2";
//        return $_SERVER['REMOTE_ADDR'];
//    }
//} else {
//    if (isset($GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDER_FOR'])) {
//        echo "<br> 3";
//        return $GLOBALS['HTTP_SERVER_VARS']['HTTP_X_FORWARDED_FOR'];
//    } else {
//        echo "<br> 4";
//        return $GLOBALS['HTTP_SERVER_VARS']['REMOTE_ADDR'];
//    }
//}

if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) != '') {
        
    $client_ip =
            (!empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR'] :
            ( (!empty($_ENV['REMOTE_ADDR']) ) ?
                    $_ENV['REMOTE_ADDR'] :
                    "unknown" );

    // los proxys van añadiendo al final de esta cabecera
    // las direcciones ip que van "ocultando". Para localizar la ip real
    // del usuario se comienza a mirar por el principio hasta encontrar 
    // una dirección ip que no sea del rango privado. En caso de no 
    // encontrarse ninguna se toma como valor el REMOTE_ADDR

    $entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);

    reset($entries);
    while (list(, $entry) = each($entries)) {
        $entry = trim($entry);
        if (preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)) {

            $private_ip = array(
                '/^0\./',
                '/^127\.0\.0\.1/',
                '/^192\.168\..*/',
                '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                '/^10\..*/');

            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

            if ($client_ip != $found_ip) {
                $client_ip = $found_ip;
                break;
            }
        }
    }
} else {
        
    $client_ip =
            (!empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR'] :
            ( (!empty($_ENV['REMOTE_ADDR']) ) ?
                    $_ENV['REMOTE_ADDR'] :
                    "unknown" );
}
return $client_ip;
?>
