-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema bd_zeitgeist
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `bd_zeitgeist` ;

-- -----------------------------------------------------
-- Schema bd_zeitgeist
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bd_zeitgeist` DEFAULT CHARACTER SET latin1 ;
USE `bd_zeitgeist` ;

-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_situacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_situacao` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_situacao` (
  `id_situacao` TINYINT(4) NOT NULL,
  `desc_situacao` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id_situacao`),
  UNIQUE INDEX `desc_situacao_UNIQUE` (`desc_situacao` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_perfil_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_perfil_usuario` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_perfil_usuario` (
  `id_perfil_usuario` TINYINT(4) NOT NULL,
  `nome_perfil` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_perfil_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_usuario` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_usuario` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `nom_usuario` VARCHAR(50) NOT NULL,
  `email_usuario` VARCHAR(50) NOT NULL,
  `senha_usuario` VARCHAR(255) NOT NULL,
  `id_perfil_usuario` TINYINT(4) NOT NULL DEFAULT 2,
  PRIMARY KEY (`id_usuario`),
  UNIQUE INDEX `email_usuario_UNIQUE` (`email_usuario` ASC),
  INDEX `fk_tb_usuario_tb_perfil_usuario1_idx` (`id_perfil_usuario` ASC),
  CONSTRAINT `fk_tb_usuario_tb_perfil_usuario1`
    FOREIGN KEY (`id_perfil_usuario`)
    REFERENCES `bd_zeitgeist`.`tb_perfil_usuario` (`id_perfil_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_jornal`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_jornal` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_jornal` (
  `id_jornal` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NOT NULL,
  `id_situacao` TINYINT(4) NOT NULL,
  `num_edicao_jornal` INT NOT NULL,
  `nom_titulo_jornal` VARCHAR(255) NOT NULL,
  `dta_publicacao_jornal` DATE NULL DEFAULT NULL,
  `dta_ultima_atualizacao_jornal` DATE NOT NULL,
  PRIMARY KEY (`id_jornal`),
  INDEX `FK_situacao_jornal` (`id_situacao` ASC),
  INDEX `FK_usuario_jornal` (`id_usuario` ASC),
  UNIQUE INDEX `num_edicao_jornal_UNIQUE` (`num_edicao_jornal` ASC),
  CONSTRAINT `FK_situacao_jornal`
    FOREIGN KEY (`id_situacao`)
    REFERENCES `bd_zeitgeist`.`tb_situacao` (`id_situacao`),
  CONSTRAINT `FK_usuario_jornal`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `bd_zeitgeist`.`tb_usuario` (`id_usuario`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_template`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_template` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_template` (
  `id_template` TINYINT(4) NOT NULL,
  `desc_template` VARCHAR(50) NOT NULL,
  UNIQUE INDEX `desc_template_UNIQUE` (`desc_template` ASC),
  PRIMARY KEY (`id_template`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_pagina`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_pagina` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_pagina` (
  `id_pagina` INT NOT NULL AUTO_INCREMENT,
  `id_jornal` INT NOT NULL,
  `id_template` TINYINT(4) NOT NULL,
  `num_pagina` TINYINT(4) NOT NULL,
  `nom_pagina` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_pagina`),
  INDEX `FK_paginas_jornal` (`id_jornal` ASC),
  INDEX `FK_template_pagina` (`id_template` ASC),
  UNIQUE INDEX `num_pagina_UNIQUE` (`num_pagina` ASC),
  CONSTRAINT `FK_paginas_jornal`
    FOREIGN KEY (`id_jornal`)
    REFERENCES `bd_zeitgeist`.`tb_jornal` (`id_jornal`),
  CONSTRAINT `FK_template_pagina`
    FOREIGN KEY (`id_template`)
    REFERENCES `bd_zeitgeist`.`tb_template` (`id_template`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_tipo_template_dado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_tipo_template_dado` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_tipo_template_dado` (
  `id_tipo_template_dado` TINYINT(4) NOT NULL,
  `desc_tipo_template_dado` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id_tipo_template_dado`),
  UNIQUE INDEX `desc_tipo_template_dado_UNIQUE` (`desc_tipo_template_dado` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_template_dado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_template_dado` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_template_dado` (
  `id_template_dado` INT NOT NULL AUTO_INCREMENT,
  `id_template` TINYINT(4) NOT NULL,
  `id_tipo_template_dado` TINYINT(4) NOT NULL,
  `chave_template_dado` VARCHAR(50) NOT NULL,
  `desc_template_dado` VARCHAR(255) NOT NULL,
  `ordem_dados` TINYINT(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_template_dado`),
  INDEX `FK_template_template_dado` (`id_template` ASC),
  INDEX `FK_tipo_template_dado` (`id_tipo_template_dado` ASC),
  UNIQUE INDEX `template_dado_uk` (`id_template` ASC, `chave_template_dado` ASC),
  CONSTRAINT `FK_template_template_dado`
    FOREIGN KEY (`id_template`)
    REFERENCES `bd_zeitgeist`.`tb_template` (`id_template`),
  CONSTRAINT `FK_tipo_template_dado`
    FOREIGN KEY (`id_tipo_template_dado`)
    REFERENCES `bd_zeitgeist`.`tb_tipo_template_dado` (`id_tipo_template_dado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_pagina_dado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_pagina_dado` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_pagina_dado` (
  `id_pagina_dado` INT NOT NULL AUTO_INCREMENT,
  `id_pagina` INT NOT NULL,
  `id_template_dado` INT NOT NULL,
  PRIMARY KEY (`id_pagina_dado`),
  INDEX `FK_pagina_pagina_dado` (`id_pagina` ASC),
  INDEX `FK_pagina_template` (`id_template_dado` ASC),
  UNIQUE INDEX `id_pagina_UNIQUE` (`id_pagina` ASC, `id_template_dado` ASC),
  CONSTRAINT `FK_pagina_pagina_dado`
    FOREIGN KEY (`id_pagina`)
    REFERENCES `bd_zeitgeist`.`tb_pagina` (`id_pagina`),
  CONSTRAINT `FK_pagina_template`
    FOREIGN KEY (`id_template_dado`)
    REFERENCES `bd_zeitgeist`.`tb_template_dado` (`id_template_dado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_pagina_imagem`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_pagina_imagem` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_pagina_imagem` (
  `id_pagina_dado` INT NOT NULL,
  `valor_pagina_imagem` LONGBLOB NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  INDEX `FK_imagem_da_pagina` (`id_pagina_dado` ASC),
  PRIMARY KEY (`id_pagina_dado`),
  CONSTRAINT `FK_imagem_da_pagina`
    FOREIGN KEY (`id_pagina_dado`)
    REFERENCES `bd_zeitgeist`.`tb_pagina_dado` (`id_pagina_dado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_pagina_string`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_pagina_string` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_pagina_string` (
  `id_pagina_dado` INT NOT NULL,
  `valor_pagina_string` VARCHAR(255) NOT NULL,
  INDEX `FK_string_da_pagina` (`id_pagina_dado` ASC),
  PRIMARY KEY (`id_pagina_dado`),
  CONSTRAINT `FK_string_da_pagina`
    FOREIGN KEY (`id_pagina_dado`)
    REFERENCES `bd_zeitgeist`.`tb_pagina_dado` (`id_pagina_dado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `bd_zeitgeist`.`tb_pagina_texto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `bd_zeitgeist`.`tb_pagina_texto` ;

CREATE TABLE IF NOT EXISTS `bd_zeitgeist`.`tb_pagina_texto` (
  `id_pagina_dado` INT NOT NULL,
  `valor_pagina_texto` TEXT NOT NULL,
  INDEX `FK_texto_da_pagina` (`id_pagina_dado` ASC),
  PRIMARY KEY (`id_pagina_dado`),
  CONSTRAINT `FK_texto_da_pagina`
    FOREIGN KEY (`id_pagina_dado`)
    REFERENCES `bd_zeitgeist`.`tb_pagina_dado` (`id_pagina_dado`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `bd_zeitgeist`.`tb_situacao`
-- -----------------------------------------------------
START TRANSACTION;
USE `bd_zeitgeist`;
INSERT INTO `bd_zeitgeist`.`tb_situacao` (`id_situacao`, `desc_situacao`) VALUES (1, 'EM ANÁLISE');
INSERT INTO `bd_zeitgeist`.`tb_situacao` (`id_situacao`, `desc_situacao`) VALUES (2, 'PUBLICADO');

COMMIT;


-- -----------------------------------------------------
-- Data for table `bd_zeitgeist`.`tb_perfil_usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `bd_zeitgeist`;
INSERT INTO `bd_zeitgeist`.`tb_perfil_usuario` (`id_perfil_usuario`, `nome_perfil`) VALUES (1, 'Administrador');
INSERT INTO `bd_zeitgeist`.`tb_perfil_usuario` (`id_perfil_usuario`, `nome_perfil`) VALUES (2, 'Editor');

COMMIT;


-- -----------------------------------------------------
-- Data for table `bd_zeitgeist`.`tb_usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `bd_zeitgeist`;
INSERT INTO `bd_zeitgeist`.`tb_usuario` (`id_usuario`, `nom_usuario`, `email_usuario`, `senha_usuario`, `id_perfil_usuario`) VALUES (DEFAULT, 'Homero Nunes', 'homero@newtonpaiva.br', sha1('123456'), DEFAULT);

COMMIT;

-- -----------------------------------------------------
-- Data for table `bd_zeitgeist`.`tb_tipo_template_dado`
-- -----------------------------------------------------
START TRANSACTION;
USE `bd_zeitgeist`;
INSERT INTO `bd_zeitgeist`.`tb_tipo_template_dado` (`id_tipo_template_dado`, `desc_tipo_template_dado`) VALUES (1, 'string');
INSERT INTO `bd_zeitgeist`.`tb_tipo_template_dado` (`id_tipo_template_dado`, `desc_tipo_template_dado`) VALUES (2, 'texto');
INSERT INTO `bd_zeitgeist`.`tb_tipo_template_dado` (`id_tipo_template_dado`, `desc_tipo_template_dado`) VALUES (3, 'imagem');

COMMIT;

