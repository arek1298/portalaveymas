-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-09-2024 a las 20:43:37
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ave2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` tinyint(1) DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_limite` date NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `persona` varchar(100) NOT NULL,
  `completada` tinyint(1) DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','completada') DEFAULT 'pendiente',
  `archivo_actualizado` varchar(255) DEFAULT NULL,
  `nota` text DEFAULT NULL,
  `id_asignador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id`, `descripcion`, `fecha_limite`, `archivo`, `persona`, `completada`, `fecha_creacion`, `estado`, `archivo_actualizado`, `nota`, `id_asignador`) VALUES
(1, 'WWE', '2024-09-25', 'CV Javier Guadalupe Martínez Flores.pdf', '2', 0, '2024-09-15 22:48:30', 'pendiente', NULL, NULL, NULL),
(2, 'PRUEBA 4', '2024-09-17', 'cv_javier_martinez_flores.pdf', '2', 0, '2024-09-15 22:51:26', 'pendiente', NULL, NULL, NULL),
(3, 'jjjjj', '2024-09-26', 'images.jpg', '1', 0, '2024-09-15 22:53:43', 'pendiente', NULL, NULL, NULL),
(4, 'zxzxxzxzx', '2024-09-20', 'images.jpg', '1', 0, '2024-09-15 22:56:23', 'pendiente', NULL, NULL, NULL),
(5, 'SUBIR ESTE DOCUMENTO', '2024-09-22', 'CV JAVIER EDITABLE2.pptx', '2', 0, '2024-09-16 00:16:30', 'pendiente', NULL, NULL, NULL),
(6, 'JAJAJA', '2024-09-16', 'cv_javier_martinez_flores.pdf', '2', 0, '2024-09-16 00:38:05', 'pendiente', NULL, NULL, NULL),
(7, 'dadasdasd', '2024-09-21', 'CURSO 1.xlsx', '1', 0, '2024-09-16 01:05:20', 'pendiente', NULL, NULL, NULL),
(8, 'fsfdfsf', '2024-09-21', 'retohash.docx', '1', 0, '2024-09-16 02:03:11', 'pendiente', NULL, NULL, NULL),
(9, 'nocheee', '2024-09-28', 'MANUAL_SCB.pdf', '2', 0, '2024-09-16 03:01:01', 'pendiente', NULL, NULL, 1),
(10, 'JKJKAJAKJAKJKAJA', '2024-09-26', 'Hola.docx', '1', 0, '2024-09-16 18:16:48', 'pendiente', NULL, NULL, 2),
(11, 'PRUEBA 4', '2024-09-26', 'Hola.docx', '2', 0, '2024-09-16 18:28:41', 'pendiente', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `correo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `area`, `usuario`, `password`, `correo`) VALUES
(1, 'Arek', 'IT', 'javiIT', '$2y$10$53jOuCrAvHffjumbZ1NPEe8/Y4QVOaDzCORLz..g9jXFXb1I7FFie', 'arekjavi@gmail.com'),
(2, 'Prueba', 'IT', 'prueba', '$2y$10$lObh3GderYpKyO18Nm8j/ux9tNUxFu21C3P9ci.q53KtY.H5vqpfm', 'javimtzflores3@gmail.com'),
(3, 'PRH', 'RH', 'Pruebar', '$2y$10$4HszIYNJzv9c2PVdkFcZ7Oa5OzSuHh.CVEXVkj90zYEQhvQf/6idu', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
