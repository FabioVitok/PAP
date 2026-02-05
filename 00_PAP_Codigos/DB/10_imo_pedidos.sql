USE imo_system;

DROP TABLE IF EXISTS pedidos;

CREATE TABLE pedidos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_carrinho INT(11) UNSIGNED NOT NULL,
    FOREIGN KEY (id_carrinho) REFERENCES carrinhos(id)
);


