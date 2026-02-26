### Pontos de ordem do que fazer

- Card com users Ativos, Inativos e contas apagadas.
- Taxa de Retenção geral.
- Gráfico de users inativos e excluidos.
- Tabelas
	- Tab 1 Tabela com retenção geral
	- Tab 2 Tabela com Inatividade
	- Tab 3 Tabela com exclusão
- Gráfico de régua do tempo de utilizadores inativos.
- Motivos da exclusão de conta.

### Explicação dos pontos:
##### **Parte de cima - Informações Gerais**

Logo de cara, os números mais importantes do período atual: taxa de retenção geral, churn, total de usuários ativos. São os "semáforos" — dão uma leitura imediata de saúde do produto.

1. Para usuários ativos é simples — você conta quem realizou alguma ação no período definido.

2. Para inativos, você pega quem tinha conta ativa no período anterior mas não fez nenhuma ação no período atual.

3. Para excluídos, é só contar as exclusões no período.

4. A taxa de retenção geral então é: ativos atuais menos novos cadastros, dividido pelos ativos do período anterior.

##### **Gráfico de linha com duas curvas**

Mostra a evolução da retenção mês a mês. Ótimo para identificar tendências  se está subindo, caindo, ou se alguma mudança no produto impactou o número.

Uma curva para inativos e outra para contas apagadas ao longo do tempo. Isso permite ver padrões, por exemplo, toda vez que você lança uma atualização, as exclusões de conta sobem? Ou a inatividade aumenta em certas épocas do ano?

##### **Tabela de coorte separada por tipo**

Aqui você teria a opção de alternar entre três visões: retenção geral, queda por inatividade e queda por exclusão. Assim você consegue ver, por exemplo, que um coorte específico tem muita inatividade mas pouca exclusão — sinal de que vale reengajar aquele grupo.

É uma grade onde as linhas são os grupos de usuários por data de entrada (Jan, Fev, Mar...) e as colunas são os períodos seguintes (semana 1, semana 2, semana 3...). Cada célula mostra a % de retenção daquele coorte naquele período.

Geralmente usa um **mapa de calor** com cores — verde para retenção alta, vermelho para baixa. Isso permite ver de relance onde as pessoas estão abandonando e se coortes mais recentes estão melhores ou piores que os antigos.

##### **Seção de inativos com régua de tempo**

Uma área dedicada mostrando os inativos segmentados por tempo — 30 dias, 60 dias, 90 dias, 6 meses+. Quanto mais à direita na régua, menor a chance de recuperação. Isso ajuda a priorizar para quem mandar campanha de reengajamento.

![[Pasted image 20260219111910.png]]
##### **Seção de exclusões com motivo**

Se no momento de apagar a conta você perguntar o motivo (preço, concorrente, falta de uso, etc.), essa seção agrega essas respostas. É um dado qualitativo que explica o churn voluntário e alimenta decisões de produto.

Coloca a data com o motivo.

[[Após Sincronizações]]

##### Anotações
colocar cores que indicao quais sao cada elemento do grafico la nos ativos e inativos

transformar o grafico de users inativos para card

transformar cada reclamação para um card

colocar sombras nor cards

depois fazer com que o site seja adaptativo a telas pequenas, medias e grandes

fazer isso com o limpar
ver como fazer os accordions adicionarem ou atualizarem 

fazer um adicionar em algum lugar

px-md-4 ver oq é isso