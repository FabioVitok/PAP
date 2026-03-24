USE imo_system;

SELECT * FROM carrinho_produtos;
SELECT * FROM carrinhos;

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
