USE imo_system;

SELECT * FROM carrinho_produtos;
SELECT * FROM carrinhos;

SELECT * FROM produtos;

SELECT * FROM utilizadores;

SELECT * FROM posts;


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


-- 15 Queries

-- Query para ver todos os produtos
SELECT p.id, p.nome, p.tamanho, p.peso, p.tipo, p.cor, p.preco_venda, p.preco_custo, p.stock
FROM produtos AS p;

-- Query para ver todos os utilizadores
SELECT u.id, u.username, u.email, u.imageId, u.telefone, u.password, u.morada, u.dt_nascimento, u.pronomes
FROM utilizadores AS u;

-- Query para ver todos os posts
SELECT po.id, po.id_utilizador, po.dt_postagem, po.texto_post, po.like_count
FROM posts AS po;

-- Query para contar o número total de utilizadores
SELECT COUNT(*)
FROM utilizadores;

-- Query para contar o número total de produtos
SELECT COUNT(*)
FROM produtos;

-- Query para ver a receita de cada produto 
SELECT p.nome, p.tamanho, SUM(p.preco_venda * cp.quantidade)
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
GROUP BY p.id;

-- Query para ver os pordutos mais vendidos (CARRINHOS)
SELECT p.nome, SUM(cp.quantidade) AS total_vendido
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
GROUP BY p.nome
ORDER BY total_vendido DESC;

-- Query para atualizar o custo_total dos carrinhos com base no custo dos produtos incluidos nele
UPDATE carrinhos
SET custo_total = (SELECT SUM(p.preco_venda * cp.quantidade)
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id AND cp.id_carrinho = carrinhos.id)
WHERE carrinhos.id IN (SELECT id_carrinho FROM carrinho_produtos);  

-- Query para saber a receita de produtos por categoria
SELECT p.tipo, SUM(p.preco_venda * cp.quantidade) AS receita
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
GROUP BY p.tipo;

-- Query para ver os posts sem comentários
SELECT po.id, po.id_utilizador, po.dt_postagem, po.texto_post, po.like_count
FROM posts AS po
LEFT JOIN comentarios AS c ON po.id = c.id_post
WHERE c.id_post IS NULL;


-- Query para contar utilizadores inativos
SELECT COUNT(*)
FROM estado_contas 
WHERE data_alteracao = (SELECT MAX(data_alteracao)
FROM estado_contas AS ec
LEFT JOIN utilizadores AS u ON u.id = ec.id_utilizador
);

SELECT u.id, MAX(data_alteracao)
FROM estado_contas AS ec
LEFT JOIN utilizadores AS u ON u.id = ec.id_utilizador
HAVING(ec.id_estado = 10)
GROUP BY u.id;