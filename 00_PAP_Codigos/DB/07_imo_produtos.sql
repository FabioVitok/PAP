USE imo_system;

DROP TABLE IF EXISTS produtos;

CREATE TABLE produtos (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    tamanho VARCHAR(10) NOT NULL,
    peso DECIMAL(5,2) UNSIGNED NOT NULL,
    tipo VARCHAR(30) NOT NULL,
    cor VARCHAR(30),
    image VARCHAR(255),
    preco_venda DECIMAL(5,2) UNSIGNED NOT NULL,
    preco_custo DECIMAL(5,2) UNSIGNED NOT NULL,
    stock SMALLINT UNSIGNED NOT NULL
);

INSERT INTO produtos(nome, tamanho, peso, tipo, cor, image, preco_venda, preco_custo, stock) VALUES
('Pierced shoulder Off', "XS", '0.45' ,"Camisola", "Preto", "pierced_shoulder_off_xs.jpg", '15.00', '10.00', 10),
('Pierced shoulder Off', "S", '0.50', "Camisola", "Preto", "pierced_shoulder_off_s.jpg", '15.10', '10.10', 10),
('Pierced shoulder Off', "M", '0.55', "Camisola", "Preto", "pierced_shoulder_off_m.jpg", '15.20', '10.20', 10),
('Pierced shoulder Off', "L", '0.60', "Camisola", "Preto", "pierced_shoulder_off_l.jpg", '15.30', '10.30', 10),
('Pierced shoulder Off', "XL", '0.65', "Camisola", "Preto", "pierced_shoulder_off_xl.jpg", '15.40', '10.40', 10),
('Pierced shoulder Off', "XLL", '0.70', "Camisola", "Preto", "pierced_shoulder_off_xll.jpg", '25.55', '15.50', 10);

INSERT INTO produtos(nome, tamanho, peso, tipo, cor, image, preco_venda, preco_custo, stock) VALUES
('Flared distress Jeans', "36", '0.65',"Calças", "Preto", "flared_distress_jeans_36.jpg", '29.99', '15.00', 10),
('Flared distress Jeans', "38", '0.70', "Calças", "Preto", "flared_distress_jeans_38.jpg", '29.99', '15.10', 10),
('Flared distress Jeans', "40", '0.75', "Calças", "Preto", "flared_distress_jeans_40.jpg", '29.99', '15.20', 10),
('Flared distress Jeans', "42", '0.80', "Calças", "Preto", "flared_distress_jeans_42.jpg", '29.99', '15.30', 10),
('Flared distress Jeans', "44", '0.85', "Calças", "Preto", "flared_distress_jeans_44.jpg", '29.99', '15.40', 10),
('Flared distress Jeans', "46", '0.90', "Calças", "Preto", "flared_distress_jeans_46.jpg", '29.99', '15.50', 10);

INSERT INTO produtos(nome, tamanho, peso, tipo, cor, image, preco_venda, preco_custo, stock) VALUES
('Distressed Scarf', "Único", '0.20', "Acessório", "Preto", "distressed_scarf.jpg", '15.50', '5.00', 10),
('Eyelet Lace Bag', "Único", '0.20', "Acessório", "Preto", "eyelet_lace_bag.jpg", '25.99', '15.00', 10),
('Snake Belt', "Único", '0.15', "Acessório", "Preto", "snake_belt.jpg", '19.99', '10.00', 10),
('Eyelet kerchief', "Único", '0.10', "Acessório", "Preto", "eyelet_kerchief.jpg", '12.99', '5.00', 10);
