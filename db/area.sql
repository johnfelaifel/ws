-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-04-2022 a las 23:35:31
-- Versión del servidor: 8.0.18
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `simec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cod_archivistico` varchar(5) NOT NULL,
  `estado` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id`, `nombre`, `cod_archivistico`, `estado`) VALUES
(1, '100 - DIRECCION ESTRATÉGICA-GERENCIA', '100', 'A'),
(2, '101 - ASISTENTE DE GERENCIA', '101', 'A'),
(3, '102 - COMPRAS', '102', 'A'),
(4, '110 - OFICIAL DE CUMPLIMIENTO', '110', 'A'),
(5, '120 - AUDITOR INTERNO', '120', 'A'),
(6, '130 - HSEQ', '130', 'A'),
(7, '210 - GESTION COMERCIAL', '210', 'A'),
(8, '230 - CONTROL Y MONITOREO', '230', 'A'),
(9, '230 - LOGISTICA', '230', 'A'),
(10, '310 - GERENCIA TALENTO HUMANO', '310', 'A'),
(11, '320 - GERENCIA DESARROLLO TECNOLOGICO', '320', 'A'),
(12, '330 - GESTION DOCUMENTAL', '330', 'A'),
(13, '400 - GESTION FINANCIERO', '400', 'A');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
