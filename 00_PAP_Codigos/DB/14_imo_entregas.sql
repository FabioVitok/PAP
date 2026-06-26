USE imo_system;

DROP TABLE IF EXISTS entregas;

CREATE TABLE entregas (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT(11) UNSIGNED NOT NULL UNIQUE,
    morada_entrega VARCHAR(255) NOT NULL,
    metodo_envio VARCHAR(50) NOT NULL,
    entregadora VARCHAR(100) NOT NULL,
    peso DECIMAL(10, 2) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id)
);

INSERT INTO entregas(id_pedido, morada_entrega, metodo_envio, entregadora, peso, created_at) VALUES
(1, 'Rua das Flores, 123, Lisboa', 'Correios', 'CTT', 1.50, '2024-03-01 10:00:00'),
(2, 'Avenida da Liberdade, 456, Porto', 'Transportadora', 'DHL', 2.00, '2024-03-01 10:00:00'),
(3, 'Praça do Comércio, 789, Lisboa', 'Correios', 'CTT', 0.75, '2024-03-01 10:00:00'),
(4, 'Rua do Ouro, 333, Lisboa', 'Correios', 'CTT', 1.20,'2024-03-01 10:00:00'),
(5, 'Avenida dos Aliados, 654, Porto', 'Correios', 'CTT', 0.50,'2024-03-01 10:00:00'),
(6, 'Rua do Carmo, 987, Lisboa', 'Transportadora', 'UPS', 2.50,'2024-03-01 10:00:00'),
(7, 'Rua das Flores, 123, Lisboa', 'Correios', 'CTT', 1.00,'2024-03-01 10:00:00'),
(8, 'Praça do Comércio, 789, Lisboa', 'Correios', 'CTT', 1.80,'2024-03-01 10:00:00'),
(9, 'Rua do Ouro, 333, Lisboa', 'Correios', 'CTT', 0.90,'2024-03-01 10:00:00'),
(10, 'Avenida dos Aliados, 654, Porto', 'Correios', 'CTT', 2.20,'2024-03-01 10:00:00');