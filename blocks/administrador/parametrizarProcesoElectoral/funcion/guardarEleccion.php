<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit;
} else {


    $conexion = "estructura";
    $rutaCandidatos = $this->miConfigurador->getVariableConfiguracion("rutaCandidatos");
    $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
    $proceso = $_REQUEST['proceso'];
    $idEleccion = $_REQUEST['idEleccion'];
    $nombreEleccion = $_REQUEST['nombreEleccion' . $idEleccion];
    $tipoEstamento = $_REQUEST['tipoestamento' . $idEleccion];
    $descripcion = $_REQUEST['descripcion' . $idEleccion];
    $fechaInicio = $_REQUEST['fechaInicio' . $idEleccion];
    $fechaFin = $_REQUEST['fechaFin' . $idEleccion];
    $tipoVotacion = $_REQUEST['tipovotacion' . $idEleccion];
    $tipoResultados = $_REQUEST['tiporesultados' . $idEleccion];

    $arregloListaFinal = "";


    if (isset($_REQUEST['segundaClave' . $idEleccion])) {
        $segundaClave = $_REQUEST['segundaClave' . $idEleccion];
    } else {
        $segundaClave = 2;
    }

    if (isset($_REQUEST['listaTarjeton' . $idEleccion])) {
        $porTarjeton = $_REQUEST['listaTarjeton' . $idEleccion];

    } else {
        $porTarjeton = 3;
    }

    $candidatos = 0;
    $aux=1;
    $candidatosError = '';
    $permite=array("jpg","jpeg","png");
    // Si se esta pasando un array de identificaciones estos corresponden a candidatos nuevos
    if (isset($_REQUEST['identificacion' . $idEleccion]) && is_array($_REQUEST['identificacion' . $idEleccion])) {
        for ($j = 1; $j < count($_REQUEST['identificacion' . $idEleccion]); $j++) {
            if ($_REQUEST['identificacion' . $idEleccion][$j] != '') {
                $candidatos++;
                $estension = explode(".", $_FILES['foto' . $idEleccion]['name'][$j]);
                $nombre = $estension[0];
                $ext = $estension[1];
                //valida si la extensión del archivo corresponde a una imagen, permite realizar el registro
            if (in_array(strtolower($ext), $permite))     
                {
                    $nombreArchivo = $_REQUEST['identificacion' . $idEleccion][$j] . "." . $ext;
                    copy($_FILES['foto' . $idEleccion]['tmp_name'][$j], $rutaCandidatos . $nombreArchivo);
                    $candidatosGuardar[$aux] = array($_REQUEST['identificacion' . $idEleccion][$j], $_REQUEST['nombres' . $idEleccion][$j], $_REQUEST['apellidos' . $idEleccion][$j], $_REQUEST['nombreLista' . $idEleccion][$j], $nombreArchivo, $_REQUEST['renglon' . $idEleccion][$j]);
                    $aux++;
                }
            else{
                    $candidatosError.= $_REQUEST['identificacion' . $idEleccion][$j]." - ".$_REQUEST['nombres' . $idEleccion][$j]." ".$_REQUEST['apellidos' . $idEleccion][$j].", ";
                }
            }
        }
    } 

    // Si hay candidatos y se encuentra que tambien el nombre de la lista es un array se hace un array de listas unicas
    if ($candidatos != 0) {
        if (isset($_REQUEST['nombreLista' . $idEleccion]) && is_array($_REQUEST['nombreLista' . $idEleccion])) {
            for ($i = 0; $i < count($_REQUEST['nombreLista' . $idEleccion]); $i++) {
                $recorreLista[$i]['nombre'] = trim($_REQUEST['nombreLista' . $idEleccion][$i]);
                $recorreLista[$i]['pos'] = trim($_REQUEST['posicionLista' . $idEleccion][$i]);
            }
            $temp_array = array();
                foreach ($recorreLista as &$v) {
                    if (!isset($temp_array[$v['nombre']]))
                        $temp_array[$v['nombre']] =& $v;
                    }
            $arregloListaFinal = array_values($temp_array);
        }
    } else {
        $arregloListaFinal = '';
    }

    // Manejo para la segunda clave
    if ($segundaClave == 'on') {
        $segundaClave = 1;
    } else {
        $segundaClave = 2;
    }

    // Manejo del tipo de resultados ( No afecta el proceso en si)
    if ($tipoResultados == 2) {
        $resulEstudiantes = $_REQUEST['resulEstudiantes' . $idEleccion];
        $resulDocentes = $_REQUEST['resulDocentes' . $idEleccion];
        $resulEgresados = $_REQUEST['resulEgresados' . $idEleccion];
        $resulFuncionarios = $_REQUEST['resulFuncionarios' . $idEleccion];
        $resulDocenteVinEspecial = $_REQUEST['resulDocenteVinEspecial' . $idEleccion];
    } else {
        $resulEstudiantes = '0';
        $resulDocentes = '0';
        $resulEgresados = '0';
        $resulFuncionarios = '0';
        $resulDocenteVinEspecial = '0';
    }

    // Si no esta en eleccion parametrizada va a crear la eleccion, de lo contrario va a actualizar la eleccion y si aplica el caso va a hacer una actualizacion en la ponderacion
    if (!isset($_REQUEST['eleccionParametrizada'])) {
        $arregloEleccion = array($proceso, $nombreEleccion, $tipoEstamento, $descripcion, $fechaInicio, $fechaFin, $porTarjeton, $tipoVotacion, 1, count($candidatos), $segundaClave, $idEleccion, $tipoResultados, $resulEstudiantes, $resulDocentes, $resulEgresados, $resulFuncionarios, $resulDocenteVinEspecial);
        $this->cadena_sql = $this->sql->cadena_sql("insertarEleccion", $arregloEleccion);
        $resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
        $idGuardado = $esteRecursoDB->ultimo_insertado();
    } else {

        $idGuardado = $_REQUEST['eleccionParametrizada'];
        $arregloEleccion = array($proceso, $nombreEleccion, $tipoEstamento, $descripcion, $fechaInicio, $fechaFin, $porTarjeton, $tipoVotacion, 1, count($candidatos), $segundaClave, $idEleccion, $tipoResultados, $resulEstudiantes, $resulDocentes, $resulEgresados, $resulFuncionarios, $idGuardado, $resulDocenteVinEspecial);
        $this->cadena_sql = $this->sql->cadena_sql("actualizarEleccion", $arregloEleccion);
        $resultadoEleccion = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
        $id_estamentos = array(4, 3, 1, 2, 6);

        $i = 0;
        foreach ($_REQUEST as $clave => $valor) {
            $cadena = $clave;
            $buscar = "resul";
            $resultadoValores = strpos($cadena, $buscar);

            if ($resultadoValores !== FALSE) {
                if ($clave != 'tiporesultados1') {
                    if ($clave != 'resulSuma1') {
                        $variable['idtipo'] = $id_estamentos[$i];
                        $variable['ponderado'] = $valor;

                        $this->cadena_sql = $this->sql->cadena_sql("actualizarPorcentajeEstamento", $variable);
                        $resultadoPorcentaje = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");
                        $i++;
                    }
                }

            }
        }
    }

    // Si hay un arreglo de listas unicas y la eleccion se creo o se actualizo

    if ($resultadoEleccion) {
        if ($arregloListaFinal != '') {

            // Se van a recorrer las listas unicas encontradas y se verificara si existe la lista o no y se creara
            for ($l = 1; $l < count($arregloListaFinal); $l++) {

                $arregloListasInsert = array($arregloListaFinal[$l]['nombre'], $idGuardado, $arregloListaFinal[$l]['pos']);
                $this->cadena_sql = $this->sql->cadena_sql("buscarLista",$arregloListasInsert);
                $resultadoListaCandidato = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

                if (!$resultadoListaCandidato) {
                    $this->cadena_sql = $this->sql->cadena_sql("insertarLista", $arregloListasInsert);
                    $result = $esteRecursoDB->ejecutarAcceso($this->cadena_sql,"acceso");
                }
            }

            // Se van a buscar todas las listas que pertenecen a la eleccion
            $this->cadena_sql = $this->sql->cadena_sql("idLista", $idGuardado);
            $resultadoIdLista = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "busqueda");

            // Por cada candidato a guardar se va actualizar el Id de la lista que le corresponde
            for ($c = 1; $c <= count($candidatosGuardar); $c++) {

                // Se va recorrer las listas que existen asignadas a la eleccion

                for ($lis = 0; $lis < count($resultadoIdLista); $lis++) {
                    // Si el resultado de la lista su nombre es igual que el nombre de la lista que tiene el candidato
                    if ($resultadoIdLista[$lis]['nombre'] == $candidatosGuardar[$c][3]) {
                        $candidatosGuardar[$c][3] = $resultadoIdLista[$lis]['idlista'];
                    }
                }

                // Este es el idLista de la lista
                $listaCandidato = $candidatosGuardar[$c][3];
                // Identificacion, nombre,  apellido, renglon, lista, foto
                //$arregloCandidato = array($candidatosGuardar[$c][0], $candidatosGuardar[$c][1], $candidatosGuardar[$c][2], $c, $listaCandidato, $candidatosGuardar[$c][4]);
                $arregloCandidato = array($candidatosGuardar[$c][0], $candidatosGuardar[$c][1], $candidatosGuardar[$c][2], $candidatosGuardar[$c][5], $listaCandidato, $candidatosGuardar[$c][4]);
                $this->cadena_sql = $this->sql->cadena_sql("insertarCandidato", $arregloCandidato);
                $resultadoCandidato = $esteRecursoDB->ejecutarAcceso($this->cadena_sql, "acceso");

            }
            $resultado=array('proceso'=> $proceso,
                             'errores'=> $candidatosError
                        );
            $this->funcion->redireccionar('inserto', $resultado);
        } else {
            $this->funcion->redireccionar('insertoSinCandidatos', $proceso);
        }
    } else {
        $this->funcion->redireccionar('ErrorInsertando', $proceso);
    }
}