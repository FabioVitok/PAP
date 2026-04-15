USE imo_system;

DROP TABLE IF EXISTS pedidos;

CREATE TABLE pedidos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_carrinho INT(11) UNSIGNED NOT NULL UNIQUE,
    FOREIGN KEY (id_carrinho) REFERENCES carrinhos(id)
);

INSERT INTO pedidos(id_carrinho) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10);

