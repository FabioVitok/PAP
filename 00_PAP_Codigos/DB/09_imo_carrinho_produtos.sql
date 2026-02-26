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

