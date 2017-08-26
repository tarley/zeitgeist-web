--
-- Database: `ZeitGeistDB`
--

CREATE DATABASE ZeitGeistDB;

-- --------------------------------------------------------

--
-- Table structure for table `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `cod_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`cod_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for table `tb_aluno`
--

CREATE TABLE `tb_aluno` (
  `cod_aluno` int(11) NOT NULL auto_increment PRIMARY KEY,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `sexo` char(1) NOT NULL,
  `data_cadastro` DATETIME NOT NULL,
  `data_nascimento` DATETIME NOT NULL,
  `profissao` varchar(50) NULL,
  `enfermidades` varchar(255) NULL,
  `situacao` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;