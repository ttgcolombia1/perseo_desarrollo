<?php
include_once("../core/crypto/Encriptador.class.php");

$miCodificador=Encriptador::singleton();
echo $miCodificador->codificar("abc123")."<br>";
echo $miCodificador->decodificar("Rf1+VGKFIFHx8XzQsBW5cVcccpE1TvetRsi2kQ==")."<br>";



$parametro=array("lwB4pPN7GlItKiD8eg==",
"mwD+wvN7GlKDLFKsvwIyy04=",
"ngDhgfN7GlJUGoAm",
"ogBvmfN7GlJSmjip34G+W1DgNX+wo18=",
"pQBr4vN7GlLgwrVBUQ6p7dbnYjkIrJI=",
"qQCYm/N7GlJOMs8wIKODAKGLDDeZn+x5vJWsOA==",
"rgDkw/N7GlKlpBXtHPE=");




foreach ($parametro as $valor){
	echo $miCodificador->decodificar($valor)."<br>";
}



?>
