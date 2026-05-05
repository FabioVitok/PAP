# Portal — Lista de Tarefas

## Estrutura Base

- [ ]  Sidebar com navegação
- [ ]  Cabeçalho
- [ ]  Área de conteúdo
- [ ]  Estilos de tabelas conforme Figma
- [ ]  Estilos de botões conforme Figma

---

## Produtos

- [x]  Tabela com nome, preço e stock
- [x]  Botão adicionar produto
- [x]  Formulário de criação (nome, descrição, imagem, preço, categoria, stock)
- [x]  Botão editar produto
- [x]  Botão remover produto

---

## Utilizadores

- [x]  Tabela com nome/email, papel e estado
- [x]  Botão ativar/inativar utilizador

---

## Comunidade

- [x]  Tabela com texto, utilizador e data
- [ ]  Botão remover mensagem
- [ ]  Botão destacar mensagem _(opcional)_

---

## Models

- [x]  `Produto`
- [ ]  `CarrinhoItem`
- [x]  `User`
- [ ]  `MensagemComunidade`
- [ ]  `Categoria` _(se existir)_


5 Queries com função de agregação
- [x] Contar utilizadores registrados
	Serve para sabermos a quantidade de utilizadores totais
- [x] Contar produtos
	Serve para sabermos a quantidade de produtos totais
- [x] Receita de cada produto
	Serve para sabermos a receita de cada produto útil para saber quais produtos geram mais ganhos brutos
- [x] Ver quantidade de vendas de cada produto
	Serve para sabermos quanto vende cada produto isso é para sabermos quais produtos vendem mais ou menos, útil para sabermos como aplicamos descontos por exemplo 
- [x] Para atualizar o custo total do carrinho com base no custo dos produtos incluídos nele
	Serve para atualizar o custo total do carrinho para sabermos quando vai custar a compra daquele carrinho em especifico
- [ ] Utilizadores Inativos por Período de tempo
	Serve para sabermos a quanto tempo certo grupo de utilizadores esta inativo, sendo útil para nos aplicarmos técnicas para recuperar esses utilizadores
- [ ] Faixa etária de utilizadores
	Serve para sabermos a faixa etária dos nossos utilizadores, sendo útil para sabermos o nosso publico que estamos atingindo 
- [x] Mostrar todos os utilizadores
	Serve para ver todos os utilizadores que existem, útil para fazer listas com todos os utilizadores
- [x] Mostrar todos os produtos
	Serve para ver todos os produtos que existem, útil para fazer listas com todos os produtos
- [x] Mostrar todos os posts
	Serve para ver todos os posts que existem, útil para fazer listas com todos os posts
- [ ] Mostrar username do autor do post
	Serve para sabermos de maneira mais fácil qual utilizador fez o post pelo username

3 Queries com INNER JOIN
- [x] Receita de produto por categoria
	Serve para sabermos a receita total dos produtos de cada categoria útil para saber quais categorias geram mais ganhos brutos
- [ ] Contar utilizadores ativos
	Serve para sabermos quantos utilizadores são ativos na nossa loja, sendo útil para ver se estamos com a quantidade de publico desejada
- [ ] Contar utilizadores inativos
	Serve para sabermos quantos utilizadores são inativos na nossa loja, sendo útil para melhorarmos o produto e fazermos pesquisas para recuperarmos esses utilizadores inativas

2 Queries com LEFT JOIN
- [ ] Post sem comentários
	Serve para mostrar os posts que ainda nao tem comentarios, sendo util para analisarmos o motivo por exemplo nao chegar em utilizadores o suficiente 
- [ ] Utilizadores sem compras
	Serve para sabermos os utilizadores que ainda nao fizeram compras, é util para incentivarmos esses utilizadores a fazerem, com descontos por exemplo ou cupons
- [ ] Utilizadores sem nada no carrinho
	Serve para sabermos os utilizadores que ainda nao colocaram nada no carrinho, o que significa que podem nao ter interesse nos produtos existentes ou que os produtos nao estao com um preço que faça eles comprarem

2 Queries com calculos de media (AVG)
- [ ] Ticket médio dos utilizadores
	Serve para sabermos o ticket medio de todos os utilizadores, sendo util para saber quanto utilizador gasta em media
- [ ] Ticket medio de cada utilizador
	Serve para sabermos o ticket medio de cada utilizador, sendo util para saber quanto esse utilizador gasta em media
- [ ] Taxa de Retenção
	Serve para sabermos a taxa de retenção que nos temos, isso é a taxa de utilizadores que conseguimos converter a fazer compras e manter eles usando a nossa loja

3 Queries com HAVING
- [ ] Produtos com menos de 20 vendas
	Serve para sabermos os produtos com menos de 20 vendas, ou seja produtos que estão indo muito mal em vendas, com isso podemos mudar a forma de venda deles
- [ ] Produtos com mais de 100 vendas
	Serve para sabermos os produtos com mais de 100 vendas, ou seja produtos que estao indo bem, com isso fazendo descontos de comemoração por exeplo
- [ ] Utilizadores com mais de 10000 seguidores
	Serve para sabermos os utilizadores com mais de 10000 e podemos parabeniza-lo e incentivar ele a continuar ativo

Ticket Médio = Receita Total ÷ Número Total de Vendas
Taxa de Retenção = (Utilizadores Ativos ÷ Total de Utilizadores) × 100
Receita = Preço de Venda × Quantidade Vendida