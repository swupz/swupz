-- MySQL Script generated by MySQL Workbench
-- Wed May  5 13:04:03 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema kinofilm
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema kinofilm
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kinofilm` DEFAULT CHARACTER SET utf8 COLLATE utf8_danish_ci ;
USE `kinofilm` ;

-- -----------------------------------------------------
-- Table `kinofilm`.`bruker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kinofilm`.`bruker` (
  `bnv` VARCHAR(20) NOT NULL,
  `fnv` VARCHAR(45) NOT NULL,
  `env` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `passord` VARCHAR(128) NOT NULL,
  `admin` TINYINT NULL,
  PRIMARY KEY (`bnv`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kinofilm`.`sal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kinofilm`.`sal` (
  `salnv` VARCHAR(45) NOT NULL,
  `seteantall` INT NOT NULL,
  `pris` INT NOT NULL,
  PRIMARY KEY (`salnv`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kinofilm`.`regissor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kinofilm`.`regissor` (
  `regissor_id` INT NOT NULL AUTO_INCREMENT,
  `regfnv` VARCHAR(45) NOT NULL,
  `regenv` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`regissor_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kinofilm`.`film`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kinofilm`.`film` (
  `film_id` INT NOT NULL AUTO_INCREMENT,
  `tittel` VARCHAR(45) NOT NULL,
  `utgivelsesar` INT NOT NULL,
  `beskrivelse` VARCHAR(200) NULL,
  `ogsprak` VARCHAR(45) NULL,
  `sjanger` VARCHAR(45) NULL,
  `regissor_id` INT NULL,
  PRIMARY KEY (`film_id`),
  INDEX `FK_regissor_film_idx` (`regissor_id` ASC) VISIBLE,
  CONSTRAINT `FK_regissor_film`
    FOREIGN KEY (`regissor_id`)
    REFERENCES `kinofilm`.`regissor` (`regissor_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kinofilm`.`forestilling`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kinofilm`.`forestilling` (
  `salnv` VARCHAR(45) NOT NULL,
  `tidspunkt` TIMESTAMP NOT NULL,
  `film_id` INT NOT NULL,
  `fstilling_id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`fstilling_id`),
  INDEX `FK_film_forestilling_idx` (`film_id` ASC) VISIBLE,
  CONSTRAINT `FK_sal_forestilling`
    FOREIGN KEY (`salnv`)
    REFERENCES `kinofilm`.`sal` (`salnv`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_film_forestilling`
    FOREIGN KEY (`film_id`)
    REFERENCES `kinofilm`.`film` (`film_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kinofilm`.`bilde`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kinofilm`.`bilde` (
  `bilde_id` INT NOT NULL AUTO_INCREMENT,
  `bilde_kobling` VARCHAR(45) NOT NULL,
  `film_id` INT NOT NULL,
  PRIMARY KEY (`bilde_id`),
  INDEX `FK_film_bilde_idx` (`film_id` ASC) VISIBLE,
  CONSTRAINT `FK_film_bilde`
    FOREIGN KEY (`film_id`)
    REFERENCES `kinofilm`.`film` (`film_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `kinofilm`.`billett`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kinofilm`.`billett` (
  `billett_id` INT NOT NULL AUTO_INCREMENT,
  `bnv` VARCHAR(20) NOT NULL,
  `fstilling_id` INT NOT NULL,
  `seter_kjopt` INT NOT NULL,
  PRIMARY KEY (`billett_id`),
  INDEX `FK_forestilling_billett_idx` (`fstilling_id` ASC) VISIBLE,
  INDEX `FK_bruker_billett_idx` (`bnv` ASC) VISIBLE,
  CONSTRAINT `FK_bruker_billett`
    FOREIGN KEY (`bnv`)
    REFERENCES `kinofilm`.`bruker` (`bnv`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_forestilling_billett`
    FOREIGN KEY (`fstilling_id`)
    REFERENCES `kinofilm`.`forestilling` (`fstilling_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
