USE imo_system;

DROP TABLE IF EXISTS utilizadores;

CREATE TABLE utilizadores (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(14) UNIQUE,
    password VARCHAR(255) NOT NULL,
    morada VARCHAR(255) NOT NULL,
    dt_nascimento DATE NOT NULL,
    pronomes VARCHAR(20)
);
