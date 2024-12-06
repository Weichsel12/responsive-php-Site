-- MySQL Script generated by MySQL Workbench
-- Tue Nov 19 18:02:15 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_immo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_immo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_immo` DEFAULT CHARACTER SET utf8 ;
USE `db_immo` ;

-- -----------------------------------------------------
-- Table `db_immo`.`immos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`immos` (
  `immo_id` INT NOT NULL AUTO_INCREMENT,
  `bezeichnung` VARCHAR(45) NULL,
  PRIMARY KEY (`immo_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  `address` VARCHAR(45) NULL,
  `postal_code` VARCHAR(45) NULL,
  `immos_immo_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_immos_idx` (`immos_immo_id` ASC) VISIBLE,
  CONSTRAINT `fk_users_immos`
    FOREIGN KEY (`immos_immo_id`)
    REFERENCES `db_immo`.`immos` (`immo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`Makler`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`Makler` (
  `idMakler` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(45) NULL,
  `Maklercol` VARCHAR(45) NULL,
  `immo_bereich` INT NOT NULL,
  PRIMARY KEY (`idMakler`),
  INDEX `fk_Makler_immos1_idx` (`immo_bereich` ASC) VISIBLE,
  CONSTRAINT `fk_Makler_immos1`
    FOREIGN KEY (`immo_bereich`)
    REFERENCES `db_immo`.`immos` (`immo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`admins` (
  `admin_id` INT NOT NULL AUTO_INCREMENT,
  `admin_name` VARCHAR(45) NULL,
  `admin_password` VARCHAR(45) NULL,
  `Makler` INT NULL,
  PRIMARY KEY (`admin_id`),
  INDEX `fk_admins_Makler1_idx` (`Makler` ASC) VISIBLE,
  CONSTRAINT `fk_admins_Makler1`
    FOREIGN KEY (`Makler`)
    REFERENCES `db_immo`.`Makler` (`idMakler`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`haus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`haus` (
  `idhaus` INT NOT NULL AUTO_INCREMENT,
  `bezeichnung` VARCHAR(45) NULL,
  `addresse` VARCHAR(45) NULL,
  `plz` VARCHAR(45) NULL,
  `datei` BLOB NULL,
  `immo_id` INT NOT NULL,
  PRIMARY KEY (`idhaus`, `immo_id`),
  INDEX `fk_haus_immos1_idx` (`immo_id` ASC) VISIBLE,
  CONSTRAINT `fk_haus_immos1`
    FOREIGN KEY (`immo_id`)
    REFERENCES `db_immo`.`immos` (`immo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`wohnung`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`wohnung` (
  `idwohnung` INT NOT NULL AUTO_INCREMENT,
  `bezeichnung` VARCHAR(45) NULL,
  `addresse` VARCHAR(45) NULL,
  `plz` VARCHAR(45) NULL,
  `datei` BLOB NULL,
  `immo_id` INT NOT NULL,
  PRIMARY KEY (`idwohnung`, `immo_id`),
  INDEX `fk_wohnung_immos1_idx` (`immo_id` ASC) VISIBLE,
  CONSTRAINT `fk_wohnung_immos1`
    FOREIGN KEY (`immo_id`)
    REFERENCES `db_immo`.`immos` (`immo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`grund`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`grund` (
  `idgrund` INT NOT NULL AUTO_INCREMENT,
  `bezeichnung` VARCHAR(45) NULL,
  `addresse` VARCHAR(45) NULL,
  `plz` VARCHAR(45) NULL,
  `immos_id` INT NOT NULL,
  PRIMARY KEY (`idgrund`, `immos_id`),
  INDEX `fk_grund_immos1_idx` (`immos_id` ASC) VISIBLE,
  CONSTRAINT `fk_grund_immos1`
    FOREIGN KEY (`immos_id`)
    REFERENCES `db_immo`.`immos` (`immo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`anmeldungen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`anmeldungen` (
  `anmelde_id` INT NOT NULL,
  `anmeldedatum` VARCHAR(45) NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`anmelde_id`, `users_id`),
  INDEX `fk_anmeldungen_users1_idx` (`users_id` ASC) VISIBLE,
  CONSTRAINT `fk_anmeldungen_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `db_immo`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_immo`.`verwalten`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_immo`.`verwalten` (
  `admins_admin_id` INT NOT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`admins_admin_id`, `users_id`),
  INDEX `fk_admins_has_users_users1_idx` (`users_id` ASC) VISIBLE,
  INDEX `fk_admins_has_users_admins1_idx` (`admins_admin_id` ASC) VISIBLE,
  CONSTRAINT `fk_admins_has_users_admins1`
    FOREIGN KEY (`admins_admin_id`)
    REFERENCES `db_immo`.`admins` (`admin_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_admins_has_users_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `db_immo`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
