-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/09/2025 às 10:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `brincarlivre` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `brincarlivre`;

-- Estrutura para tabela `usuario`
CREATE TABLE `usuario` (
  `id_usuario` int(10) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `rg` varchar(10) NOT NULL,
  `geolocalizacaoAtiva` tinyint(1) DEFAULT 1,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `raioBusca` float DEFAULT 3,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estrutura para tabela `evento`
CREATE TABLE `evento` (
  `id_evento` int(10) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `horario` time NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `local` varchar(150) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Estrutura para tabela `participacao`
CREATE TABLE `participacao` (
  `id_participacao` int(10) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) NOT NULL,
  `id_evento` int(10) NOT NULL,
  `recebe_aviso` tinyint(1) DEFAULT 1,
  `status` varchar(20) DEFAULT 'pendente',
  PRIMARY KEY (`id_participacao`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_evento` (`id_evento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Restrições para tabelas
ALTER TABLE `evento`
  ADD CONSTRAINT `evento_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

ALTER TABLE `participacao`
  ADD CONSTRAINT `participacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `participacao_ibfk_2` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`);

-- Inserir usuário admin padrão
INSERT INTO `usuario` (`nome`, `email`, `senha`, `endereco`, `cpf`, `rg`, `geolocalizacaoAtiva`) VALUES
('Administrador', 'admin@brincarlivre.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rua Principal, 123', '12345678901', '123456789', 1);

COMMIT;