-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 15/05/2024 às 20:24
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `crud_pessoas`
--
CREATE DATABASE IF NOT EXISTS `crud_pessoas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `crud_pessoas`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `desenvolvedores`
--

CREATE TABLE `desenvolvedores` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `idade` int(11) NOT NULL,
  `hobby` varchar(100) NOT NULL,
  `nivel_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `desenvolvedores`
--

INSERT INTO `desenvolvedores` (`id`, `nome`, `sexo`, `data_nascimento`, `idade`, `hobby`, `nivel_id`) VALUES
(1, 'Ryan', 'Masculino', '2004-02-19', 20, 'Programar', 1),
(2, 'Alex', 'Masculino', '1988-01-05', 36, 'Ler', 4),
(3, 'Julia', 'Feminino', '1997-05-05', 27, 'Correr', 2),
(4, 'Douglas', 'Masculino', '1997-02-08', 27, 'Academia', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivel`
--

CREATE TABLE `nivel` (
  `id` int(11) NOT NULL,
  `nivel` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `nivel`
--

INSERT INTO `nivel` (`id`, `nivel`) VALUES
(1, 'Junior'),
(2, 'Treeine'),
(3, 'Pleno'),
(4, 'Senior');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `desenvolvedores`
--
ALTER TABLE `desenvolvedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk1` (`nivel_id`);

--
-- Índices de tabela `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `desenvolvedores`
--
ALTER TABLE `desenvolvedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `desenvolvedores`
--
ALTER TABLE `desenvolvedores`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`nivel_id`) REFERENCES `nivel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
