<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */

// Registrar los archvios js que deben incluirse
$funcion=array();
$indice=0;
$funcion[$indice++]="no-back.js";


foreach ($funcion as $nombre){
    echo "<script type='text/javascript' src='".$host.$sitio."/theme/basico/js/".$nombre."'></script>\n";
}



