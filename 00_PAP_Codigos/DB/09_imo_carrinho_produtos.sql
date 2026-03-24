USE imo_system;

DROP TABLE IF EXISTS carrinho_prodtuos;

CREATE TABLE carrinho_produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_carrinho INT(11) UNSIGNED NOT NULL,
    id_produto INT(11) UNSIGNED NOT NULL,
    quantidade INT NOT NULL,
    dt_adicao DATETIME NOT NULL,
    dt_retiro DATETIME NULL, -- Vazio se nao foi cancelado
    FOREIGN KEY (id_carrinho) REFERENCES carrinhos(id),
    FOREIGN KEY (id_produto) REFERENCES produtos(id)
);

INSERT INTO carrinho_produtos(id_carrinho, id_produto, quantidade, dt_adicao) VALUES
(1, 1, 2, '2024-01-01 10:00:00'),
(1, 2, 1, '2024-01-01 10:05:00'),
(2, 3, 3, '2024-01-02 11:00:00'),
(2, 4, 1, '2024-01-02 11:15:00'),
(3, 5, 2, '2024-01-03 12:00:00'),
(3, 6, 1, '2024-01-03 12:30:00'),
(4, 7, 1, '2024-01-04 13:00:00'),
(4, 8, 2, '2024-01-04 13:45:00'),
(5, 9, 1, '2024-01-05 14:00:00'),
(5, 10, 3, '2024-01-05 14:30:00');

