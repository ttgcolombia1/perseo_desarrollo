<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {

    $documento = $_REQUEST['documento'];
    $conexion="estructura";

    $esteRecursoDB=$this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $consulta = array($documento);


    header('Content-Type: application/json');

    // Consultar la lista del candidato
    $cadena_sql = $this->sql->cadena_sql("consultaCandidatoLista", $consulta);
    $resultado= $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

    if($resultado){
        $lista = $resultado[0]['lista_idlista'];
        $resultado = array("resultado"=>"ok", "documento" => $documento, "lista"=>$lista);

        // Si el candidato es el ultimo en la lista por ende se borra la lista
        $cadena_sql = $this->sql->cadena_sql("consultarCandidatosLista", array($lista));
        $resultado = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");

        if($resultado){

            $conteo = $resultado[0]['conteo'];
            $cadena_sql = $this->sql->cadena_sql("eliminarCandidato", $consulta);
            $resultado= $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

            if(intval($conteo) == 1){
                $cadena_sql = $this->sql->cadena_sql("eliminarLista", array($lista));
                $resultado= $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
            }
            $resultado = array("resultado"=>"ok", "documento" => $documento, "lista"=>$lista, "candidatos" => $conteo);
        }

        /*
 // Buscar las listas vacias y eliminarlas
               // $this->cadena_sql = $this->sql->cadena_sql("listasHuerfanas", array());
               // $resultadoListasHuerfanas = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

                for ($i = 0; $i < count($resultadoListasHuerfanas); $i++) {

                    $idLista = $resultadoListasHuerfanas[$i][0];

                    $this->cadena_sql = $this->sql->cadena_sql("borrarHuerfana", $idLista);
                    $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
                }*/
    }

    if($resultado){
        $resultado = array("resultado"=>"ok", "documento" => $documento);
    }else{
        $resultado = array("resultado"=>"failed", "documento" => $documento, "consulta" => $cadena_sql);
    }
    echo json_encode($resultado);


}

