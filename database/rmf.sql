
-- Base de datos para probar el framework RMF
-- tan solo contiene la tabla de usuarios

-- AUTOR: Robert Sallent
-- Curso de aplicaciones web
-- Última revisión: 20/01/2022

DROP DATABASE IF EXISTS rmf_test;

CREATE DATABASE IF NOT EXISTS rmf_test 
	DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE rmf_test;


CREATE TABLE usuarios (
  id INT(11) NOT NULL PRIMARY KEY,
  user VARCHAR(32) NOT NULL UNIQUE KEY,
  password VARCHAR(32) NOT NULL,
  nombre VARCHAR(128) NOT NULL,
  privilegio INT(11) NOT NULL DEFAULT 0,
  admin INT(11) NOT NULL DEFAULT 0 COMMENT '0 no admin, 1 admin', 
  email VARCHAR(128) NOT NULL UNIQUE KEY,
  imagen VARCHAR(512) NULL DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- creación de varios usuarios, con password 1234 por defecto
INSERT INTO usuarios (id, user, password, nombre, privilegio, admin, email, imagen) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Administrador', 1000, 1, 'admin@rmf.cat', 'images/users/admin.png'),
(2, 'supervisor', '81dc9bdb52d04dc20036dbd8313ed055', 'Supervisor', 500, 0, 'svsr@rmf.cat', 'images/users/supervisor.png'),
(3, 'user', '81dc9bdb52d04dc20036dbd8313ed055', 'User', 0, 0, 'user@rmf.cat', NULL);

