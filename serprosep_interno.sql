-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2025 a las 03:50:26
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
-- Base de datos: `serprosep_interno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `catalogo`
--

CREATE TABLE `catalogo` (
  `id` int(10) NOT NULL,
  `descripcion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(10) NOT NULL,
  `no_empleado` varchar(50) DEFAULT NULL,
  `id_unidad_negocio` int(10) DEFAULT NULL,
  `id_regional` int(10) DEFAULT NULL,
  `id_zona` int(10) DEFAULT NULL,
  `id_empresa` int(10) DEFAULT NULL,
  `id_servicio` int(10) DEFAULT NULL,
  `curp` varchar(20) DEFAULT NULL,
  `rfc` varchar(15) DEFAULT NULL,
  `nss` varchar(12) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `paterno` varchar(255) DEFAULT NULL,
  `materno` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `id_turno` int(2) DEFAULT NULL,
  `id_puesto` int(10) DEFAULT NULL,
  `sueldo` decimal(10,2) DEFAULT NULL,
  `id_periocidad` int(10) DEFAULT NULL,
  `cuenta` varchar(10) DEFAULT NULL,
  `clave_interbancaria` varchar(20) DEFAULT NULL,
  `id_banco` int(10) DEFAULT NULL,
  `estatus` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `no_empleado`, `id_unidad_negocio`, `id_regional`, `id_zona`, `id_empresa`, `id_servicio`, `curp`, `rfc`, `nss`, `fecha_ingreso`, `paterno`, `materno`, `nombre`, `id_turno`, `id_puesto`, `sueldo`, `id_periocidad`, `cuenta`, `clave_interbancaria`, `id_banco`, `estatus`) VALUES
(1, '230473', 0, 0, 0, 0, 0, 'GOJM850101HDFRRL03', 'GOJM850101ABC', '12345678901', '2025-06-02', 'González', 'Martínez', 'Juan', 0, 0, 12500.00, 0, '0001234567', '123456789012345678', 0, 1),
(3, '301006', 0, 0, 0, 0, 0, 'MAFE990706HMCDRLR05', 'MAFE9900706DU3', '12345678901', '2025-06-02', 'Madrigal', 'Flores', 'Erick', 0, 0, 12500.00, 0, '0001234567', '123456789012345678', 0, 1),
(4, '301006', 0, 0, 0, 0, 0, 'GOJM850101HDFRRL03', 'GOJM850101ABC', '12345678901', '2025-06-02', 'Madrigal', 'Flores', 'Nestor', 0, 0, 12500.00, 0, '0001234567', '123456789012345678', 0, 1),
(5, '301006', 0, 0, 0, 0, 0, 'GOJM850101HDFRRL03', 'GOJM850101ABC', '12345678901', '2025-06-02', 'Madrigal', 'Flores', 'Angel', 0, 0, 12500.00, 0, '0001234567', '123456789012345678', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(10) NOT NULL,
  `id_empleado` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs_usuarios`
--

CREATE TABLE `logs_usuarios` (
  `id` int(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `fecha_movimiento` datetime NOT NULL,
  `id_movimiento` int(10) NOT NULL,
  `id_logs` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `ruta` varchar(255) NOT NULL,
  `id_rol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multicatalogo`
--

CREATE TABLE `multicatalogo` (
  `id` int(10) NOT NULL,
  `descripcion` text NOT NULL,
  `valor` text NOT NULL,
  `id_catalogo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `name_user` varchar(50) NOT NULL,
  `paterno` varchar(255) NOT NULL,
  `materno` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `estatus` int(10) NOT NULL,
  `id_rol` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `name_user`, `paterno`, `materno`, `password`, `estatus`, `id_rol`) VALUES
(1, 'Carlos', 'carlos@example.com', 'carlosr', 'Ramírez', 'Gómez', '$argon2id$v=19$m=65536,t=4,p=1$RnB0T1hBVFhJLjBiWk9UYw$wIEwi+0amxbnxZs4zW1ilmHNRyfx9BWqpk4/qnesfAY', 1, 1),
(4, 'Ellioth', 'Ellioth@example.com', 'ElliothM', 'Madrigal', 'Gonzalez', '$argon2id$v=19$m=65536,t=4,p=1$ZzhRclBTUnZaY0ZkWTFrdQ$mAhXLEI+XAMHNS/wCWJqQYFIa/tbXPpo4/cSBlTYxMk', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `logs_usuarios`
--
ALTER TABLE `logs_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `multicatalogo`
--
ALTER TABLE `multicatalogo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `catalogo`
--
ALTER TABLE `catalogo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs_usuarios`
--
ALTER TABLE `logs_usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `multicatalogo`
--
ALTER TABLE `multicatalogo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
