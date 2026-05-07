USE imo_system;

DROP TABLE IF EXISTS pagamentos;

CREATE TABLE pagamentos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    id_pedido INT(11) UNSIGNED NOT NULL,
    metodo_pagamento VARCHAR(50) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_pagamento DATETIME NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id)
);

INSERT INTO pagamentos(id_utilizador, id_pedido, metodo_pagamento, valor, data_pagamento) VALUES
(3, 1, 'Cartão de Crédito', 100.00, '2024-03-01 10:00:00'),
(7, 2, 'PayPal', 150.00, '2024-04-01 10:05:00'),
(4, 3, 'Transferência Bancária', 200.00, '2024-04-03 12:00:00'),
(5, 4, 'Cartão de Crédito', 250.00, '2024-04-25 14:00:00'),
(8, 5, 'PayPal', 300.00, '2024-04-27 12:30:00'),
(19, 6, 'Transferência Bancária', 350.00, '2024-05-25 14:30:00'),
(3, 7, 'Cartão de Crédito', 400.00, '2024-06-01 10:00:00'),
(4, 8, 'PayPal', 450.00, '2024-06-01 10:05:00'),
(5, 9, 'Transferência Bancária', 500.00, '2024-06-02 11:15:00'),
(8, 10, 'Transferência Bancária', 500.00, '2024-06-03 12:01:00');