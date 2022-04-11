# Contta - Gestão de finanças pessoais

**_Beta_**

<p align="center">
    <img src="https://i.imgur.com/k6izPqU.png" alt="Contta" height="70"/>
    <img src="https://i.imgur.com/QYx8Jsd.gif" alt="Contta demo"/>
</p>

____________

[ ENGLISH ]

## What is it?

Self-hosted web app for personal finances management.

**Contta is only available in brazilian portuguese for now**

## Stack 

- PHP;
- SQL;
- Javascript;
- CSS;
- HTML.

## For whom is it?

Contta is developed having **privacy** in mind: the goal is to provide an easy personal finances control without hosting your bank information (which is highly sensitive) em third parties databases. In addiction, Contta offers a family budget management over the web, without needing Excel or Google spreadsheets.

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

Contta is a beginning developer project. It means that some bugs can happen. Although I already use it as my only one personal finance manager, I recommend you to test it before adopting as your primary solution. As a personal open source project, I don't offer any support to the users — use it by your own risk.

____________

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

- Orçamento: permite definir um valor monetário para cada categoria em cada mês do ano e acompanhar, a partir dos registros efetuados, a diferença entre os  gastos planejados e realizados.

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

O Contta é um projeto de um desenvolvedor iniciante. Isso significa que alguns comportamentos inesperados podem ocorrer. Embora eu já o utilize como meu único gestor de finanças pessoais, recomendo utilizá-lo em paralelo ao seu gestor de finanças atual nos primeiros meses para assegurar que ele atenderá às suas necessidades.
