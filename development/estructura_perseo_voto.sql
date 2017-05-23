-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 22-05-2017 a las 21:29:23
-- Versión del servidor: 10.0.26-MariaDB-1~trusty-wsrep
-- Versión de PHP: 5.6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `perseo_voto2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_actoadministrativo`
--

DROP TABLE IF EXISTS `evoto_actoadministrativo`;
CREATE TABLE IF NOT EXISTS `evoto_actoadministrativo` (
  `idacto` varchar(2) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `descripcion` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_audit`
--

DROP TABLE IF EXISTS `evoto_audit`;
CREATE TABLE IF NOT EXISTS `evoto_audit` (
  `date` datetime NOT NULL,
  `user` varchar(30) DEFAULT NULL,
  `host` varchar(40) DEFAULT NULL,
  `object_type` varchar(20) DEFAULT NULL,
  `object_name` varchar(30) DEFAULT NULL,
  `column_name` varchar(50) DEFAULT NULL,
  `v_primarykey` text,
  `new_value` text,
  `old_value` text,
  `operation` char(1) DEFAULT NULL,
  `row` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla de auditoria para la BD plataforma_voto';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_bitacora`
--

DROP TABLE IF EXISTS `evoto_bitacora`;
CREATE TABLE IF NOT EXISTS `evoto_bitacora` (
  `id_nota` int(15) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(15) NOT NULL,
  `nota` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_bloque`
--

DROP TABLE IF EXISTS `evoto_bloque`;
CREATE TABLE IF NOT EXISTS `evoto_bloque` (
  `id_bloque` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grupo` char(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_bloque`),
  KEY `id_bloque` (`id_bloque`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 COMMENT='Bloques disponibles' AUTO_INCREMENT=38 ;

--
-- Volcado de datos para la tabla `evoto_bloque`
--

INSERT INTO `evoto_bloque` (`id_bloque`, `nombre`, `descripcion`, `grupo`) VALUES
(1, 'banner', 'Banner principal del aplicativo.', 'gui'),
(2, 'login', 'Bloque para autenticar a los usuarios del portal.', 'registro'),
(3, 'slidePrincipal', 'Bloque que contiene el slide de la página principal del aplicativo', 'gui'),
(4, 'pie', 'Pie de página genérico para el aplicativo.', 'gui'),
(5, 'menuAdministrador', 'Menu del usuario administrador', 'administrador'),
(6, 'slider', 'Slider de imagenes para el inicio de pagina', 'gui'),
(7, 'procesoElectoral', 'Bloque que permite crear nuevos procesos electorales', 'administrador'),
(8, 'bannerVotante', 'Baner para el módulo de votantes.', 'gui'),
(9, 'menuVotante', 'Menu lateral del módulo de votante', 'votante'),
(10, 'adminEleccionesVotante', 'Listado enriquecido que contiene las elecciones presentes y futuras en las que está registrado un documento de identidad.', 'votante/admin'),
(11, 'parametrizarProcesoElectoral', 'Bloque que permite parametrizar procesos electorales previamente creados', 'administrador'),
(12, 'subirCenso', 'Bloque que permite subir el censo', 'administrador'),
(13, 'votoTarjeton', 'Bloque que permite ver las votaciones activas del usuario y permite realizar el voto', 'votante'),
(14, 'menuVerticalDelegado', 'Menú lateral para el prefil de delegado.', 'delegado/menu'),
(15, 'registroInicioProceso', 'Bloque para las actividades de inicio de proceso de votación.', 'delegado/registro'),
(16, 'registroCierreProceso', 'Bloque con las actividades de cierre de proceso de participación', 'delegado/registro'),
(17, 'resultados', 'Bloque para el cálculo de los resultados por parte del delegado', 'delegado/registro'),
(18, 'cerrarSesion', 'Bloque para cerrar la sesion a los usuarios del portal', 'registro'),
(19, 'menuVeedor', 'Menu de administracion del veedor de las votaciones', 'veedor'),
(20, 'bitacora', 'Bloque que permite crear la bitacora de votacion', 'veedor'),
(21, 'resultados', 'Bloque que permite revisar la votacion', 'veedor'),
(22, 'consultaProceso', 'Bloque que permite verificar el proceso total de votacion', 'veedor'),
(23, 'procesoElectoral', 'Bloque que permite la gestion electoral', 'veedor'),
(24, 'parametrizarProcesoElectoral', 'Bloque que permite la gestion electoral', 'veedor'),
(25, 'cambiarClave', 'Bloque para cambiar la clave a los usuarios del portal', 'registro'),
(26, 'segundaClave', 'Registro de la segunda clave del votante', 'votante'),
(27, 'votaciones', 'Bloque que permite verificar el proceso de votaciones', 'veedor/proceso'),
(28, 'certificados', 'Bloque que permite verificar el proceso de generacion de certificados', 'veedor/proceso'),
(29, 'accesos', 'Bloque que permite verificar el proceso de accesos a la plataforma', 'veedor/proceso'),
(30, 'accesosFallidos', 'Bloque que permite verificar el proceso de accesos fallidos a la plataforma', 'veedor/proceso'),
(31, 'hashCodigoFuente', 'Bloque que permite realizar la validación del hash del codigo fuente', 'administrador'),
(32, 'mensajeLateral', 'Mensaje de ayuda que se muestra en la sección lateral de las páginas', 'gui'),
(33, 'gestionUsuarios', 'Pagina de Administracion de usuarios de la plataforma', 'administrador'),
(34, 'cambiarPrimeraClave', 'Bloque para cambiar la primera clave a los usuarios del portal', 'registro'),
(35, 'menuJurado', 'Menu de jurado de salas de votaciones', 'jurado'),
(36, 'bitacoraJurado', 'Bloque que permite crear la bitacora de votacion de acceso a salas', 'jurado'),
(37, 'consultaCenso', 'Pagina que permite consultar el censo al jurado de acceso a salas', 'jurado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_bloque_pagina`
--

DROP TABLE IF EXISTS `evoto_bloque_pagina`;
CREATE TABLE IF NOT EXISTS `evoto_bloque_pagina` (
  `id_pagina` int(5) NOT NULL DEFAULT '0',
  `id_bloque` int(5) NOT NULL DEFAULT '0',
  `seccion` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `posicion` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pagina`,`id_bloque`,`seccion`,`posicion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Estructura de bloques de las paginas en el aplicativo';

--
-- Volcado de datos para la tabla `evoto_bloque_pagina`
--

INSERT INTO `evoto_bloque_pagina` (`id_pagina`, `id_bloque`, `seccion`, `posicion`) VALUES
(1, 2, 'D', 1),
(1, 3, 'B', 1),
(1, 4, 'E', 1),
(2, 1, 'A', 1),
(2, 4, 'E', 1),
(2, 5, 'B', 1),
(2, 6, 'C', 1),
(3, 1, 'A', 1),
(3, 4, 'E', 1),
(3, 5, 'B', 1),
(3, 7, 'C', 1),
(4, 4, 'E', 1),
(4, 8, 'A', 1),
(4, 9, 'B', 1),
(4, 13, 'C', 1),
(5, 1, 'A', 1),
(5, 4, 'E', 1),
(5, 5, 'B', 1),
(5, 11, 'C', 1),
(6, 1, 'A', 1),
(6, 4, 'E', 1),
(6, 5, 'B', 1),
(6, 12, 'C', 1),
(7, 4, 'E', 1),
(7, 8, 'A', 1),
(7, 9, 'B', 1),
(7, 13, 'C', 1),
(7, 32, 'B', 2),
(8, 1, 'A', 1),
(8, 3, 'C', 1),
(8, 4, 'E', 1),
(8, 14, 'B', 1),
(9, 1, 'A', 1),
(9, 4, 'E', 1),
(9, 14, 'B', 1),
(9, 15, 'C', 1),
(10, 1, 'A', 1),
(10, 4, 'E', 1),
(10, 14, 'B', 1),
(10, 16, 'C', 1),
(11, 1, 'A', 1),
(11, 4, 'E', 1),
(11, 14, 'B', 1),
(11, 22, 'C', 1),
(12, 1, 'A', 1),
(12, 4, 'E', 1),
(12, 14, 'B', 1),
(12, 25, 'C', 1),
(13, 18, 'C', 1),
(14, 1, 'A', 1),
(14, 4, 'E', 1),
(14, 19, 'B', 1),
(15, 1, 'A', 1),
(15, 4, 'E', 1),
(15, 19, 'B', 1),
(15, 27, 'C', 1),
(16, 1, 'A', 1),
(16, 4, 'E', 1),
(16, 19, 'B', 1),
(16, 28, 'C', 1),
(17, 1, 'A', 1),
(17, 4, 'E', 1),
(17, 19, 'B', 1),
(17, 29, 'C', 1),
(18, 1, 'A', 1),
(18, 4, 'E', 1),
(18, 19, 'B', 1),
(18, 30, 'C', 1),
(19, 1, 'A', 1),
(19, 4, 'E', 1),
(19, 19, 'B', 1),
(19, 20, 'C', 1),
(20, 1, 'A', 1),
(20, 4, 'E', 1),
(20, 19, 'B', 1),
(20, 21, 'C', 1),
(21, 1, 'A', 1),
(21, 4, 'E', 1),
(21, 19, 'B', 1),
(21, 22, 'C', 1),
(22, 1, 'A', 1),
(22, 4, 'E', 1),
(22, 19, 'B', 1),
(22, 25, 'C', 1),
(23, 1, 'A', 1),
(23, 4, 'E', 1),
(23, 5, 'B', 1),
(23, 25, 'C', 1),
(24, 18, 'C', 1),
(25, 18, 'C', 1),
(26, 4, 'E', 1),
(26, 8, 'A', 1),
(26, 9, 'B', 1),
(26, 25, 'C', 1),
(27, 4, 'E', 1),
(27, 8, 'A', 1),
(27, 9, 'B', 1),
(27, 26, 'C', 1),
(28, 18, 'C', 1),
(29, 1, 'A', 1),
(29, 4, 'E', 1),
(29, 5, 'B', 1),
(29, 31, 'C', 1),
(30, 1, 'A', 1),
(30, 4, 'E', 1),
(30, 5, 'B', 1),
(30, 33, 'C', 1),
(31, 25, 'C', 1),
(32, 1, 'A', 1),
(32, 4, 'E', 1),
(32, 35, 'B', 1),
(33, 1, 'A', 1),
(33, 4, 'E', 1),
(33, 35, 'B', 1),
(34, 1, 'A', 1),
(34, 4, 'E', 1),
(34, 35, 'B', 1),
(34, 36, 'C', 1),
(35, 1, 'A', 1),
(35, 4, 'E', 1),
(35, 35, 'B', 1),
(35, 37, 'C', 1),
(36, 1, 'A', 1),
(36, 4, 'E', 1),
(36, 25, 'C', 1),
(36, 35, 'B', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_candidato`
--

DROP TABLE IF EXISTS `evoto_candidato`;
CREATE TABLE IF NOT EXISTS `evoto_candidato` (
  `idcandidato` int(11) NOT NULL AUTO_INCREMENT,
  `identificacion` int(11) DEFAULT NULL,
  `nombre` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reglon` int(11) DEFAULT NULL,
  `lista_idlista` int(11) NOT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idcandidato`),
  KEY `fk_candidato_lista1_idx` (`lista_idlista`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_censo`
--

DROP TABLE IF EXISTS `evoto_censo`;
CREATE TABLE IF NOT EXISTS `evoto_censo` (
  `identificacion` bigint(25) NOT NULL,
  `clave` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'sha1(md5())',
  `ideleccion` int(11) NOT NULL,
  `nombre` char(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nombre Completo del Elector',
  `idtipo` int(11) NOT NULL COMMENT 'Tipo de estamento al que pertenece el elector',
  `segunda_identificacion` bigint(15) NOT NULL,
  `fechavoto` datetime NOT NULL,
  `datovoto` varchar(528) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Datos de identificación electrónica: IP',
  `acep_termi` int(15) NOT NULL,
  `acep_termi_tele` int(15) NOT NULL,
  `acep_termi_celu` int(15) NOT NULL,
  `acep_termi_direccion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `expira_clave` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`identificacion`,`ideleccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Censo y datos de la votación';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_configuracion`
--

DROP TABLE IF EXISTS `evoto_configuracion`;
CREATE TABLE IF NOT EXISTS `evoto_configuracion` (
  `id_parametro` int(3) NOT NULL AUTO_INCREMENT,
  `parametro` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `valor` char(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_parametro`),
  KEY `parametro` (`parametro`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Variables de configuracion' AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `evoto_configuracion`
--

INSERT INTO `evoto_configuracion` (`id_parametro`, `parametro`, `valor`) VALUES
(1, 'prefijo', 'evoto_'),
(2, 'nombreAplicativo', 'Plataforma de Votaciones'),
(3, 'raizDocumento', '/usr/local/apache/htdocs/voto_electronico'),
(4, 'host', 'http://localhost'),
(5, 'site', '/voto_electronico'),
(6, 'nombreAdministrador', 'administrador'),
(7, 'claveAdministrador', 'kgCOz_N7GlJAAjFLpuM'),
(8, 'correoAdministrador', 'computo@udistrital.edu.co'),
(9, 'enlace', 'denwork'),
(10, 'googlemaps', ''),
(11, 'recatchapublica', ' 	6LdUuPISAAAAAL_oC7eHaRldEoykUBB0eogw8gAE'),
(12, 'recatchaprivada', ' 	6LdUuPISAAAAAK3F4oYTop925AhgioIRX-mEkCVO'),
(13, 'expiracion', '5'),
(14, 'instalado', 'true'),
(15, 'debugMode', 'false'),
(16, 'dbPrincipal', 'perseo_voto'),
(17, 'hostSeguro', 'https://10.20.0.127'),
(18, 'public_key', 'file:///usr/local/apache/llaves/'),
(19, 'private_key', 'file:///usr/local/apache/llaves/'),
(20, 'public_key_org', 'file:///usr/local/apache/conf/certificado-desarrollo.pem'),
(21, 'private_key_org', 'file:///usr/local/apache/conf/key.pem'),
(22, 'host_amazon', 'https://10.20.0.245'),
(23, 'rutaCandidatos', '/usr/local/apache/htdocs/temporales/candidatos/'),
(24, 'raizDocumentoTemp', '/usr/local/apache/htdocs/temporales/candidatos'),
(25, 'urlCandidatos', '/temporales/candidatos/'),
(26, 'rutaLlaves', '/usr/local/apache/llaves/'),
(27, 'expiracion_admin', '30'),
(28, 'max_fecha_reclamacion', '03/07/2017-05/11/2017'),
(29, 'tiempo_vida_clave', '20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_datovoto`
--

DROP TABLE IF EXISTS `evoto_datovoto`;
CREATE TABLE IF NOT EXISTS `evoto_datovoto` (
  `idusuario` bigint(11) NOT NULL,
  `ideleccion` int(11) NOT NULL,
  `fecha` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idusuario`,`ideleccion`),
  UNIQUE KEY `idusuario` (`idusuario`,`ideleccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Se registra una vez el usuario marque su voto';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_dbms`
--

DROP TABLE IF EXISTS `evoto_dbms`;
CREATE TABLE IF NOT EXISTS `evoto_dbms` (
  `nombre` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `dbms` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `servidor` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `puerto` int(6) NOT NULL,
  `conexionssh` char(50) COLLATE utf8_unicode_ci NOT NULL,
  `db` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `evoto_dbms`
--

INSERT INTO `evoto_dbms` (`nombre`, `dbms`, `servidor`, `puerto`, `conexionssh`, `db`, `usuario`, `password`) VALUES
('estructura', 'mysql', 'localhost', 3306, '', 'perseo_voto', 'perseo_voto', 'qgKRZJomtVho5rCVsdqh58M3bA'),
('clave_academica', 'oci8', '10.20.0.36', 1521, '', 'SUDD', 'wconexionclave', 'VAPnTXSmD1lE9cqEIFrJFGt6APeCyZmsD2M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_dependencias`
--

DROP TABLE IF EXISTS `evoto_dependencias`;
CREATE TABLE IF NOT EXISTS `evoto_dependencias` (
  `id_dependencia` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_dependencia`),
  UNIQUE KEY `id_dependencia` (`id_dependencia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_eleccion`
--

DROP TABLE IF EXISTS `evoto_eleccion`;
CREATE TABLE IF NOT EXISTS `evoto_eleccion` (
  `ideleccion` int(11) NOT NULL AUTO_INCREMENT,
  `procesoelectoral_idprocesoelectoral` int(11) NOT NULL,
  `nombre` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipoestamento` int(11) DEFAULT NULL,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `listaTarjeton` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipovotacion` int(11) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `candidatostarjeton` int(11) DEFAULT NULL,
  `utilizarsegundaclave` int(11) DEFAULT NULL,
  `eleccionform` int(11) NOT NULL,
  `tiporesultado` int(2) NOT NULL DEFAULT '1',
  `porcEstudiante` float NOT NULL DEFAULT '0',
  `porcDocente` float NOT NULL DEFAULT '0',
  `porcEgresado` float NOT NULL DEFAULT '0',
  `porcFuncionario` float NOT NULL DEFAULT '0',
  `porcDocenteVinEspecial` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`ideleccion`),
  KEY `fk_eleccion_procesoelectoral_idx` (`procesoelectoral_idprocesoelectoral`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_estilo`
--

DROP TABLE IF EXISTS `evoto_estilo`;
CREATE TABLE IF NOT EXISTS `evoto_estilo` (
  `usuario` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `estilo` char(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`usuario`,`estilo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Estilo de pagina en el sitio';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_lista`
--

DROP TABLE IF EXISTS `evoto_lista`;
CREATE TABLE IF NOT EXISTS `evoto_lista` (
  `idlista` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `eleccion_ideleccion` int(11) NOT NULL,
  `posiciontarjeton` int(11) DEFAULT NULL,
  PRIMARY KEY (`idlista`),
  KEY `fk_lista_eleccion1_idx` (`eleccion_ideleccion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_llave_seguridad`
--

DROP TABLE IF EXISTS `evoto_llave_seguridad`;
CREATE TABLE IF NOT EXISTS `evoto_llave_seguridad` (
  `idllave` int(11) NOT NULL AUTO_INCREMENT,
  `idproceso` int(11) NOT NULL,
  `tipollave` int(11) NOT NULL,
  `nombrellave` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idllave`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_logger`
--

DROP TABLE IF EXISTS `evoto_logger`;
CREATE TABLE IF NOT EXISTS `evoto_logger` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `evento` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` char(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registro de acceso de los usuarios' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_nodos`
--

DROP TABLE IF EXISTS `evoto_nodos`;
CREATE TABLE IF NOT EXISTS `evoto_nodos` (
  `id_nodo` int(10) NOT NULL AUTO_INCREMENT,
  `nombre_nodo` varchar(100) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `ip_nodo` varchar(255) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `ruta_nodo` varchar(255) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `user` varchar(255) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  PRIMARY KEY (`id_nodo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_pagina`
--

DROP TABLE IF EXISTS `evoto_pagina`;
CREATE TABLE IF NOT EXISTS `evoto_pagina` (
  `id_pagina` int(5) NOT NULL AUTO_INCREMENT,
  `nombre` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `descripcion` char(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `modulo` char(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `nivel` int(2) NOT NULL DEFAULT '0',
  `parametro` char(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_pagina`),
  UNIQUE KEY `id_pagina` (`id_pagina`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Volcado de datos para la tabla `evoto_pagina`
--

INSERT INTO `evoto_pagina` (`id_pagina`, `nombre`, `descripcion`, `modulo`, `nivel`, `parametro`) VALUES
(1, 'index', 'Página principal de la Plataforma de votación electrónica.', 'General', 0, 'jquery=true&jquery-ui=true'),
(2, 'indexAdministrador', 'Pagina principal del administrador del sistema', 'Administrador', 4, 'jquery=true'),
(3, 'procesoElectoral', 'Modulo que permite crear un proceso electoral desde cero', 'Administrador', 4, 'jquery=true'),
(4, 'indexVotante', 'Página principal para el votante', 'votante', 1, 'jquery=true&jquery-ui=true'),
(5, 'parametrizarProcesoElectoral', 'Pagina que permite realizar la parametrización de un proceso seleccionado', 'Administrador', 4, 'jquery=true'),
(6, 'subirCenso', 'Modulo que permite subir el censo', 'Administrador', 4, 'jquery=true'),
(7, 'votacionesVotante', 'Pagina que permite listar las votaciones activas del votante', 'votante', 1, 'jquery=true&jquery-ui=true'),
(8, 'indexDelegado', 'Página de entrada al módulo de Delegado Electoral', 'delegado', 3, 'jquery=true'),
(9, 'iniciarProceso', 'Página desde donde se realizan las actividades de inicio del proceso de votaciones.', 'delegado', 3, 'jquery=true'),
(10, 'cerrarProceso', 'Bloque para las actividades de cierre de proceso de votación.', 'delegado', 3, 'jquery=true'),
(11, 'seguimientoProceso', 'Página para el seguimiento del proceso por parte del delegado', 'delegado', 3, 'jquery=true'),
(12, 'cambiarClaveDelegado', 'Modificación de la clave', 'delegado', 3, 'jquery=true'),
(13, 'cerrarSesionDelegado', 'Pagina que permite cerrar la sesion del usuario delegado', 'delegado', 3, 'jquery=true'),
(14, 'indexVeedor', 'Pagina inicial del veedor de la votaciones', 'veedor', 2, 'jquery=true'),
(15, 'procesoVotaciones', 'Pagina que permite verificar el proceso de votaciones', 'veedor', 2, 'jquery=true'),
(16, 'procesoCertificados', 'Pagina que permite verificar el proceso de generacion de certificados', 'veedor', 2, 'jquery=true'),
(17, 'procesoAccesos', 'Pagina que permite verificar el proceso de accesos a la plataforma', 'veedor', 2, 'jquery=true'),
(18, 'procesoAccesosFallidos', 'Pagina que permite verificar el proceso de accesos fallidos a la plataforma', 'veedor', 2, 'jquery=true'),
(19, 'bitacoraVeedor', 'Pagina que permite registrar la bitacora de votacion', 'veedor', 2, 'jquery=true'),
(20, 'resultadosVeedor', 'Pagina que permite revisar los resultados de la votacion', 'veedor', 2, 'jquery=true'),
(21, 'consultaProceso', 'Pagina que permite verificar el proceso total de la votacion', 'veedor', 2, 'jquery=true'),
(22, 'cambiarClaveVeedor', 'Modificación de la clave', 'veedor', 2, 'jquery=true'),
(26, 'cambiarClaveVotante', 'Modificación de la clave', 'votante', 1, 'jquery=true'),
(25, 'cerrarSesionVotante', 'Pagina que permite cerrar la sesion del usuario votante', 'votante', 1, 'jquery=true'),
(23, 'cambiarClaveAdministrador', 'Modificación de la clave', 'Administrador', 4, 'jquery=true'),
(24, 'cerrarSesionAdministrador', 'Pagina que permite cerrar la sesion del usuario administrador', 'Administrador', 4, 'jquery=true'),
(27, 'segundaClaveVotante', 'Registro de la segunda clave del votante', 'votante', 1, 'jquery=true'),
(28, 'cerrarSesionVeedor', 'Cerrar la sesion del usuario veedor', 'veedor', 2, 'jquery=true'),
(29, 'hashCodigoFuente', 'Pagina que permite revisar el hash del codigo fuente', 'Administrador', 4, 'jquery=true'),
(30, 'gestionUsuarios', 'Pagina de Administracion de usuarios de la plataforma', 'Administrador', 4, 'jquery=true'),
(31, 'cambioPrimeraClave', 'Modulo que permite cambiar por primera vez la clave de acceso', 'general', 0, 'jquery=true'),
(32, 'indexSalas', 'Pagina principal Control de salas', 'jurado', 5, 'jquery=true'),
(33, 'indexSalas', 'Pagina principal Control de salas', 'jurado', 5, 'jquery=true'),
(34, 'bitacoraJurado', 'Pagina que permite registrar la bitacora de votacion en Control de salas', 'jurado', 5, 'jquery=true'),
(35, 'consultarCenso', 'Pagina que permite consultar el censo al jurado en Control de salas', 'jurado', 5, 'jquery=true'),
(36, 'cambiarClaveJurado', 'Pagina que permite cambio clave', 'jurado', 5, 'jquery=true'),
(37, 'cerrarSesionJurado', 'Pagina que permite cerrar sesion', 'jurado', 5, 'jquery=true');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_preguntasegundaclave`
--

DROP TABLE IF EXISTS `evoto_preguntasegundaclave`;
CREATE TABLE IF NOT EXISTS `evoto_preguntasegundaclave` (
  `idpregunta` int(10) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idpregunta`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `evoto_preguntasegundaclave`
--

INSERT INTO `evoto_preguntasegundaclave` (`idpregunta`, `descripcion`) VALUES
(1, 'Lugar de nacimiento de la madre'),
(2, 'Mejor amigo de la infancia'),
(3, 'Nombre de la primera mascota'),
(4, 'Profesor@ favorito'),
(5, 'Personaje favorito'),
(6, 'Ocupacion de la abuela'),
(7, 'Nombre del primer colegio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_procesoelectoral`
--

DROP TABLE IF EXISTS `evoto_procesoelectoral`;
CREATE TABLE IF NOT EXISTS `evoto_procesoelectoral` (
  `idprocesoelectoral` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechainicio` timestamp NULL DEFAULT NULL,
  `fechafin` timestamp NULL DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `cantidadelecciones` int(11) DEFAULT NULL,
  `dependenciasresponsables` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipoactoadministrativo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idactoadministrativo` int(11) DEFAULT NULL,
  `fechaactoadministrativo` date DEFAULT NULL,
  `tipovotacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idprocesoelectoral`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_segundaclave`
--

DROP TABLE IF EXISTS `evoto_segundaclave`;
CREATE TABLE IF NOT EXISTS `evoto_segundaclave` (
  `identificacion` int(15) NOT NULL,
  `idpregunta` int(5) NOT NULL,
  `respuesta` varchar(255) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `segundaclave` varchar(200) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_subsistema`
--

DROP TABLE IF EXISTS `evoto_subsistema`;
CREATE TABLE IF NOT EXISTS `evoto_subsistema` (
  `id_subsistema` int(7) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `etiqueta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `id_pagina` int(7) NOT NULL DEFAULT '0',
  `observacion` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id_subsistema`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci PACK_KEYS=0 COMMENT='Subsistemas que componen el aplicativo' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_tempFormulario`
--

DROP TABLE IF EXISTS `evoto_tempFormulario`;
CREATE TABLE IF NOT EXISTS `evoto_tempFormulario` (
  `id_sesion` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `formulario` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `campo` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `valor` text COLLATE utf8_unicode_ci NOT NULL,
  `fecha` char(50) COLLATE utf8_unicode_ci NOT NULL,
  KEY `id_sesion` (`id_sesion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_tipoestamento`
--

DROP TABLE IF EXISTS `evoto_tipoestamento`;
CREATE TABLE IF NOT EXISTS `evoto_tipoestamento` (
  `idtipo` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `ponderado` int(4) NOT NULL,
  PRIMARY KEY (`idtipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `evoto_tipoestamento`
--

INSERT INTO `evoto_tipoestamento` (`idtipo`, `descripcion`, `ponderado`) VALUES
(1, 'Egresados', 0),
(2, 'Administrativos', 0),
(3, 'Docentes', 0),
(4, 'Estudiantes', 0),
(5, 'Contratistas', 0),
(6, 'Docentes vinculación especial', 0),
(0, 'Todos', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_tiporestriccion`
--

DROP TABLE IF EXISTS `evoto_tiporestriccion`;
CREATE TABLE IF NOT EXISTS `evoto_tiporestriccion` (
  `idtipo` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nombre_campo` varchar(80) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`idtipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `evoto_tiporestriccion`
--

INSERT INTO `evoto_tiporestriccion` (`idtipo`, `descripcion`, `nombre_campo`) VALUES
(1, 'Todos', 'todos'),
(2, 'Excluir Egresados', 'egresados'),
(3, 'Excluir Funcionarios', 'funcionarios'),
(4, 'Exluir Contratistas', 'contratistas'),
(5, 'Excluir Estudiantes', 'estudiantes'),
(6, 'Excluir Docentes', 'docentes'),
(7, 'Excluir Docentes de vinculación especial', 'docentesve');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_tiporesultados`
--

DROP TABLE IF EXISTS `evoto_tiporesultados`;
CREATE TABLE IF NOT EXISTS `evoto_tiporesultados` (
  `idtipo` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idtipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `evoto_tiporesultados`
--

INSERT INTO `evoto_tiporesultados` (`idtipo`, `descripcion`) VALUES
(1, 'Cálculo Normal'),
(2, 'Cálculo Ponderado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_tipousuario`
--

DROP TABLE IF EXISTS `evoto_tipousuario`;
CREATE TABLE IF NOT EXISTS `evoto_tipousuario` (
  `idtipo` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idtipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `evoto_tipousuario`
--

INSERT INTO `evoto_tipousuario` (`idtipo`, `descripcion`) VALUES
(1, 'Votante'),
(2, 'Veedor'),
(3, 'Jurado - Delegado'),
(4, 'Administrador'),
(5, 'Jurado - Sala');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_tipovotacion`
--

DROP TABLE IF EXISTS `evoto_tipovotacion`;
CREATE TABLE IF NOT EXISTS `evoto_tipovotacion` (
  `idtipo` int(5) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idtipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `evoto_tipovotacion`
--

INSERT INTO `evoto_tipovotacion` (`idtipo`, `descripcion`) VALUES
(1, 'Presencial'),
(2, 'Internet'),
(3, 'Mixto'),
(4, 'Todos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_usuario`
--

DROP TABLE IF EXISTS `evoto_usuario`;
CREATE TABLE IF NOT EXISTS `evoto_usuario` (
  `id_usuario` bigint(20) NOT NULL DEFAULT '0',
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `apellido` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `correo` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `telefono` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `imagen` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `estilo` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'basico',
  `idioma` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'es_es',
  `estado` int(1) NOT NULL DEFAULT '0' COMMENT '0=No activo, 1=Activo, 2=Por Cambio de Clave',
  `acep_termi` int(15) NOT NULL DEFAULT '0',
  `acep_termi_tele` int(15) NOT NULL DEFAULT '0',
  `acep_termi_celu` int(15) NOT NULL DEFAULT '0',
  `acep_termi_direccion` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `envioCorreo` int(1) NOT NULL,
  `imagenBlob` longblob NOT NULL,
  `pass_url` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `evoto_usuario`
--

INSERT INTO `evoto_usuario` (`id_usuario`, `nombre`, `apellido`, `correo`, `telefono`, `imagen`, `clave`, `tipo`, `estilo`, `idioma`, `estado`, `acep_termi`, `acep_termi_tele`, `acep_termi_celu`, `acep_termi_direccion`, `envioCorreo`, `imagenBlob`, `pass_url`) VALUES
(899999230, 'Admin', 'Udistrital', 'esanchez1988@gmail.com', '3930000', '', '5994a993cbde3035b4c9cff8146e0cba62121c3b', '4', 'basico', 'es_es', 0, 0, 0, 0, '', 1, '', 0),
(899999231, 'Jurado ', 'Universidad Distrital', 'esanchez1988@gmail.com', '3930000', '', '5994a993cbde3035b4c9cff8146e0cba62121c3b', '3', 'basico', 'es_es', 1, 0, 0, 0, '', 1, '', 0),
(899999232, 'Veedor Procesos', 'Universidad Distrital', 'esanchez1988@gmail.com', '1234566', '', '5994a993cbde3035b4c9cff8146e0cba62121c3b', '2', 'basico', 'es_es', 1, 0, 0, 0, '', 1, '', 0),
(528369731234, 'Claudia Jimena	', 'MondragÃ³n	', 'cjimena20@gmail.co', '3212094503', '', '5994a993cbde3035b4c9cff8146e0cba62121c3b', '3', 'basico', 'es_es', 0, 0, 0, 0, '', 0, '', 0),
(80792580, 'Camilo ', 'Bustos', 'leo@udistrital.edu.co', '3238400', '', '0e32ffd2fb0ab0697b02983681d511a91482b6fd', '3', 'basico', 'es_es', 1, 0, 0, 0, '', 0, '', 0),
(79905939, 'Jose David', 'Rivera Escobar', 'jodaries@gmail.com', '3212012391', '', '5994a993cbde3035b4c9cff8146e0cba62121c3b', '2', 'basico', 'es_es', 2, 0, 0, 0, '', 0, '', 0),
(0, 'Usuario', 'Prueba', 'usuario@prueba.com', '12345678', '', '5994a993cbde3035b4c9cff8146e0cba62121c3b', '3', 'basico', 'es_es', 1, 0, 0, 0, '', 0, '', 0),
(12345, 'dfsdfsd', 'sdfsdfsdf', 'sdfsdss@ddd.cc', '123456444', '', 'c47d254f49d25ebeedfcf5f096c1c18c9f20b6cf', '4', 'basico', 'es_es', 2, 0, 0, 0, '', 0, '', 0),
(899999234, 'sistemas', 'salas', 'computo@udistrital.edu.co', '3238924', '', '5994a993cbde3035b4c9cff8146e0cba62121c3b', '5', 'basico', 'es_es', 2, 0, 0, 0, '', 0, '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_usuario_subsistema`
--

DROP TABLE IF EXISTS `evoto_usuario_subsistema`;
CREATE TABLE IF NOT EXISTS `evoto_usuario_subsistema` (
  `id_usuario` int(6) NOT NULL DEFAULT '0',
  `id_subsistema` int(6) NOT NULL DEFAULT '0',
  `estado` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Relacion de usuarios que tienen acceso a modulos especiales';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_valor_sesion`
--

DROP TABLE IF EXISTS `evoto_valor_sesion`;
CREATE TABLE IF NOT EXISTS `evoto_valor_sesion` (
  `sesionId` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `variable` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `valor` char(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiracion` bigint(20) NOT NULL,
  PRIMARY KEY (`sesionId`,`variable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Valores de sesion';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_votocodificado`
--

DROP TABLE IF EXISTS `evoto_votocodificado`;
CREATE TABLE IF NOT EXISTS `evoto_votocodificado` (
  `idvoto` int(11) NOT NULL AUTO_INCREMENT,
  `ideleccion` int(11) NOT NULL,
  `voto` text COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `estamento` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idvoto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Registro de Votos' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evoto_votodecodificado`
--

DROP TABLE IF EXISTS `evoto_votodecodificado`;
CREATE TABLE IF NOT EXISTS `evoto_votodecodificado` (
  `idvoto` int(11) NOT NULL AUTO_INCREMENT,
  `ideleccion` int(11) NOT NULL,
  `idlista` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `estamento` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idvoto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Se llena al final de la jornada  (votos decodificados)' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
