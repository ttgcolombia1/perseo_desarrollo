<?php

if (!isset($GLOBALS["autorizado"])) {
    include("index.php");
    exit();
} else {

    // 0. Se van a utilizar conexiones a bases de datos, verificarlas antes de hace cualquier cosa:

    $conexion = "estructura";
      $esteRecursoDB = $this->miConfigurador->fabricaConexiones->getRecursoDB($conexion);
      
      if (!$esteRecursoDB) {
        exit();
      }

      if (isset($_REQUEST[sha1("usuario" . $_REQUEST['tiempo']) ]) && isset($_REQUEST[sha1("clave" . $_REQUEST['tiempo']) ])) {
          $variable['usuario'] = $_REQUEST[sha1("usuario" . $_REQUEST['tiempo']) ];
        /**
         *
         * @todo En entornos de producción la clave debe codificarse utilizando un objeto de la clase Codificador
         */
        $variable['clave'] = $this->miConfigurador->fabricaConexiones->crypto->codificarClave($_REQUEST[sha1("clave" . $_REQUEST['tiempo']) ]);

        // Verificar que el usuario esté registrado en el sistema

        $cadena_sql = $this->sql->cadena_sql("buscarUsuario", $variable);
        $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
        $enCenso = false;

        
        // Si no es un usuario del sistema verificar si es un votante

        if (!$registro) {
            $cadena_sql = $this->sql->cadena_sql("buscarVotante", $variable);
            $registro = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
            $tipoUsuario = 'votante';
            if ($registro) {
                $enCenso = true;
            }
        }

        // verifica que la contraseña del votante no este expirada
        $segundos_hora = strtotime(date('Y-m-d H:i:s'));
          if (isset($registro[0]['expira_clave']) && $registro[0]['expira_clave'] > 0 && $tipoUsuario == 'votante') {
              if ($segundos_hora <= $registro[0]['expira_clave']) {
                  $paso = 'S';
              } else {
                  $paso = 'N';
              }
          } else {
              $paso = 'S';
          }

          if ($registro) {
              if ($registro[0]['clave'] == $variable["clave"] && $paso == 'S') {
                // 1. Crear una sesión de trabajo
                $estaSesion = $this->miSesion->crearSesion($registro[0]["id_usuario"]);
                  $arregloLogin = array(
                    'autenticacionExitosa',
                    $registro[0]["id_usuario"],
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT']
                );
                  $argumento = json_encode($arregloLogin);
                  $cadena_sql = $this->sql->cadena_sql("registrarEvento", $argumento);
                  $registroAcceso = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");
                  if ($estaSesion) {
                      $registro[0]["sesionID"] = $estaSesion;
                      $registro[0]["tiempo"] = $_REQUEST['tiempo'];
                      if (isset($tipoUsuario) && $tipoUsuario == 'votante') {

                        // Validar si el usuario tiene segunda identificacion

                        $cadena_sql = $this->sql->cadena_sql("buscarSegundaIdentificacion", $variable);
                          $registroSIdentificacion = $esteRecursoDB->ejecutarAcceso($cadena_sql, "busqueda");
                          if ($registroSIdentificacion) {
                              $this->funcion->redireccionar("segundaIdentificacion", $registro[0]);
                          } else {
                              $this->funcion->redireccionar("indexVotante", $registro[0]);
                          }
                      } else {
                          switch ($registro[0]["tipo"]) {
                        case '2':
                            $this->funcion->redireccionar("indexVeedor", $registro[0]);
                            break;

                        case '3':
                            $this->funcion->redireccionar("indexDelegado", $registro[0]);
                            break;

                        case '4':
                            $this->funcion->redireccionar("indexAdministrador", $registro[0]);
                            break;

                        case '5':
                            $this->funcion->redireccionar("indexSalas", $registro[0]);
                            break;
                            }
                      }

                    // Redirigir a la página principal del usuario, en el arreglo $registro se encuentran los datos de la sesion:
                    // $this->funcion->redireccionar("indexUsuario", $registro[0]);

                    return true;
                  }
              } else {
                // Registrar el error por clave no válida
                $arregloLogin = array(
                    'claveNoValida',
                    $variable['usuario'],
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT']
                );
              }
          } else {

            // Registrar el error por usuario no valido

            $arregloLogin = array(
                'loginIncorrecto',
                $variable['usuario'],
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['HTTP_USER_AGENT']
            );
						if(!$enCenso){
							$arregloLogin = array(
	                'inexistente',
	                $variable['usuario'],
	                $_SERVER['REMOTE_ADDR'],
	                $_SERVER['HTTP_USER_AGENT']
	            );
						}
          }
      } else {

        // Registrar evento por no existir los controles del formulario

        $arregloLogin = array(
            'formularioErroneo',
            $_SERVER['REMOTE_ADDR'],
            $_SERVER['HTTP_USER_AGENT']
        );
      }

      $argumento = json_encode($arregloLogin);
      $cadena_sql = $this->sql->cadena_sql('registrarEvento', $argumento);
      $registroAccesoClave = $esteRecursoDB->ejecutarAcceso($cadena_sql, "acceso");

    // Redirigir a la página de inicio con mensaje de error en usuario/clave

    $this->funcion->redireccionar('paginaPrincipal', $arregloLogin[0]);
  }
