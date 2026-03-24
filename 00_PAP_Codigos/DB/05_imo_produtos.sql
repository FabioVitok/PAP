USE imo_system;

DROP TABLE IF EXISTS produtos;

CREATE TABLE produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    tamanho VARCHAR(10) NOT NULL,
    peso DECIMAL(5,2) UNSIGNED NOT NULL,
    tipo VARCHAR(30) NOT NULL,
    cor VARCHAR(30),
    preco_venda DECIMAL(5,2) UNSIGNED NOT NULL,
    preco_custo DECIMAL(5,2) UNSIGNED NOT NULL,
    stock SMALLINT UNSIGNED NOT NULL
);

INSERT INTO produtos(nome, tamanho, peso, tipo, cor, preco_venda, preco_custo, stock) VALUES
('Pierced shoulder Off', "xs", 0,45, "Preto", 25.55, 15.00, 10),
('Pierced shoulder Off', "s", 0,50, "Preto", 25.55, 15.10, 10),
('Pierced shoulder Off', "m", 0,55, "Preto", 25.55, 15.20, 10),
('Pierced shoulder Off', "l", 0,60, "Preto", 25.55, 15.30, 10),
('Pierced shoulder Off', "xl", 0,65, "Preto", 25.55, 15.40, 10),
('Pierced shoulder Off', "xxl", 0,70, "Preto", 25.55, 15.50, 10);

INSERT INTO produtos(nome, tamanho, peso, tipo, cor, preco_venda, preco_custo, stock) VALUES
('Flared distress Jeans', "36", 0,65, "Preto", 29.99, 15.00, 10),
('Flared distress Jeans', "38", 0,70, "Preto", 29.99, 15.10, 10),
('Flared distress Jeans', "40", 0,75, "Preto", 29.99, 15.20, 10),
('Flared distress Jeans', "42", 0,80, "Preto", 29.99, 15.30, 10),
('Flared distress Jeans', "44", 0,85, "Preto", 29.99, 15.40, 10),
('Flared distress Jeans', "46", 0,90, "Preto", 29.99, 15.50, 10);

INSERT INTO produtos(nome, tamanho, peso, tipo, cor, preco_venda, preco_custo, stock) VALUES
('Distressed Scarf', "Único", 0,20, "Preto", 15.50, 5.00, 10),
('Eyelet Lace Bag', "Único", 0,20, "Preto", 25.99, 15.00, 10),
('Snake Belt', "Único", 0,15, "Preto", 19.99, 10.00, 10),
('Eyelet kerchief', "Único", 0,10, "Preto", 12.99, 5.00, 10);



