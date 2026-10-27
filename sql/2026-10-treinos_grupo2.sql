-- Treino opcional do Grupo 2 (um por treino do dia). O Grupo 1 continua na tabela `treinos`.
-- Rodar no phpMyAdmin ANTES de publicar o código que usa esta tabela.
CREATE TABLE IF NOT EXISTS `treinos_grupo2` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_treino` INT NOT NULL,
  `nome_foto` VARCHAR(255) DEFAULT NULL,
  `treino` TEXT,
  `serie_controle` VARCHAR(255) DEFAULT NULL,
  `tipo` VARCHAR(50) DEFAULT NULL,
  `total` INT NOT NULL DEFAULT 0,
  `A1` INT NOT NULL DEFAULT 0,
  `A2` INT NOT NULL DEFAULT 0,
  `A3` INT NOT NULL DEFAULT 0,
  `AN` INT NOT NULL DEFAULT 0,
  `FO` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_treino` (`id_treino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
