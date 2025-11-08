CREATE DATABASE IF NOT EXISTS bd_mundo
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE bd_mundo;

-- tabela paises
CREATE TABLE IF NOT EXISTS paises (
  id_pais BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome_oficial VARCHAR(200) NOT NULL,
  continente VARCHAR(50) NOT NULL,
  populacao BIGINT UNSIGNED NOT NULL DEFAULT 0,
  idioma VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_pais),
  UNIQUE KEY uk_nome (nome_oficial)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- tabela cidades
CREATE TABLE IF NOT EXISTS cidades (
  id_cidade BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(200) NOT NULL,
  populacao BIGINT UNSIGNED NOT NULL DEFAULT 0,
  id_pais BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id_cidade),
  KEY fk_cidade_pais (id_pais),
  CONSTRAINT fk_cidade_pais FOREIGN KEY (id_pais) REFERENCES paises(id_pais)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
