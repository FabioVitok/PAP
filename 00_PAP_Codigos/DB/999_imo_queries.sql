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

-- 3 Inner join
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

-- Query para ver os produtos mais vendidos
SELECT p.nome, SUM(cp.quantidade) AS total_vendido
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
GROUP BY p.nome
ORDER BY total_vendido DESC;

-- 2 Left Join
-- Query para ver os posts sem comentários
SELECT po.id, po.id_utilizador, po.dt_postagem, po.texto_post, po.like_count
FROM posts AS po
LEFT JOIN comentarios AS c ON po.id = c.id_post
WHERE c.id_post IS NULL;

-- Query para ver os utilizadores sem compras realizadas
SELECT u.id, u.username, u.email
FROM utilizadores AS u
LEFT JOIN carrinhos AS c ON u.id = c.id_utilizador
LEFT JOIN pedidos AS p ON c.id = p.id_carrinho
WHERE p.id_carrinho IS NULL AND is_admin = false;


-- 5 Funções de agregação
-- Query para ver utilizadores inativos por período de tempo
SELECT 
CASE
        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao) ) < 30 THEN 'Menos de 1 mês'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao) ) BETWEEN 30 AND 60  THEN '1 a 2 meses'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao) ) BETWEEN 60 AND 90 THEN '2 a 3 meses'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE, data_alteracao) ) BETWEEN 90 AND 180 THEN '3 a 6 meses'
        ELSE 'Mais de 6 meses'
        END AS TempoInatividade,
COUNT(*) AS total_utilizadores
FROM estado_contas AS ec
WHERE ec.id_estado = 10
AND ec.data_alteracao = (
SELECT MAX(sub.data_alteracao)
FROM estado_contas AS sub
WHERE sub.id_utilizador = ec.id_utilizador
) GROUP BY TempoInatividade;

-- Query para ver quantos utilizadores existem por faixa Etária
SELECT 
CASE
        WHEN FLOOR(DATEDIFF(CURRENT_DATE, dt_nascimento) / 365.25) < 18 THEN 'Adolescentes 13-17'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE, dt_nascimento) / 365.25) BETWEEN 18 AND 30 THEN 'Jovens Adultos 18-29'
        WHEN FLOOR(DATEDIFF(CURRENT_DATE, dt_nascimento) / 365.25) BETWEEN 31 AND 50 THEN 'Adultos 30-59'
        ELSE 'Sénior 60+'
END AS FaixaEtaria,
COUNT(*) AS total_utilizadores
FROM utilizadores 
GROUP BY FaixaEtaria;

-- Query para ver as receitas de cada tamanho de cada produto 
SELECT SUM(p.preco_venda * cp.quantidade) AS receita
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
GROUP BY p.id;

-- Query para ver a receita de cada produto 
SELECT SUM(p.preco_venda * cp.quantidade) AS receita
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
WHERE p.id = 1
GROUP BY p.id

-- Query para ver os produtos mais vendidos
SELECT p.nome, SUM(cp.quantidade) AS total_vendido
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
GROUP BY p.nome
ORDER BY total_vendido DESC;

-- Query para ver venda de cada produto
SELECT SUM(cp.quantidade) AS total_vendido
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
WHERE p.id = 1
GROUP BY p.id;

-- Query para ver os utilizadores inativos
SELECT ec.id_utilizador, ec.data_alteracao AS ultima_alteracao
FROM estado_contas AS ec
WHERE ec.id_estado = 10
AND ec.data_alteracao = (
SELECT MAX(sub.data_alteracao)
FROM estado_contas AS sub
WHERE sub.id_utilizador = ec.id_utilizador
) GROUP BY ec.id_utilizador, ec.data_alteracao, ec.id_estado;

-- 3 cláusula having

-- Query para ver produtos com menos de 10 unidades vendidas
SELECT p.nome, SUM(cp.quantidade) AS total_vendido
FROM carrinho_produtos AS cp
INNER JOIN produtos AS p ON cp.id_produto = p.id
INNER JOIN pedidos AS pe ON cp.id_carrinho = pe.id_carrinho
GROUP BY p.nome
HAVING total_vendido < 10;

-- Query para ver os utilizadores com mais de 1 compra realizada
SELECT u.id, u.username, COUNT(p.id) AS total_compras
FROM utilizadores AS u
INNER JOIN carrinhos AS c ON u.id = c.id_utilizador
INNER JOIN pedidos AS p ON c.id = p.id_carrinho
GROUP BY u.id
HAVING total_compras > 1;

-- Query para ver os utilizadores com mais de 10 seguidores
SELECT u.id, u.username, COUNT(f.id_seguidor) AS total_seguidores
FROM utilizadores AS u
INNER JOIN followship AS f ON u.id = f.id_seguido
GROUP BY u.id
HAVING total_seguidores > 10;

-- 2 calculo de médias

-- Média de produtos por pedido
SELECT ROUND(AVG(total_produtos), 2) AS media_produtos_por_pedido
FROM (
SELECT SUM(cp.quantidade) AS total_produtos
FROM carrinho_produtos AS cp  
INNER JOIN carrinhos AS c ON cp.id_carrinho = c.id
INNER JOIN pedidos AS p ON c.id = p.id_carrinho
GROUP BY p.id
) AS subquery;

-- Média de preço dos produtos
SELECT ROUND(AVG(preco_venda), 2) AS media_preco_produtos
FROM produtos;

SELECT nome, preco_venda, image
FROM produtos
GROUP BY nome, preco_venda, image;

SELECT 
        carrinho_produtos.id,
        carrinho_produtos.id_carrinho,
        carrinho_produtos.id_produto,
        carrinho_produtos.quantidade,
        carrinho_produtos.dt_adicao,
        produtos.id,
        produtos.nome,
        produtos.tamanho,
        produtos.preco_venda
FROM carrinho_produtos
INNER JOIN produtos ON carrinho_produtos.id_produto = produtos.id
INNER JOIN carrinhos ON carrinho_produtos.id_carrinho = carrinhos.id
INNER JOIN utilizadores ON carrinhos.id_utilizador = utilizadores.id
WHERE carrinhos.id_utilizador = 4;

DELETE carrinho_produtos 
FROM carrinho_produtos
INNER JOIN carrinhos ON carrinho_produtos.id_carrinho = carrinhos.id
WHERE carrinho_produtos.id = ? 
AND carrinhos.id_utilizador = ?;

SHOW CREATE TABLE utilizadores;

 SELECT 
                p.id,
                p.id_utilizador,
                u.username,
                u.image,
                p.dt_postagem,
                p.texto_post,
                p.like_count
            FROM posts as p
            INNER JOIN utilizadores as u ON p.id_utilizador = u.id
            WHERE p.id = 1
            LIMIT 1;

                SELECT 
            p.id,
            p.id_utilizador,
            u.username,
            u.image,
            p.dt_postagem,
            p.texto_post,
            p.like_count,
            COUNT(c.id) as comment_count
        FROM posts as p
        INNER JOIN utilizadores as u ON p.id_utilizador = u.id
        LEFT JOIN comentarios as c ON c.id_post = p.id
        GROUP BY p.id;


       SELECT 
    c.id,
    c.id_post,
    c.id_utilizador,
    u.username,
    u.image,
    c.dt_comentario,
    c.texto_comentario,
    c.like_count,
    COUNT(r.id) as reply_count
FROM comentarios as c
INNER JOIN utilizadores as u ON c.id_utilizador = u.id
LEFT JOIN comentarios as r ON r.id_comentario_pai = c.id
WHERE c.id_post = ? AND c.id_comentario_pai IS NULL
GROUP BY c.id
ORDER BY c.dt_comentario ASC

SELECT 
            c.id,
            c.id_post,
            c.id_utilizador,
            u.username,
            u.image,
            c.dt_comentario,
            c.texto_comentario,
            c.like_count
        FROM comentarios as c
        INNER JOIN utilizadores as u ON c.id_utilizador = u.id
        WHERE c.id_comentario_pai = ?
        GROUP BY c.id
        ORDER BY c.dt_comentario ASC

SELECT 
    u.id,
    u.username,
    u.image,
    u.morada,
    u.dt_nascimento,
    u.dt_criacao,
    u.pronomes,
    u.ultimo_login,
    COUNT(DISTINCT seguidores.id_seguidor) AS seguidores,
    COUNT(DISTINCT seguindo.id_seguido)    AS seguindo
        
FROM utilizadores AS u
LEFT JOIN followship seguidores ON seguidores.id_seguido = u.id
LEFT JOIN followship seguindo   ON seguindo.id_seguidor = u.id
WHERE u.id = 1
  AND u.is_verified = 1
  AND u.verified_at IS NOT NULL
LIMIT 1;


    Select p.id,
    p.id_produto_pai,
    p.tamanho,
    p.peso,
    p.preco_custo,
    p.stock
    FROM produtos AS p
    INNER JOIN produtos_pai ON p.id = produtos_pai.id
    WHERE p.id_produto_pai = ?

    
    
    SELECT 
                p.id,
                p.id_utilizador,
                u.username,
                u.image,
                p.dt_postagem,
                p.texto_post,
                p.created_at,
                p.updated_at,
                p.deleted_at,
                COUNT(pl.id) as like_count,
                COUNT(c.id) as comment_count
            FROM posts as p
            LEFT JOIN post_likes as pl ON pl.id_post = p.id
            INNER JOIN utilizadores as u ON p.id_utilizador = u.id
            LEFT JOIN comentarios as c ON c.id_post = p.id
            WHERE p.id_utilizador = ?
            GROUP BY p.id
            ORDER BY p.created_at DESC
    

SELECT 
                p.id,
                p.id_utilizador,
                u.username,
                u.image,
                p.dt_postagem,
                p.texto_post,
                p.created_at,
                p.updated_at,
                p.deleted_at,
                COUNT(pl.id) as like_count,
                COUNT(c.id) as comment_count
            FROM posts as p
            LEFT JOIN post_likes as pl ON pl.id_post = p.id
            INNER JOIN utilizadores as u ON p.id_utilizador = u.id
            LEFT JOIN comentarios as c ON c.id_post = p.id
            WHERE p.id_utilizador = 1
            GROUP BY p.id
            ORDER BY p.created_at DESC

SELECT 
            pedidos.id                  AS pedido_id,
            pedidos.dt_compra,
            pagamentos.metodo_pagamento,
            pagamentos.valor,
            entregas.morada_entrega,
            entregas.metodo_envio,
            entregas.entregadora,
            entregas.peso
        FROM pedidos
        INNER JOIN pagamentos ON pagamentos.id_pedido    = pedidos.id
        INNER JOIN entregas   ON entregas.id_pedido      = pedidos.id
        WHERE pagamentos.id_utilizador = 3
        ORDER BY pedidos.dt_compra DESC;


          SELECT 
            pedido_produtos.id,
            pedido_produtos.id_pedido,
            pedido_produtos.id_produto,
            pedido_produtos.quantidade,
            produtos_pai.nome,
            produtos_pai.preco_venda,
            produtos_pai.image,
            produtos.tamanho
        FROM pedido_produtos
        INNER JOIN produtos ON pedido_produtos.id_produto = produtos.id
        INNER JOIN produtos_pai ON produtos.id_produto_pai = produtos_pai.id
        WHERE pedido_produtos.id_pedido = ?;


         SELECT 
                carrinho_produtos.id,
                carrinho_produtos.id_carrinho AS id_carrinho,
                carrinho_produtos.id_produto AS id_produto,
                carrinho_produtos.quantidade,
                produtos_pai.nome,
                produtos_pai.image,
                produtos.tamanho,
                produtos_pai.preco_venda
            FROM carrinho_produtos
            INNER JOIN produtos ON carrinho_produtos.id_produto = produtos.id
            INNER JOIN produtos_pai ON produtos.id_produto_pai = produtos_pai.id
            INNER JOIN carrinhos ON carrinho_produtos.id_carrinho = carrinhos.id
            INNER JOIN utilizadores ON carrinhos.id_utilizador = utilizadores.id
            WHERE carrinhos.id_utilizador = 1;

