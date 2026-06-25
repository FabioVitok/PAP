
Para programar a parte de comunidade vai ser preciso desenvolver uma frontend backend e uma base de dados para armazenar tudo, como usuários comentários posts e status dos posts.

Para a a Frontend vai ser necessário usar as seguintes linguagens [HTML, CSS, JavaScript]
Para a Backend pode se usar varias diferentes mas para simplificar provavelmente seria melhor usa algo em JavaScript para não diferenciar tanto do processo da Frontend
Para a base de dados acho que o melhor seria usar SQL visto que é a linguagem que mais aprendemos sobre no curso no quesito de bases de dados.

Na parte de comunidade precisamos de autentificação de utilizador, que verifique o email o username e a password (esses vão ser os únicos requisitos para criar uma conta), esses dados dos utilizadores vão ser armazenados na base de dados após o utilizador criar a conta

o sistema do site e de como funciona o feed seria similar ao reddit, como se o site inteiro da comunidade fosse um subreddit, precisamos de armazenar para alem dos posts também os comentários e a quantidade de likes
<iframe width="560" height="315" src="https://www.youtube.com/embed/DKlTBBuc32c?si=3kNm9NecQscD-vbQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>



nosso projeto é constituido por varias partes que funcionam em conjunto.

A principal é a App Android programada em java é nela onde nossos utilizadores podem aceder as nossas princpais funções o espaço comunidade e a loja

Depois vem a nossa api que conecta a App com nossa base de dados, ela permite fazer chamadas http a base de dados de forma a conseguir criar tabelas, alterar tabelas, apagar tabelas e claro passar dados

Site Apresentação que é onde apresentamos nosso produto para pessoas que nao o conhecem e a entrada do Paindel de administração

No Painel de Administração temos tudo o que precisamos para gerir o negocio seja fazer a gestão de utilizadores, produtos ou posts e comentarios até observar dados para determinar o que implementar no futuro por exemplo.





Aqui no Site de Apresentação o utilizador pode ver sobre a imoral mas o principal é que ele pode fazer o sign up  
e o login

o login do site apresentação funciona da seguinte maneira:

nos vemos se os campos estão preenchidos  
nos verificamos se temos algum utilizador com esse email  
depois pegamos a imagem do utilizador e vemos se o prefixo bate certo  
verifica a password  
coloca os dados na session no token

o sign up funciona de um jeito similar

- Pega username, email, password do POST
- Valida que username e email não estão vazios.
- Valida formato do email.
- Verifica se já existe usuário com esse email.
- Cria o usuário como "pending" no banco
- Se enviou imagem, faz upload e atualiza o registro do usuário com o caminho dela.
- Cria um token de verificação válido por 300 segundos (5 min), ligado a esse userId.
- Monta a URL base dinâmica
- Monta o link de verificação com o token.
- Monta o HTML do email e envia via Mailer.
- Salva mensagem de toast na sessão e redireciona para `/login`.

painel

entrar no meu utilizador no site  
mostrar dashboard  
simular uma compra  
mostrar main info users  
mostrar funcionalidades na tabela users  
add  
update  
activate  
suspend  
delete/ban  
unban

mostrar info dos produtos  
produtos pai  
add  
update

produtos  
add  
update  
delete

posts


