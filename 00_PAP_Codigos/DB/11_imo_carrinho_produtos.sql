USE imo_system;

DROP TABLE IF EXISTS carrinho_produtos;

CREATE TABLE carrinho_produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_carrinho INT(11) UNSIGNED NOT NULL,
    id_produto INT(11) UNSIGNED NOT NULL,
    quantidade INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_carrinho) REFERENCES carrinhos(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id),
    UNIQUE KEY uq_carrinho_produto (id_carrinho, id_produto)
);

INSERT INTO carrinho_produtos(id_carrinho, id_produto, quantidade, created_at) VALUES
(3, 1, 2, '2024-03-01 10:00:00'),
(3, 13, 2, '2024-03-01 12:00:00'),
(7, 2, 1, '2024-04-01 10:05:00'),
(3, 3, 3, '2024-04-02 11:00:00'),
(4, 4, 1, '2024-04-02 11:15:00'),
(4, 5, 2, '2024-04-03 12:00:00'),
(4, 14, 2, '2024-04-03 12:01:00'),
(3, 6, 1, '2024-04-03 12:30:00'),
(4, 7, 1, '2024-04-24 13:00:00'),
(4, 8, 2, '2024-04-24 13:45:00'),
(5, 9, 1, '2024-04-25 14:00:00'),
(5, 14, 2, '2024-04-25 14:00:00'),
(8, 6, 1, '2024-04-27 12:30:00'),
(8, 7, 1, '2024-05-04 13:00:00'),
(8, 8, 2, '2024-05-04 13:45:00'),
(8, 13, 2, '2024-05-04 13:47:32'),
(8, 9, 1, '2024-05-05 14:00:00');

INSERT INTO carrinho_produtos(id_carrinho, id_produto, quantidade, created_at) VALUES
(20, 1, 2, '2024-06-01 10:00:00'),
(20, 13, 2, '2024-06-01 12:00:00'),
(21, 2, 1, '2024-06-01 10:05:00'),
(22, 4, 1, '2024-06-02 11:15:00'),
(23, 5, 2, '2024-06-03 12:00:00'),
(24, 14, 2, '2024-06-03 12:01:00'),
(20, 6, 1, '2024-06-04 12:30:00'),
(21, 7, 1, '2024-07-04 13:00:00');

