<?php
$voto = $this->miConfigurador->fabricaConexiones->crypto->decodificar($_REQUEST['candidatoSeleccionado']);

if($voto){
    $arregloVoto = explode("-", $voto);
}else{
    $arregloVoto=false;
}

?>