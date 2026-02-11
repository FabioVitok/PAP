USE imo_system;

DROP TABLE IF EXISTS entregas;

CREATE TABLE entregas (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT(11) UNSIGNED NOT NULL UNIQUE,
    morada_entrega VARCHAR(255) NOT NULL,
    metodo_envio VARCHAR(50) NOT NULL,
    entregadora VARCHAR(100) NOT NULL,
    peso DECIMAL(10, 2) NOT NULL,
    data_entrega DATE NULL,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id)
);