<div align="center">
    <img src="https://camo.githubusercontent.com/043cf178670996a77ee676c08ffebc44661909c10e09c07a12a287cab3f8e548/68747470733a2f2f696d672e736869656c64732e696f2f7374617469632f76313f7374796c653d666f722d7468652d6261646765266d6573736167653d50485026636f6c6f723d373737424234266c6f676f3d504850266c6f676f436f6c6f723d464646464646266c6162656c3d" alt="PHP">
    <img src="https://camo.githubusercontent.com/539a184961e9ab46a914b3a57718cd52f9a122ffb33a0bcaaa92484add20ba72/68747470733a2f2f696d672e736869656c64732e696f2f7374617469632f76313f7374796c653d666f722d7468652d6261646765266d6573736167653d4d7953514c26636f6c6f723d343437394131266c6f676f3d4d7953514c266c6f676f436f6c6f723d464646464646266c6162656c3d" alt="MySQL">
    <img src="https://camo.githubusercontent.com/3aaee8bf7885dcf0cea8a5647c4514b7d800b1a730d38bce7dadf6bff883378d/68747470733a2f2f696d672e736869656c64732e696f2f7374617469632f76313f7374796c653d666f722d7468652d6261646765266d6573736167653d4a61766153637269707426636f6c6f723d323232323232266c6f676f3d4a617661536372697074266c6f676f436f6c6f723d463744463145266c6162656c3d" alt="Javascript">
    <img src="https://camo.githubusercontent.com/9fe0ddca8c80fd49703246ca3b9a894ddfdc9c1c80f6ab5de92bbe91471dbab8/68747470733a2f2f696d672e736869656c64732e696f2f7374617469632f76313f7374796c653d666f722d7468652d6261646765266d6573736167653d4353533326636f6c6f723d313537324236266c6f676f3d43535333266c6f676f436f6c6f723d464646464646266c6162656c3d" alt="CSS">
    <img src="https://camo.githubusercontent.com/d2da7e7ec8424780720101d4853c64dffb81dc69dfdd25a0ce88cdb3848bbc6f/68747470733a2f2f696d672e736869656c64732e696f2f7374617469632f76313f7374796c653d666f722d7468652d6261646765266d6573736167653d48544d4c3526636f6c6f723d453334463236266c6f676f3d48544d4c35266c6f676f436f6c6f723d464646464646266c6162656c3d" alt="HTML">
</div>
    <img style="background-color: white; padding: 10px; border-radius: 4px;" src="https://i.imgur.com/k6izPqU.png" alt="Contta" height="50"/>
</p>

# Contta - Personal finance management / Gestão de finanças pessoais 
Created for learning purposes / Criado para fins de aprendizado.

<div align="center">
    <img src="https://i.imgur.com/IR0TQpK.png" title="Board / Painel" alt="" width="70%">
    <p style="font-size: 0.9rem">Board / Painel</p>
    <img src="https://i.imgur.com/CBUWca3.png" title="Transaction form / Cadastro de transação" alt="" width="70%">
    <p style="font-size: 0.9rem">Transaction form / Cadastro de transação</p>
    <img src="https://i.imgur.com/PIYoKP9.png" title="Statement / Extrato" alt="" width="70%">
    <p style="font-size: 0.9rem">Statement / Extrato</p>
    <img src="https://i.imgur.com/x68XJWH.png" title="Budget / Orçamento" alt="" width="70%">
    <p style="font-size: 0.9rem">Budget table / Tabela de orçamento</p>
    <img src="https://i.imgur.com/MVfdqy6.png" title="Categories / Categorias" alt="" width="70%">
    <p style="font-size: 0.9rem">Categories / Categorias</p>
    <img src="https://i.imgur.com/qDEf11l.png" title="Accounts / Contas" alt="" width="70%">
    <p style="font-size: 0.9rem">Accounts / Contas</p>
    <img src="https://i.imgur.com/jGRnwDs.png" title="Account config / Configuração de contas" alt="" width="70%">
    <p style="font-size: 0.9rem">Accounts config / Configuração de contas</p>
    <img src="https://i.imgur.com/j2RB64j.png" title="Login / Entrar" alt="" width="70%">
    <p style="font-size: 0.9rem">Login</p>

</div>

---

[ ENGLISH ]

## What is it?

Self-hosted web app for personal finance management.

**Contta is only available in brazilian portuguese by now.**

## Stack

- PHP;
- SQL;
- Javascript;
- CSS;
- HTML.

## For whom is it?

Contta is developed having **privacy** in mind: the goal is to provide an easy personal finance control without hosting your bank information (which is highly sensitive) em third parties databases. In addiction, Contta offers a family budget management over the web, without needing Excel or Google spreadsheets.

## How does it work?

The purpose of the app is to offer a simplified solution. So, Contta is based on:

- Transactions: the registry of incomes, expenses and money transfers made by the user, manually.

- Panel: area which consolidated information about the transactions are shown. At this moment, it shows only the last transaction registered, bot it's planned to include other relevant information such as incomes and expenses charts.

- Statement: table with all transactions of a setted month, including day's, month's and accumulated results.

- Budget: allow the user to set an expected money value for each category in each month and to follow, from the transactions registered, the difference between the planned and the established expense.

- Categories: list of categories (e.g. car, leisure, housing etc.) and subcategories (gas, movies, house rent etc.) to where transactions should be associated.

- Accounts: list of accounts to where expenses, incomes and transfers should be associated. In conception, they are bank accounts, wallets, credit cards, etc. - but users can organize that as they want.

That's all for now!

Contta has a responsive interface for mobile, but it works better at big screens.

## Setup

For the app setup, it's required:

- A web server with PHP support;
- A MySQL or MariaDB database server.

PS.: For your information's security, I STRONGLY recommend getting a host who offers traffic over HTTPS with SSL. [Let's Encrypt](https://letsencrypt.org/) provides free SSL certificates, so ask your host helpdesk how to install it.

So, the steps to install Contta are as follows:

1. Download a clone of the project from GitHub;

2. Create a MySQL/MariaDB database — but you shouldn't create any table, it will be done automatically during the setup;

3. Edit, with a text editor (such as Notepad), the _bd.php_ file to include the following information:

- **$bdServidor** = _the database server address_;
- **$bdUsuario** = _the database username_;
- **$bdSenha** = _the database password_;
- **$bdBanco** = _the database name_;

Pay attention: all above information should be between simple quotes '' and they are provided by your database server.

4. Upload all files to thw web server;

5. After uploading the files, access your domain (e.g. www.yourname.com). Contta will notice that's a new installation and will start a quick setup.

6. It's all done!

If you prefer, you can install Contta in a local server such as XAMPP/LAMPP but, in this case, you will access the application only in your computer, and we really recommend you to create a backup routine for the database in this case.

## Planned improvements

Contta is a project in development. So, in the perspective of keeping the family finance management simplified, without a lot of options and unnecessary features, we planned, to the future, some improvements:

- General statistics and charts at the panel;
- Dedicated credit card management feature;
- Improvements in users management;
- Minor adjustments, such as: dark theme, design/layout improvements and others.

## IMPORTANT

Contta is a project of a beginning developer. It means that some bugs can happen (and probably will happen). Although I already use it as my only one personal finance manager, I recommend you to test it before adopting as your primary solution. I don't offer any support to the users — use it by your own risk.

---

[ BRAZILIAN PORTUGUESE ]

## O que é?

Aplicativo web self-hosted para gerenciamento de finanças pessoais.

## Tecnologias

- PHP;
- SQL;
- Javascript;
- CSS;
- HTML.

## Para quem é?

O Contta é desenvolvido pensando em **privacidade**: o objetivo é permitir um controle financeiro fácil sem precisar hospedar suas informações bancárias (que são altamente sensíveis) em bancos de dados de terceiros. Além disso, Contta oferece um gerenciamento de orçamento familiar pela web e sem depender de planilhas de Excel e Google Docs.

## Como funciona?

O aplicativo tem como objetivo oferecer uma solução simplificada. Assim, Contta se baseia no seguinte:

- Transações: são os registros de despesas, receitas e transferências feitas pelo usuário manualmente.

- Painel: área onde são exibidas informações sobre as transações registradas no aplicativo, de forma consolidada. No momento, exibe apenas a última transação registrada (planeja-se incluir outras informações relevantes, como gráficos de entradas e saídas).

- Extrato: tabela com todos os registros de um determinado mês, incluindo o resultado diário, mensal e acumulado.

- Orçamento: permite definir um valor monetário para cada categoria em cada mês do ano e acompanhar, a partir dos registros efetuados, a diferença entre os gastos planejados e realizados.

- Categorias: lista de categorias (ex.: automóvel, lazer, moradia etc) e subcategorias (gasolina, cinema, aluguel etc) às quais as transações devem ser associadas.

- Contas: lista de contas nas quais as despesas, receitas e transferências devem ser registradas. Na concepção, são as contas bancárias, carteiras, os cartões de crédito etc. - mas o usuário pode organizar como quiser.

Por enquanto, é isso!

O Contta tem interface responsiva em celulares. Porém, o seu uso é melhor em telas grandes.

## Instalação

Para instalar, é necessário:

1. Um servidor web com suporte a PHP; e
2. Um servidor de banco de dados MySQL ou MariaDB.

Obs.: para a segurança das suas informações, recomendo FORTEMENTE que a hospedagem ofereça tráfego de informações via HTTPS com SSL. O [Let's Encrypte](https://letsencrypt.org/) oferece certificados SSL gratuitos, procure o suporte da sua hospedagem para saber como instalar.

Então, o passo a passo para realizar a instalação é o seguinte:

1. Baixar uma cópia do projeto a partir do GitHub;

2. Criar um banco de dados MySQL/MariaDB no servidor de banco de dados - mas não crie nenhuma tabela, isso será feito automaticamente durante a configuração;

3. Editar, com um editor de texto comum na sua máquina local, o arquivo _bd.php_, para incluir as seguintes informações:

- **$bdServidor** = _o endereço do servidor do banco de dados_;
- **$bdUsuario** = _o nome de usuário no servidor do banco de dados_;
- **$bdSenha** = _a senha do usuário no servidor do banco de dados_;
- **$bdBanco** = _o nome do banco de dados criado no servidor_;

Atenção: todas as informações acima devem estar entre aspas simples '' e são fornecidas pelo seu servidor de banco de dados.

4. Subir todos os arquivos para o seu servidor web com suporte a PHP. Em caso de dúvidas, consulte o suporte da sua hospedagem.

5. Após subir todos os arquivos, faça o primeiro acesso no domínio contratado junto ao seu servidor (ex.: www.seunome.com.br). O Contta identificará que se trata de uma nova instalação e iniciará uma rápida configuração inicial.

6. Pronto!

Caso prefira, você pode instalar o Contta em um servidor web local como o XAMPP/LAMPP. Nesse caso, você acessará a aplicação somente no computador em que o servidor foi instalado e deve criar uma rotina de backup do seu banco de dados.

## Funções planejadas

O Contta é um projeto em desenvolvimento. Dentro da perspectiva de manter a gestão financeira familiar de forma simplificada, sem excessos de opções e recursos desnecessários, planejamos, para o futuro, algumas funções como:

- Painel de visualização de informações com gráficos e estatísticas gerais;
- Gestão de cartões de crédito de forma dedicada;
- Melhoria na gestão de usuários;
- Outros ajustes menores, como: implementação de tema dark, melhorias gerais de design/layout e edição de contas de origem e destino nas transferências.

## IMPORTANTE

Contta é um projeto de um desenvolvedor iniciante. Isso significa que alguns bugs podem ocorrer (e provavelmente ocorrerão). Embora eu já o utilize como meu único gerenciador de finanças pessoais, recomendo que você o teste antes de adotá-lo como sua solução principal. Eu não ofereço suporte ao usuários — use-o por sua conta e risco.
