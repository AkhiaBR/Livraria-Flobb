-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 12/05/2025 às 19h42min
-- Versão do Servidor: 5.5.20
-- Versão do PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `livraria`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `autor`
--

CREATE TABLE IF NOT EXISTS `autor` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `pais` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `editora`
--

CREATE TABLE IF NOT EXISTS `editora` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `livro`
--

CREATE TABLE IF NOT EXISTS `livro` (
  `codigo` int(20) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(150) NOT NULL,
  `numero_paginas` int(6) NOT NULL,
  `ano` int(4) NOT NULL,
  `codigo_autor` int(5) NOT NULL,
  `codigo_categoria` int(5) NOT NULL,
  `codigo_editora` int(5) NOT NULL,
  `resenha` text NOT NULL,
  `preco` decimal(6,2) NOT NULL,
  `foto_capa` varchar(150) NOT NULL,
  `foto_contracapa` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `codigo_autor` (`codigo_autor`),
  KEY `codigo_categoria` (`codigo_categoria`),
  KEY `codigo_editora` (`codigo_editora`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `livro`
--
ALTER TABLE `livro`
  ADD CONSTRAINT `livro_ibfk_3` FOREIGN KEY (`codigo_editora`) REFERENCES `editora` (`codigo`),
  ADD CONSTRAINT `livro_ibfk_1` FOREIGN KEY (`codigo_autor`) REFERENCES `autor` (`codigo`),
  ADD CONSTRAINT `livro_ibfk_2` FOREIGN KEY (`codigo_categoria`) REFERENCES `categoria` (`codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
