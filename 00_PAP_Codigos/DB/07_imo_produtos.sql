USE imo_system;

DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS produtos_pai;

CREATE TABLE produtos_pai (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    tipo VARCHAR(30) NOT NULL,
    cor VARCHAR(30),
    image VARCHAR(255),
    preco_venda DECIMAL(5,2) UNSIGNED NOT NULL
);

CREATE TABLE produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_produto_pai INT(11) UNSIGNED NOT NULL,
    tamanho VARCHAR(10) NOT NULL,
    stock SMALLINT UNSIGNED NOT NULL,
    peso DECIMAL(5,2) UNSIGNED NOT NULL,
    preco_custo DECIMAL(5,2) UNSIGNED NOT NULL,
    FOREIGN KEY (id_produto_pai) REFERENCES produtos_pai(id)
);

-- produtos pai
INSERT INTO produtos_pai (nome, tipo, cor, image, preco_venda) VALUES
('Pierced shoulder Off', 'Camisola', 'Preto', 'assets/images/products/piercedshoulder.png', 20.00),
('Flared distress Jeans', 'Calças', 'Preto', 'assets/images/products/flaredjeans.png', 29.99),
('Distressed Scarf', 'Acessório', 'Preto', 'assets/images/products/distressed_scarf.jpg', 15.50),
('Eyelet Lace Bag', 'Acessório', 'Preto', 'assets/images/products/eyeletbag.png', 25.99),
('Snake Belt', 'Acessório', 'Preto', 'assets/images/products/lacebelt.png', 19.99),
('Eyelet kerchief', 'Acessório', 'Preto', 'assets/images/products/eyelet_kerchief.png', 12.99),
('Pierced shirt', 'Camisola', 'Preto', 'assets/images/products/piercedshirt.png', 15.00);

-- pierced shoulder Off
INSERT INTO produtos (id_produto_pai, tamanho, peso, preco_custo, stock) VALUES
(1, 'XS', 0.45, 10.00, 10),
(1, 'S',  0.50, 10.10, 10),
(1, 'M',  0.55, 10.20, 10),
(1, 'L',  0.60, 10.30, 10),
(1, 'XL', 0.65, 10.40, 10),
(1, 'XXL',0.70, 15.50, 10);

-- flared distress Jeans
INSERT INTO produtos (id_produto_pai, tamanho, peso, preco_custo, stock) VALUES
(2, '36', 0.65, 15.00, 10),
(2, '38', 0.70, 15.10, 10),
(2, '40', 0.75, 15.20, 10),
(2, '42', 0.80, 15.30, 10),
(2, '44', 0.85, 15.40, 10),
(2, '46', 0.90, 15.50, 10);

-- pierced shirt
INSERT INTO produtos (id_produto_pai, tamanho, peso, preco_custo, stock) VALUES
(7, 'XS', 0.65, 15.00, 10),
(7, 'S', 0.70, 15.10, 10),
(7, 'M', 0.75, 15.20, 10),
(7, 'L', 0.80, 15.30, 10),
(7, 'XL', 0.85, 15.40, 10),
(7, 'XXL', 0.90, 15.50, 10);

-- acessórios
INSERT INTO produtos (id_produto_pai, tamanho, peso, preco_custo, stock) VALUES
(3, 'Único', 0.20, 5.00,  10),
(4, 'Único', 0.20, 15.00, 10),
(5, 'Único', 0.15, 10.00, 10),
(6, 'Único', 0.10, 5.00,  10);