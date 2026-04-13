USE imo_system;

SELECT * FROM carrinho_produtos;
SELECT * FROM carrinhos;

SELECT * FROM produtos;

-- Query para atualizar o custo_total dos carrinhos com base no custo dos produtos incluidos nele
UPDATE carrinhos
SET custo_total = (SELECT SUM(p.preco_venda * cp.quantidade)
FROM carrinho_produtos as cp, produtos as p
WHERE cp.id_produto = p.id AND cp.id_carrinho = carrinhos.id)
WHERE carrinhos.id IN (SELECT id_carrinho FROM carrinho_produtos);

-- Query para ver os pordutos mais vendidos (CARRINHOS)
SELECT p.nome, SUM(cp.quantidade) AS total_vendido
FROM carrinho_produtos AS cp, produtos as p
WHERE cp.id_produto = p.id
GROUP BY p.nome
ORDER BY total_vendido DESC;

-- Filtro para calças
SELECT * FROM produtos
WHERE tipo = "Calças";

-- Filtro para camisolas
SELECT * FROM produtos
WHERE tipo = "Camisola";

-- Filtro para acessórios
SELECT * FROM produtos
WHERE tipo = "Acessório";

-- Ordernar produtos por preço de venda descrescente
SELECT * FROM produtos
ORDER BY preco_venda DESC;

-- Ordernar produtos por preço de venda crescente
SELECT * FROM produtos  
ORDER BY preco_venda ASC;

-- Ordenar produtos por ordem alfabética
SELECT * FROM produtos
ORDER BY nome ASC;

-- Ordenar produtos por stock
SELECT nome, SUM(stock) AS total_stock
FROM produtos
GROUP BY nome
ORDER BY total_stock DESC;
