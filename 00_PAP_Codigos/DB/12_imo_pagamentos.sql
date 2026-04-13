USE imo_system;

DROP TABLE IF EXISTS pagamentos;

CREATE TABLE pagamentos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_utilizador INT(11) UNSIGNED NOT NULL,
    id_pedido INT(11) UNSIGNED NOT NULL,
    metodo_pagamento VARCHAR(50) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_pagamento DATE NULL,
    -- status_pagamento VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_utilizador) REFERENCES utilizadores(id),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id)
);

INSERT INTO pagamentos(id_utilizador, id_pedido, metodo_pagamento, valor, data_pagamento) VALUES
(1, 1, 'Cartão de Crédito', 100.00, '2024-06-01'),
(2, 2, 'PayPal', 150.00, '2024-06-02'),
(3, 3, 'Transferência Bancária', 200.00, '2024-06-03'),
(4, 4, 'Cartão de Crédito', 250.00, '2024-06-04'),
(5, 5, 'PayPal', 300.00, '2024-06-05'),
(6, 6, 'Transferência Bancária', 350.00, '2024-06-06'),
(7, 7, 'Cartão de Crédito', 400.00, '2024-06-07'),
(8, 8, 'PayPal', 450.00, '2024-06-08'),
(9, 9, 'Transferência Bancária', 500.00, '2024-06-09');