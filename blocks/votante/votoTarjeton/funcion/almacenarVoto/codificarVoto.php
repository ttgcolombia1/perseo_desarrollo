<?php
$textoEncriptado = '';
if(openssl_public_encrypt($voto[1], $textoEncriptado, $llavePublica)){
    $respuesta = base64_encode($textoEncriptado);
}else{
    $respuesta=false;
}