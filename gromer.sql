-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2025 a las 18:22:26
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gromer`
--

DROP TABLE IF EXISTS `perro_recibe_servicio`;
DROP TABLE IF EXISTS `servicios`;
DROP TABLE IF EXISTS `perros`;
DROP TABLE IF EXISTS `empleados`;
DROP TABLE IF EXISTS `clientes`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `Dni` varchar(9) NOT NULL,
  `Nombre` varchar(15) NOT NULL,
  `Apellido1` varchar(15) NOT NULL,
  `Apellido2` varchar(15) NOT NULL,
  `Direccion` varchar(200) DEFAULT NULL,
  `Tlfno` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`Dni`, `Nombre`, `Apellido1`, `Apellido2`, `Direccion`, `Tlfno`) VALUES
('10101010A', 'Carmen', 'Gutiérrez', 'Iglesias', 'Calle de la Merced 3, 10300 Navalmoral de la Mata, Cáceres', '012345678'),
('11111111A', 'Manuel', 'García', 'González', 'Calle Mayor 23, 10300 Navalmoral de la Mata, Cáceres', '123456789'),
('12345678A', 'Carlos', 'García', 'López', 'Calle Mayor 10, 45600 Talavera de la Reina, Toledo', '600000001'),
('12345678B', 'María', 'Martínez', 'Fernández', 'Avenida de la Constitución 20, 45600 Talavera de la Reina, Toledo', '600000002'),
('12345678C', 'Juan', 'Rodríguez', 'Gómez', 'Calle San Juan 15, 45600 Talavera de la Reina, Toledo', '600000003'),
('12345678D', 'Ana', 'González', 'Ruiz', 'Plaza del Reloj 5, 45600 Talavera de la Reina, Toledo', '600000004'),
('12345678E', 'Pedro', 'Hernández', 'Díaz', 'Calle del Sol 25, 45600 Talavera de la Reina, Toledo', '600000005'),
('12345678F', 'Laura', 'Jiménez', 'Moreno', 'Avenida de los Reyes Católicos 12, 45600 Talavera de la Reina, Toledo', '600000006'),
('12345678G', 'Luis', 'Sánchez', 'Pérez', 'Calle Nueva 30, 45600 Talavera de la Reina, Toledo', '600000007'),
('12345678H', 'Carmen', 'Torres', 'Ramírez', 'Calle Real 8, 45600 Talavera de la Reina, Toledo', '600000008'),
('12345678I', 'Miguel', 'Vázquez', 'Álvarez', 'Avenida de la Libertad 35, 45600 Talavera de la Reina, Toledo', '600000009'),
('12345678J', 'Sara', 'Romero', 'García', 'Calle Jardines 17, 45600 Talavera de la Reina, Toledo', '600000010'),
('12345678K', 'David', 'Molina', 'Ortiz', 'Calle Olmo 2, 45600 Talavera de la Reina, Toledo', '600000011'),
('12345678L', 'Elena', 'Domínguez', 'Núñez', 'Plaza Mayor 1, 45600 Talavera de la Reina, Toledo', '600000012'),
('12345678M', 'Fernando', 'Santos', 'Gutiérrez', 'Avenida de la Paz 40, 45600 Talavera de la Reina, Toledo', '600000013'),
('12345678N', 'Isabel', 'Ramos', 'Méndez', 'Calle Gran Vía 22, 45600 Talavera de la Reina, Toledo', '600000014'),
('12345678O', 'Javier', 'Navarro', 'Cano', 'Calle del Río 14, 45600 Talavera de la Reina, Toledo', '600000015'),
('12345678P', 'Patricia', 'Ortega', 'Serrano', 'Calle Luna 27, 45600 Talavera de la Reina, Toledo', '600000016'),
('12345678Q', 'Alberto', 'Rubio', 'Blanco', 'Avenida del Prado 19, 45600 Talavera de la Reina, Toledo', '600000017'),
('12345678R', 'Raquel', 'Gil', 'Martín', 'Calle Verde 13, 45600 Talavera de la Reina, Toledo', '600000018'),
('12345678S', 'Andrés', 'Castro', 'Ruiz', 'Plaza Nueva 7, 45600 Talavera de la Reina, Toledo', '600000019'),
('12345678T', 'Marta', 'Vega', 'Cabrera', 'Calle Azul 9, 45600 Talavera de la Reina, Toledo', '600000020'),
('22222222B', 'María', 'López', 'Fernández', 'Avenida de Extremadura 15, 10300 Navalmoral de la Mata, Cáceres', '234567890'),
('22345678A', 'Roberto', 'Martínez', 'Alonso', 'Calle de la Constitución 12, 45510 Fuensalida, Toledo', '600000021'),
('22345678B', 'Alicia', 'Gómez', 'Fernández', 'Calle de la Iglesia 5, 45510 Fuensalida, Toledo', '600000022'),
('22345678C', 'Manuel', 'López', 'García', 'Calle Real 8, 45510 Fuensalida, Toledo', '600000023'),
('22345678D', 'Laura', 'Pérez', 'Sánchez', 'Calle San Juan 3, 45510 Fuensalida, Toledo', '600000024'),
('22345678E', 'José', 'Rodríguez', 'Hernández', 'Avenida de la Paz 10, 45510 Fuensalida, Toledo', '600000025'),
('32345678A', 'Raúl', 'Fernández', 'Pérez', 'Calle del Castillo 1, 45560 Oropesa, Toledo', '600000026'),
('32345678B', 'Sofía', 'Moreno', 'García', 'Calle Mayor 5, 45560 Oropesa, Toledo', '600000027'),
('32345678C', 'Ignacio', 'Serrano', 'Hernández', 'Plaza de la Villa 3, 45560 Oropesa, Toledo', '600000028'),
('32345678D', 'Julia', 'Blanco', 'López', 'Calle Real 10, 45560 Oropesa, Toledo', '600000029'),
('32345678E', 'Miguel', 'Núñez', 'Martín', 'Calle Iglesia 7, 45560 Oropesa, Toledo', '600000030'),
('32345678F', 'César', 'Rojas', 'Mendoza', 'Calle San Miguel 2, 45567 Lagartera, Toledo', '600000031'),
('32345678G', 'Paula', 'Cruz', 'Torres', 'Calle del Sol 6, 45567 Lagartera, Toledo', '600000032'),
('32345678H', 'Héctor', 'Medina', 'Ruiz', 'Avenida de la Constitución 4, 45672 Ventas de San Julián, Toledo', '600000033'),
('32345678I', 'Aitana', 'Vega', 'Romero', 'Calle Nueva 11, 45672 Ventas de San Julián, Toledo', '600000034'),
('32345678J', 'Rubén', 'González', 'Díaz', 'Calle Ancha 9, 45634 Calzada de Oropesa, Toledo', '600000035'),
('33333333C', 'Antonio', 'Martínez', 'Rodríguez', 'Calle Cervantes 7, 10300 Navalmoral de la Mata, Cáceres', '345678901'),
('44444444D', 'Ana', 'Sánchez', 'Pérez', 'Calle San Roque 42, 10300 Navalmoral de la Mata, Cáceres', '456789012'),
('55555555A', 'Javier', 'Gómez', 'Martín', 'Calle Zurbarán 10, 10300 Navalmoral de la Mata, Cáceres', '567890123'),
('66666666A', 'Laura', 'Fernández', 'García', 'Plaza de España 5, 10300 Navalmoral de la Mata, Cáceres', '678901234'),
('77777777A', 'Carlos', 'Díaz', 'Ruiz', 'Calle del Convento 31, 10300 Navalmoral de la Mata, Cáceres', '789012345'),
('88888888A', 'Sara', 'Muñoz', 'Dominguez', 'Calle de la Cruz 8, 10300 Navalmoral de la Mata, Cáceres', '890123456'),
('99999999A', 'Pedro', 'Vázquez', 'Hernández', 'Avenida de la Constitución 14, 10300 Navalmoral de la Mata, Cáceres', '901234567');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `Dni` varchar(9) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Rol` enum('EMPLEADO','ADMIN','AUXILIAR') NOT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Apellido1` varchar(15) NOT NULL,
  `Apellido2` varchar(15) NOT NULL,
  `Calle` varchar(30) DEFAULT NULL,
  `Numero` int(11) DEFAULT NULL,
  `Cp` varchar(5) DEFAULT NULL,
  `Poblacion` varchar(50) DEFAULT NULL,
  `Provincia` varchar(20) DEFAULT NULL,
  `Tlfno` varchar(9) DEFAULT NULL,
  `Profesion` enum('NUTRICIONISTA','ESTILISTA','AUXILIAR','ATT.CLIENTE','ADMIN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perros`
--

CREATE TABLE `perros` (
  `ID_Perro` int(11) NOT NULL,
  `Dni_duenio` varchar(9) DEFAULT NULL,
  `Nombre` varchar(20) NOT NULL,
  `Fecha_Nto` date DEFAULT NULL,
  `Raza` varchar(40) NOT NULL,
  `Peso` decimal(5,3) DEFAULT NULL,
  `Altura` int(11) DEFAULT NULL,
  `Observaciones` varchar(200) DEFAULT NULL,
  `Numero_Chip` varchar(15) NOT NULL,
  `Sexo` enum('Macho','Hembra') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perros`
--

INSERT INTO `perros` (`ID_Perro`, `Dni_duenio`, `Nombre`, `Fecha_Nto`, `Raza`, `Peso`, `Altura`, `Observaciones`, `Numero_Chip`, `Sexo`) VALUES
(1, '12345678A', 'Rex', '1963-10-13', 'Labrador Retriever', 30.500, 60, 'Activo y juguetón', '001-0001-00001', 'Macho'),
(2, '12345678B', 'Bella', '1933-07-13', 'Bulldog Francés', 12.700, 30, 'Juguetona y cariñosa', '001-0001-00002', 'Hembra'),
(3, '12345678C', 'Max', '1994-07-13', 'Pastor Alemán', 35.200, 65, 'Excelente guardián', '001-0001-00003', 'Macho'),
(4, '12345678D', 'Luna', '2024-08-15', 'Golden Retriever', 31.800, 58, 'Es un perro muy aprensivo', '001-0001-00004', 'Hembra'),
(5, '12345678E', 'Charlie', '1872-08-13', 'Beagle', 15.100, 40, 'Activo y curioso', '001-0001-00005', 'Macho'),
(6, '12345678F', 'Daisy', '1994-08-13', 'Yorkshire Terrier', 3.400, 20, 'Valiente y enérgica', '001-0001-00006', 'Hembra'),
(7, '12345678G', 'Rocky', '1964-01-13', 'Boxer', 29.000, 60, 'Fuerte y protector', '001-0001-00007', 'Macho'),
(8, '12345678H', 'Sadie', '1629-02-13', 'Caniche', 4.600, 25, 'Juguetona y cariñosa', '001-0001-00008', 'Hembra'),
(9, '12345678I', 'Buster', '1902-09-13', 'Dachshund', 9.300, 22, 'Leal y curioso', '001-0001-00009', 'Macho'),
(10, '12345678J', 'Molly', '1537-07-13', 'Rottweiler', 44.500, 68, 'Excelente guardián', '001-0001-00010', 'Hembra'),
(11, '12345678K', 'Toby', '1964-03-13', 'Chihuahua', 2.400, 20, 'Valiente y pequeño', '001-0001-00011', 'Macho'),
(12, '12345678L', 'Bailey', '1933-09-13', 'Schnauzer', 7.900, 35, 'Obediente y vigilante', '001-0001-00012', 'Macho'),
(13, '12345678M', 'Coco', '1903-02-13', 'Cocker Spaniel', 13.200, 39, 'Amigable y activo', '001-0001-00013', 'Macho'),
(14, '12345678N', 'Jake', '2019-12-26', 'Border Collie', 18.400, 53, 'Inteligente y trabajador', '001-0001-00014', 'Macho'),
(15, '12345678O', 'Lucy', '2018-12-27', 'Shih Tzu', 6.200, 25, 'Adorable y dócil', '001-0001-00015', 'Hembra'),
(16, '12345678P', 'Rocky', '2013-12-29', 'Labrador Retriever', 29.700, 60, 'Fuerte y activo', '001-0001-00016', 'Macho'),
(17, '12345678Q', 'Lola', '2021-12-28', 'Bulldog Francés', 12.900, 30, 'Amistosa y curiosa', '001-0001-00017', 'Hembra'),
(18, '12345678R', 'Bruno', '2022-12-29', 'Boxer', 28.500, 60, 'Protector y juguetón', '001-0001-00018', 'Macho'),
(19, '12345678S', 'Luna', '2020-12-30', 'Golden Retriever', 32.100, 58, 'Obediente y cariñosa', '001-0001-00019', 'Hembra'),
(20, '12345678T', 'Simba', '2020-01-01', 'Rottweiler', 45.800, 68, 'Fuerte y leal', '001-0001-00020', 'Macho'),
(21, '12345678G', 'Rocky Jr.', '2023-01-01', 'Boxer', 27.800, 58, 'Energético y protector', '001-0001-00021', 'Macho'),
(22, '12345678G', 'Buddy', '2024-01-02', 'Boxer', 26.500, 57, 'Amistoso y fiel', '001-0001-00022', 'Macho'),
(23, '11111111A', 'Lucky', '2012-01-06', 'Chihuahua', 2.300, 18, 'Pequeño y cariñoso', '001-0001-00023', 'Macho'),
(24, '22222222B', 'Princess', '2023-01-04', 'Chihuahua', 2.100, 17, 'Juguetona y alerta', '001-0001-00024', 'Hembra'),
(25, '33333333C', 'Coco', '2021-01-05', 'Chihuahua', 2.500, 19, 'Amigable y enérgico', '001-0001-00025', 'Macho'),
(26, '44444444D', 'Buddy', '2024-01-06', 'Chihuahua', 2.200, 18, 'Leal y valiente', '001-0001-00026', 'Macho'),
(27, '12345678A', 'Lucky', '2023-01-07', 'Bichon Maltes', 4.000, 24, 'Energético y cariñoso', '001-0001-00027', 'Macho'),
(28, '12345678A', 'Daisy', '2024-01-08', 'Bichon Maltes', 4.500, 25, 'Divertida y leal', '001-0001-00028', 'Hembra'),
(29, '12345678B', 'Coco', '2022-01-09', 'Bichon Maltes', 3.600, 22, 'Juguetón y afectuoso', '001-0001-00029', 'Macho'),
(30, '12345678B', 'Luna', '2013-01-12', 'Bichon Maltes', 4.000, 23, 'Juguetona y cariñosa', '001-0001-00030', 'Hembra'),
(31, '12345678C', 'Rocky', '2021-01-11', 'Beagle', 15.600, 40, 'Leal y enérgico', '001-0001-00031', 'Macho'),
(32, '12345678C', 'Sophie', '2013-01-14', 'Beagle', 14.900, 39, 'Cariñosa y juguetona', '001-0001-00032', 'Hembra'),
(33, '12345678D', 'Copper', '2022-01-13', 'Beagle', 15.400, 40, 'Divertido y amigable', '001-0001-00033', 'Macho'),
(34, '12345678D', 'Zoe', '2023-02-03', 'Beagle', 15.200, 39, 'Amigable y sociable', '001-0001-00034', 'Hembra'),
(35, '12345678E', 'Buster', '2021-11-09', 'Beagle', 15.100, 39, 'Inteligente y curioso', '001-0001-00035', 'Macho'),
(36, '12345678E', 'Daisy', '2013-02-07', 'Beagle', 15.500, 40, 'Leal y enérgica', '001-0001-00036', 'Hembra'),
(37, '12345678F', 'Max', '2020-11-16', 'Beagle', 15.300, 40, 'Juguetón y amigable', '001-0001-00037', 'Macho'),
(38, '12345678F', 'Maggie', '2022-12-13', 'Beagle', 15.000, 39, 'Cariñosa y sociable', '001-0001-00038', 'Hembra'),
(39, '12345678G', 'Cooper', '2011-12-14', 'Beagle', 15.200, 39, 'Divertido y leal', '001-0001-00039', 'Macho'),
(40, '12345678G', 'Lucy', '2023-01-20', 'Beagle', 15.400, 39, 'Juguetona y cariñosa', '001-0001-00040', 'Hembra'),
(41, '32345678I', 'Bruno', '2021-11-07', 'Bulldog Francés', 12.700, 30, 'Juguetona y cariñosa', '001-0001-00060', 'Hembra'),
(42, '66666666A', 'Lucas', '2023-11-16', 'Yorkshire Terrier', 3.400, 20, 'Valiente y enérgica', '001-0001-00061', 'Hembra'),
(43, '32345678B', 'Lola', '2023-02-05', 'Bulldog Francés', 12.700, 30, 'Juguetona y cariñosa', '001-0001-00062', 'Hembra'),
(44, '22345678C', 'Max', '1932-05-13', 'Cocker Spaniel', 13.200, 39, 'Amigable y activo', '001-0001-00063', 'Macho'),
(45, '88888888A', 'Rocky', '2021-01-29', 'Chihuahua', 2.400, 20, 'Valiente y pequeño', '001-0001-00064', 'Macho'),
(46, '32345678H', 'Daisy', '2020-02-01', 'Labrador Retriever', 30.500, 60, 'Activo y amistoso', '001-0001-00065', 'Macho'),
(47, '32345678J', 'Sasha', '2015-12-28', 'Rottweiler', 44.500, 68, 'Excelente guardián', '001-0001-00066', 'Hembra'),
(48, '22345678A', 'Toby', '2023-02-01', 'Schnauzer', 7.900, 35, 'Obediente y vigilante', '001-0001-00067', 'Macho'),
(49, '32345678E', 'Buddy', '2021-12-11', 'Beagle', 15.100, 40, 'Activo y curioso', '001-0001-00068', 'Macho'),
(50, '99999999A', 'Zeus', '2020-12-16', 'Rottweiler', 44.500, 68, 'Excelente guardián', '001-0001-00069', 'Hembra'),
(51, '32345678A', 'Luna', '2016-12-22', 'Labrador Retriever', 30.500, 60, 'Activo y amistoso', '001-0001-00070', 'Macho'),
(52, '55555555A', 'Canela', '2018-12-31', 'Beagle', 15.100, 40, 'Activo y curioso', '001-0001-00071', 'Macho'),
(53, '22345678B', 'Luna', '1964-01-13', 'Bichon Maltes', 4.000, 24, 'Energético y cariñoso', '001-0001-00072', 'Macho'),
(55, '32345678G', 'Rocky', '2018-02-14', 'Boxer', 29.000, 60, 'Fuerte y protector', '001-0001-00074', 'Macho'),
(56, '10101010A', 'Lola', '2022-12-11', 'Chihuahua', 2.400, 20, 'Valiente y pequeño', '001-0001-00075', 'Hembra'),
(57, '32345678C', 'Sam', '2019-11-29', 'Pastor Alemán', 35.200, 65, 'Excelente guardián', '001-0001-00076', 'Macho'),
(58, '22345678D', 'Luna', '2018-11-17', 'Cocker Spaniel', 13.200, 39, 'Amigable y activo', '001-0001-00077', 'Hembra'),
(59, '32345678D', 'Bruno', '2024-01-25', 'Golden Retriever', 31.800, 58, 'Obediente y amigable', '001-0001-00078', 'Hembra'),
(60, '22345678E', 'Max', '2023-02-06', 'Beagle', 15.100, 40, 'Activo y curioso', '001-0001-00079', 'Macho'),
(61, '77777777A', 'Rocky', '2024-02-06', 'Chihuahua', 2.400, 20, 'Valiente y pequeño', '001-0001-00080', 'Macho'),
(62, NULL, 'Koldo', '2023-12-31', 'Raza mixta', 5.000, 35, 'Abandono', '001-0001-00081', 'Macho'),
(63, NULL, 'Reus', '2024-06-03', 'Galgo', 8.300, 45, 'Rescate', '001-0001-00082', 'Macho');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perro_recibe_servicio`
--

CREATE TABLE `perro_recibe_servicio` (
  `Sr_Cod` int(11) NOT NULL,
  `Cod_Servicio` varchar(6) NOT NULL,
  `ID_Perro` int(11),
  `Fecha` date NOT NULL,
  `Incidencias` varchar(400) DEFAULT NULL,
  `Precio_Final` decimal(5,2) NOT NULL,
  `Dni` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `Codigo` varchar(6) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Precio` decimal(5,2) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`Codigo`, `Nombre`, `Precio`, `Descripcion`) VALUES
('SVBE01', 'Baño y secado', 25.99, 'Baño completo con champú y secado adecuado.'),
('SVBE02', 'Corte de Pelo', 35.99, 'Corte de pelo según el estilo deseado o las necesidades de la raza. Incluye baño.'),
('SVBE03', 'Corte de Uñas', 9.99, 'Corte de uñas para mantenerlas en una longitud segura y cómoda.'),
('SVBE04', 'Limpieza de Oídos', 10.99, 'Limpieza suave y cuidadosa de los oídos para eliminar el exceso de cera.'),
('SVBE05', 'Limpieza Dental', 45.99, 'Limpieza dental para eliminar la acumulación de placa y sarro.'),
('SVBE06', 'Desenredado', 20.99, 'Eliminación de nudos y cepillado del pelo para mantenerlo suave y saludable. Incluye baño en seco'),
('SVBE07', 'Tratamiento Spa Premium', 55.99, 'Baño turco, aromaterapia y masaje'),
('SVBE08', 'Tratamiento Spa Basic', 45.99, 'Baño turco y masaje'),
('SVBE09', 'Tintes', 40.99, 'Servicio de teñido de pelo utilizando tintes seguros para animales.'),
('SVBE10', 'Spa Terapeutico', 75.99, 'Baño turco y masaje'),
('SVNUT1', 'Consulta inicial Nutricion', 30.00, 'Toma de datos, diagnóstico inicial y régimen personalizado.'),
('SVNUT2', 'Consulta de mantenimiento', 20.00, 'Toma de medidas, evaluación y cambio de dieta.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`Dni`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`Dni`);

--
-- Indices de la tabla `perros`
--
ALTER TABLE `perros`
  ADD PRIMARY KEY (`ID_Perro`),
  ADD UNIQUE KEY `Numero_Chip` (`Numero_Chip`),
  ADD KEY `Dni_duenio` (`Dni_duenio`);

--
-- Indices de la tabla `perro_recibe_servicio`
--
ALTER TABLE `perro_recibe_servicio`
  ADD PRIMARY KEY (`Sr_Cod`),
  ADD KEY `Dni` (`Dni`),
  ADD KEY `Cod_Servicio` (`Cod_Servicio`),
  ADD KEY `ID_Perro` (`ID_Perro`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`Codigo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `perros`
--
ALTER TABLE `perros`
  MODIFY `ID_Perro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT de la tabla `perro_recibe_servicio`
--
ALTER TABLE `perro_recibe_servicio`
  MODIFY `Sr_Cod` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `perros`
--
ALTER TABLE `perros`
  ADD CONSTRAINT `perros_ibfk_1` FOREIGN KEY (`Dni_duenio`) REFERENCES `clientes` (`Dni`) ON DELETE CASCADE;

--
-- Filtros para la tabla `perro_recibe_servicio`
--
ALTER TABLE `perro_recibe_servicio`
  ADD CONSTRAINT `perro_recibe_servicio_ibfk_1` FOREIGN KEY (`Dni`) REFERENCES `empleados` (`Dni`) ON DELETE CASCADE,
  ADD CONSTRAINT `perro_recibe_servicio_ibfk_2` FOREIGN KEY (`Cod_Servicio`) REFERENCES `servicios` (`Codigo`) ON DELETE CASCADE,
  ADD CONSTRAINT `perro_recibe_servicio_ibfk_3` FOREIGN KEY (`ID_Perro`) REFERENCES `perros` (`ID_Perro`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
