-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tempo de Geração: 05/06/2025 às 19h41min
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `autor`
--

INSERT INTO `autor` (`codigo`, `nome`, `pais`) VALUES
(1, 'Sui Ishida', 'Japão'),
(2, 'Hajime Isayama', 'Japão'),
(3, 'Tatsuki Fujimoto', 'Japão');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`codigo`, `nome`) VALUES
(1, 'Dark Fantasy'),
(2, 'Comedy horror');

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
(1, 'Panini'),
(2, 'Kodansha Comics');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `livro`
--

INSERT INTO `livro` (`codigo`, `titulo`, `numero_paginas`, `ano`, `codigo_autor`, `codigo_categoria`, `codigo_editora`, `resenha`, `preco`, `foto_capa`, `foto_contracapa`) VALUES
(1, 'Tokyo Ghoul Vol. 1', 224, 2011, 1, 1, 1, 'Ken Kaneki é um estudante universitário comum até que um encontro violento o transforma no primeiro híbrido meio-humano meio-ghoul. Preso entre dois mundos, ele deve sobreviver às guerras territoriais de Ghoul, aprender mais sobre a sociedade de Ghoul e dominar seus novos poderes.', '75.50', 'b8e954a6575e6ad0987d9139a40e3dc8.jpg', 'fa8c046a4fc0a3dcc2ed5292ccceb1c0.png'),
(2, 'Attack on Titan Vol. 1', 208, 2010, 2, 1, 2, 'Nesta história de ficção científica pós-apocalíptica, a humanidade foi devastada pelos bizarros humanóides gigantes conhecidos como Titãs. Pouco se sabe sobre de onde eles vieram ou por que eles estão empenhados em consumir a humanidade. Aparentemente pouco inteligentes, eles vagaram pelo mundo durante anos, matando todos que vêem. Durante o século passado, o que resta do homem escondeu-se numa cidade gigante de três muralhas. As pessoas acreditam que suas paredes de 50 metros de altura irão protegê-los dos Titãs, mas o súbito aparecimento de um imenso Titã está prestes a mudar tudo.', '40.80', 'fd84743faac4af2dd0a99a244ac47602.jpg', 'e2e0293fdbf7e463062f0a50692e3fbb.jpg'),
(3, 'Tokyo Ghoul: re Vol. 1', 216, 2018, 1, 1, 1, 'Os ghouls se misturam à multidão e devoram a carne das pessoas. Aparentam ser humanos, mas são criaturas diferentes.O CCG, que estuda e extermina os ghouls, estabeleceu recentemente um grupo experimental para cumprir uma certa tarefa. Seu nome é “Quinx”. O que o investigador de primeira classe Haise Sasaki enfrentará em Tokyo com essas “pessoas anormais”?', '21.80', '8b73bfc234844f9e38cec21f6686b6b7.jpg', '4670647caa72ea2a63e0628886e279dd.jpg'),
(4, 'Chainsaw Man Vol. 12', 192, 2023, 3, 2, 1, 'Asa Mitaka é uma jovem solitária que é incapaz de se adaptar plenamente à sua rotina escolar, entretanto, sua vida mudará drasticamente após o encontro com certo demônio!! Qual o objetivo dessa criatura que está prestes a se tornar uma nova calamidade para o mundo?! Por fim, onde está o Chainsaw Man enquanto tudo isso acontece?! Aqui começa a chocante segunda parte dessa história de uma juventude explosiva coberta de sangue e tripas!!', '36.90', '2a3a4202a834faa3844e54d21b136a3d.jpg', '7776e5a36c946c241739a160ce111c01.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` int(5) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `senha` varchar(20) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `login`, `senha`) VALUES
(1, 'admin', 'admin');

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
