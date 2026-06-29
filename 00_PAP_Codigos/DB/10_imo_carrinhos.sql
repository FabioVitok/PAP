USE imo_system;

DROP TABLE IF EXISTS carrinhos;

CREATE TABLE carrinhos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    custo_total DECIMAL(10, 2) NOT NULL, -- fazer ser uma soma
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id)
);

INSERT INTO carrinhos(id_utilizador, custo_total) VALUES
(1, 0.00),
(2, 0.00),
(3, 0.00);
(4, 0.00),
(5, 0.00),
(6, 0.00),
(7, 0.00),
(8, 0.00),
(9, 0.00),
(10, 0.00),
(11, 0.00),
(12, 0.00),
(13, 0.00),
(14, 0.00),
(15, 0.00),
(16, 0.00),
(17, 0.00),
(18, 0.00),
(19, 0.00);

INSERT INTO carrinhos(id_utilizador, custo_total) VALUES
(3, 0.00),
(4, 0.00),
(5, 0.00),
(7, 0.00),
(8, 0.00);