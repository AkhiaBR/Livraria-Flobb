-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 19/05/2025 às 22h07min
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `autor`
--

INSERT INTO `autor` (`codigo`, `nome`, `pais`) VALUES
(1, 'Hajime Isayama', 'Japão'),
(2, 'George Orwell', 'Reino Unido');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`codigo`, `nome`) VALUES
(1, 'Dark Fantasy'),
(2, 'Ficção Científica');

-- --------------------------------------------------------

--
-- Estrutura da tabela `editora`
--

CREATE TABLE IF NOT EXISTS `editora` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `editora`
--

INSERT INTO `editora` (`codigo`, `nome`) VALUES
(1, 'Kodansha Comics'),
(2, 'Companhia das Letras');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`codigo`, `titulo`, `numero_paginas`, `ano`, `codigo_autor`, `codigo_categoria`, `codigo_editora`, `resenha`, `preco`, `foto_capa`, `foto_contracapa`) VALUES
(1, 'Attack on Titan Volume 01', 208, 2012, 1, 1, 1, 'Em um mundo devastado por criaturas gigantes conhecidas como Titãs, a humanidade vive confinada dentro de enormes muralhas há mais de 100 anos. O protagonista, Eren Yeager, sonha em ver o mundo além dessas muralhas. No entanto, tudo muda quando um gigantesco Titã — muito maior do que qualquer outro — aparece do nada e destrói parte da muralha externa, colocando a cidade em caos. Eren, então, jura eliminar todos os Titãs e começa sua jornada movido por vingança.', '90.00', '2ddc45a2ac3830e77e007d70814c2e49.jpg', '52063831a86d72f6caeb26af84ae1b5a.jpg'),
(2, '1984', 416, 2009, 2, 2, 2, 'Quando foi publicada em 1949, essa assustadora distopia datada de forma arbitrária num futuro perigosamente próximo logo experimentaria um imenso sucesso de público. Seus principais ingredientes - um homem sozinho desafiando uma tremenda ditadura; sexo furtivo e libertador; horrores letais - atraíram leitores de todas as idades, à esquerda e à direita do espectro político, com maior ou menor grau de instrução. À parte isso, a escrita translúcida de George Orwell, os personagens fortes, traçados a carvão por um vigoroso desenhista de personalidades, a trama seca e crua e o tom de sátira sombria garantiram a entrada precoce de 1984 no restrito panteão dos grandes clássicos modernos.', '39.00', '55b0c765bbc2d7f0fcda0c60a1fa70cc.jpg', '59c484b83757b6e98066ddc343abddee.jpg');

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
