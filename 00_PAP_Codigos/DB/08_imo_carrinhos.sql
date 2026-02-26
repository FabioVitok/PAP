USE imo_system;

DROP TABLE IF EXISTS carrinhos;

CREATE TABLE carrinhos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    custo_total DECIMAL(10, 2) NOT NULL, -- fazer ser uma soma
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);