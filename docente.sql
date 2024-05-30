-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 30-05-2024 a las 23:02:03
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mi_base_de_datos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

DROP TABLE IF EXISTS `docente`;
CREATE TABLE IF NOT EXISTS `docente` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) NOT NULL,
  `apellido_paterno` char(10) NOT NULL,
  `apellido_materno` char(10) NOT NULL,
  `numero` char(3) NOT NULL,
  `curp` char(18) NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `edad` int NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id`, `nombre`, `apellido_paterno`, `apellido_materno`, `numero`, `curp`, `email`, `edad`) VALUES
(1, 'John', 'Doe', 'Smith', '123', 'JDOE123456HDFRRT01', 'john@example.com', 30),
(2, 'Jane', 'Smith', 'Johnson', '678', 'JSMI678901HDFRRT02', 'jane@example.com', 25),
(3, 'Carlos', 'Rivera', 'Lopez', '112', 'CRIV112233HDFRRT03', 'carlos@example.com', 40),
(5, 'Arturo', 'Rodriguez', 'Velasco', '124', 'AOHE040212MCLRTLB0', 'arturo.burciagac010@gmail.com', 26),
(6, 'Arturo', 'Rodriguez', 'De la Garz', '124', 'AOHE040212MCLRTLB0', 'sonia.velascoc010@gmail.com', 20);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
