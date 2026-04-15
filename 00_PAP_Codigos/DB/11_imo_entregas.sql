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

INSERT INTO entregas(id_pedido, morada_entrega, metodo_envio, entregadora, peso) VALUES
(1, 'Rua das Flores, 123, Lisboa', 'Correios', 'CTT', 1.50),
(2, 'Avenida da Liberdade, 456, Porto', 'Transportadora', 'DHL', 2.00),
(3, 'Praça do Comércio, 789, Lisboa', 'Correios', 'CTT', 0.75),
(4, 'Rua de Santa Catarina, 321, Porto', 'Transportadora', 'FedEx', 1.20),
(5, 'Avenida dos Aliados, 654, Porto', 'Correios', 'CTT', 0.50),
(6, 'Rua do Carmo, 987, Lisboa', 'Transportadora', 'UPS', 2.50),
(7, 'Praça da Figueira, 111, Lisboa', 'Correios', 'CTT', 1.00),
(8, 'Avenida da República, 222, Porto', 'Transportadora', 'DHL', 1.80),
(9, 'Rua do Ouro, 333, Lisboa', 'Correios', 'CTT', 0.90),
(10, 'Avenida dos Descobrimentos, 444, Porto', 'Transportadora', 'FedEx', 2.20);