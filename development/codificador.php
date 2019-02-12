<?php
include_once("../core/crypto/Encriptador.class.php");

$miCodificador=Encriptador::singleton();
echo $miCodificador->codificar("PruebasvotoNov2017")."<br>";
echo $miCodificador->decodificar("Rf1+VGKFIFHx8XzQsBW5cVcccpE1TvetRsi2kQ==")."<br>";



$parametro=array("lwB4pPN7GlItKiD8eg==",
"mwD+wvN7GlKDLFKsvwIyy04=",
"ngDhgfN7GlJUGoAm",
"ogBvmfN7GlJSmjip34G+W1DgNX+wo18=",
"pQBr4vN7GlLgwrVBUQ6p7dbnYjkIrJI=",
"UALWOUW53lkQGXg_k2Ow_4F0f78KQinF2cg",
"rgDkw/N7GlKlpBXtHPE=");




foreach ($parametro as $valor){
	echo $miCodificador->decodificar($valor)."<br>";
}



?>
