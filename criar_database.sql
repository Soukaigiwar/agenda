DROP DATABASE IF EXISTS `estudos`;

CREATE DATABASE IF NOT EXISTS `estudos`;

USE `estudos`;

CREATE TABLE `telefones` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(50) NULL DEFAULT NULL,
    `telefone` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP()
    `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
    `deleted_at` DATETIME NULL DEFAULT NULL
)

CREATE TABLE `clientes` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(50) NULL DEFAULT NULL,
    `apelido` VARCHAR (50) NULL DEFAULT NULL,
    `email` VARCHAR(100) NULL DEFAULT NULL,
    `password` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
    `updated_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP(),
    `deleted_at` DATETIME NULL DEFAULT NULL
)

INSERT INTO `clientes` (nome, apelido, email, password)
  VALUES ('admin', '', 'admin@agenda', '1234');
