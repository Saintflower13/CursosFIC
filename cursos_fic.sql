-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2021 at 08:24 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cursos_fic`
--
CREATE DATABASE IF NOT EXISTS `cursos_fic` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cursos_fic`;

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `ementa` text NOT NULL,
  `campus` tinyint(1) NOT NULL COMMENT '0 - IFSP-CJO | 1 - EaD',
  `professor_responsavel_id` int(11) NOT NULL,
  `tipo` tinyint(2) NOT NULL COMMENT '0 - Curso | 1 - Minicurso | 2 - Palestra',
  `cancelado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`id`, `titulo`, `descricao`, `ementa`, `campus`, `professor_responsavel_id`, `tipo`, `cancelado`) VALUES
(1, 'Teste', 'testes testes testest testest teste', 'testestes trsdjyh, yfkuyuygi iugohpihl jhgjyfdkycuyg;ih; iuk;i\nuhiu;iug;iuiyftfytdyrdtschgnhvn hgtdjydstr gfc htcj hgchtgct', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `docentes`
--

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `carga_horaria` int(11) NOT NULL DEFAULT 0,
  `cancelado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `docentes`
--

INSERT INTO `docentes` (`id`, `docente_id`, `turma_id`, `carga_horaria`, `cancelado`) VALUES
(1, 1, 1, 336, 1);

-- --------------------------------------------------------

--
-- Table structure for table `matriculas`
--

DROP TABLE IF EXISTS `matriculas`;
CREATE TABLE `matriculas` (
  `id` int(11) NOT NULL,
  `participante_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `registro_numero` varchar(50) NOT NULL,
  `registro_pagina` varchar(20) NOT NULL,
  `registro_livro` varchar(20) NOT NULL,
  `cancelado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `matriculas`
--

INSERT INTO `matriculas` (`id`, `participante_id`, `turma_id`, `status`, `registro_numero`, `registro_pagina`, `registro_livro`, `cancelado`) VALUES
(1, 2, 1, 0, '0', '0', '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `participantes`
--

DROP TABLE IF EXISTS `participantes`;
CREATE TABLE `participantes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo_documento` tinyint(2) NOT NULL COMMENT '0 - CPF | 1 - RG | 2 - CERTIDÃO DE NASCIMENTO',
  `numero_documento` varchar(60) NOT NULL,
  `email` varchar(255) NOT NULL,
  `excluido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `participantes`
--

INSERT INTO `participantes` (`id`, `nome`, `tipo_documento`, `numero_documento`, `email`, `excluido`) VALUES
(1, 'Emanuelle Santana', 0, '45496336899', 'manu714074@gmail.com', 1),
(2, 'EMANUELLE C S FLOR', 1, '54302037x', 'manu714074@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `professores`
--

DROP TABLE IF EXISTS `professores`;
CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `prontuario` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cargo` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 - Professor | 1 - Palestrante | 2 - Técnico | 3 - Monitor | 4 - Administrativo',
  `tipo` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 - EBTT | 1 - Substutivo | 2 - Voluntário',
  `excluido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `professores`
--

INSERT INTO `professores` (`id`, `nome`, `cpf`, `prontuario`, `email`, `cargo`, `tipo`, `excluido`) VALUES
(1, 'Emanuelle Santana', '45496336899', '15302444', 'manu714074@gmail.com', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `turmas`
--

DROP TABLE IF EXISTS `turmas`;
CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `carga_horaria` int(11) NOT NULL,
  `horario_inicial` time NOT NULL,
  `horario_final` time NOT NULL,
  `semestre` tinyint(1) NOT NULL DEFAULT 1,
  `ano` char(4) NOT NULL,
  `cancelado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `turmas`
--

INSERT INTO `turmas` (`id`, `curso_id`, `descricao`, `data_inicio`, `data_fim`, `carga_horaria`, `horario_inicial`, `horario_final`, `semestre`, `ano`, `cancelado`) VALUES
(1, 1, 'Turma 1', '2021-02-15', '2021-11-15', 336, '10:00:00', '16:00:00', 2, '2021', 0);

-- --------------------------------------------------------

--
-- Table structure for table `turmas_dias`
--

DROP TABLE IF EXISTS `turmas_dias`;
CREATE TABLE `turmas_dias` (
  `id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `domingo` tinyint(1) NOT NULL DEFAULT 0,
  `segunda` tinyint(1) NOT NULL DEFAULT 0,
  `terca` tinyint(1) NOT NULL DEFAULT 0,
  `quarta` tinyint(1) NOT NULL DEFAULT 0,
  `quinta` tinyint(1) NOT NULL DEFAULT 0,
  `sexta` tinyint(1) NOT NULL DEFAULT 0,
  `sabado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `turmas_dias`
--

INSERT INTO `turmas_dias` (`id`, `turma_id`, `domingo`, `segunda`, `terca`, `quarta`, `quinta`, `sexta`, `sabado`) VALUES
(1, 1, 0, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `excluido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`, `excluido`) VALUES
(1, 'MANU', 'c20ad4d76fe97759aa27a0c99bff6710', 0),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participantes`
--
ALTER TABLE `participantes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turmas_dias`
--
ALTER TABLE `turmas_dias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `participantes`
--
ALTER TABLE `participantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `turmas_dias`
--
ALTER TABLE `turmas_dias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
