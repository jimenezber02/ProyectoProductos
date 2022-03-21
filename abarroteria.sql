-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-08-2021 a las 17:39:23
-- Versión del servidor: 10.4.16-MariaDB
-- Versión de PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `abarroteria_mary`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `id` int(5) NOT NULL,
  `categoria` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id`, `categoria`) VALUES
(1, 'Granos'),
(2, 'cafe'),
(3, 'calzados'),
(4, 'Enlatados'),
(5, 'Galletas'),
(6, 'Confites'),
(7, 'Refrescos'),
(8, 'Carnes'),
(9, 'Detergentes'),
(10, 'Escolar'),
(11, 'Aseo'),
(12, 'Especias'),
(13, 'Pan'),
(14, 'Medicamentos'),
(15, 'Telas'),
(16, 'Harina'),
(17, 'Fideos'),
(18, 'otros'),
(19, 'Granos'),
(20, 'cafe'),
(21, 'calzados'),
(22, 'Enlatados'),
(23, 'Galletas'),
(24, 'Confites'),
(25, 'Refrescos'),
(26, 'Carnes'),
(27, 'Detergentes'),
(28, 'Escolar'),
(29, 'Aseo'),
(30, 'Especias'),
(31, 'Pan'),
(32, 'Medicamentos'),
(33, 'Telas'),
(34, 'Harina'),
(35, 'Fideos'),
(36, 'otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cli` int(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `cedula` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cli`, `nombre`, `apellido`, `cedula`) VALUES
(1, 'Carlos', 'Quintero', '-'),
(2, 'Raul', 'Jacinto', '-'),
(4, 'Antonia', 'Prado', '-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_p_cobrar`
--

CREATE TABLE `cuentas_p_cobrar` (
  `id_cuentxcobrar` int(20) NOT NULL,
  `cuenta` float NOT NULL,
  `id_cli` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cuentas_p_cobrar`
--

INSERT INTO `cuentas_p_cobrar` (`id_cuentxcobrar`, `cuenta`, `id_cli`) VALUES
(1, 5.95, 1),
(2, 2.95, 2),
(4, 7.75, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deuda_anteriores`
--

CREATE TABLE `deuda_anteriores` (
  `id` int(5) NOT NULL,
  `monto` float NOT NULL,
  `id_cuentxcobrar` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `deuda_anteriores`
--

INSERT INTO `deuda_anteriores` (`id`, `monto`, `id_cuentxcobrar`) VALUES
(2, 2.95, 2),
(3, 2.95, 2),
(5, 4.95, 1),
(6, 4.95, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_ped` int(20) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `anio` varchar(4) DEFAULT NULL,
  `mes` varchar(10) DEFAULT NULL,
  `diaS` varchar(12) DEFAULT NULL,
  `dia` int(2) DEFAULT NULL,
  `valor` float NOT NULL,
  `estado` varchar(14) NOT NULL,
  `comentario` varchar(120) DEFAULT NULL,
  `id_cuentxcobrar` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_ped`, `fecha`, `anio`, `mes`, `diaS`, `dia`, `valor`, `estado`, `comentario`, `id_cuentxcobrar`) VALUES
(2, '2021/Julio/31', '2021', 'Julio', 'Sabado', 31, 5.95, 'ANTERIOR', '', 2),
(4, '2021/Agosto/1', '2021', 'Agosto', 'Domingo', 1, 5.95, 'ANTERIOR', '', 1),
(5, '2021/Agosto/1', '2021', 'Agosto', 'Domingo', 1, 1, 'RECIENTE', '', 1),
(6, '2021/Agosto/2', '2021', 'Agosto', 'Lunes', 2, 5.95, 'ANTERIOR', '', 4),
(7, '2021/Agosto/2', '2021', 'Agosto', 'Lunes', 2, 2.8, 'RECIENTE', '', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(5) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(20) NOT NULL,
  `precio` float NOT NULL,
  `id_categoria` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `precio`, `id_categoria`) VALUES
(1, 'a01', 'Aceituna', 'Unidad', 0.85, 36),
(2, 'cafe01', 'Duran', 'Unidad', 0.4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prod_pedidos`
--

CREATE TABLE `prod_pedidos` (
  `id` int(20) NOT NULL,
  `producto` varchar(30) NOT NULL,
  `cantidad` int(2) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `costo` float DEFAULT NULL,
  `id_ped` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saldos`
--

CREATE TABLE `saldos` (
  `id` int(5) NOT NULL,
  `monto` float DEFAULT NULL,
  `id_cli` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `saldos`
--

INSERT INTO `saldos` (`id`, `monto`, `id_cli`) VALUES
(1, 0, 1),
(2, 0, 2),
(4, 0, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cli`);

--
-- Indices de la tabla `cuentas_p_cobrar`
--
ALTER TABLE `cuentas_p_cobrar`
  ADD PRIMARY KEY (`id_cuentxcobrar`),
  ADD KEY `fk1` (`id_cli`);

--
-- Indices de la tabla `deuda_anteriores`
--
ALTER TABLE `deuda_anteriores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cuentxcobrar` (`id_cuentxcobrar`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_ped`),
  ADD KEY `id_cuentxcobrar` (`id_cuentxcobrar`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prod_pedidos`
--
ALTER TABLE `prod_pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ped` (`id_ped`);

--
-- Indices de la tabla `saldos`
--
ALTER TABLE `saldos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cli` (`id_cli`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cli` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cuentas_p_cobrar`
--
ALTER TABLE `cuentas_p_cobrar`
  MODIFY `id_cuentxcobrar` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `deuda_anteriores`
--
ALTER TABLE `deuda_anteriores`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_ped` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prod_pedidos`
--
ALTER TABLE `prod_pedidos`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `saldos`
--
ALTER TABLE `saldos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cuentas_p_cobrar`
--
ALTER TABLE `cuentas_p_cobrar`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`id_cli`) REFERENCES `clientes` (`id_cli`);

--
-- Filtros para la tabla `deuda_anteriores`
--
ALTER TABLE `deuda_anteriores`
  ADD CONSTRAINT `deuda_anteriores_ibfk_1` FOREIGN KEY (`id_cuentxcobrar`) REFERENCES `cuentas_p_cobrar` (`id_cuentxcobrar`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cuentxcobrar`) REFERENCES `cuentas_p_cobrar` (`id_cuentxcobrar`);

--
-- Filtros para la tabla `prod_pedidos`
--
ALTER TABLE `prod_pedidos`
  ADD CONSTRAINT `prod_pedidos_ibfk_1` FOREIGN KEY (`id_ped`) REFERENCES `pedidos` (`id_ped`);

--
-- Filtros para la tabla `saldos`
--
ALTER TABLE `saldos`
  ADD CONSTRAINT `saldos_ibfk_1` FOREIGN KEY (`id_cli`) REFERENCES `clientes` (`id_cli`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
