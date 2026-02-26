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