USE imo_system;

DROP TABLE IF EXISTS pedido_produtos;

CREATE TABLE pedido_produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT(11) UNSIGNED NOT NULL,
    id_produto INT(11) UNSIGNED NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);