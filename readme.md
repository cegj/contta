#ControleSimples

# ControleSimples (beta)

![ControleSimples em uso](https://i.imgur.com/QYx8Jsd.gif)

## O que é?

Aplicativo web self-hosted (hospedado pelo próprio usuário) para gerenciamento de finanças pessoais.

## Tecnologias utilizadas

- PHP;
- HTML;
- CSS;
- Javascript.

---

## Para quem é?

O ControleSimples foi desenvolvido, primeiramente, pensando em **privacidade**: o objetivo é permitir um controle financeiro fácil sem precisar hospedar suas informações financeiras (que são altamente sensíveis) em bancos de dados de terceiros. Além disso, o ControleSimples oferece um controle de finanças pessoais pela web e sem depender de planilhas de Excel e Google Docs.

---

## Como funciona?

Como o nome sugere, o aplicativo tem como objetivo oferecer uma solução simplificada. Assim, o ControleSimples se baseia no seguinte:

- Transações: são os registros de despesas, receitas e transferências do usuário, realizados manualmente.

- Painel: área onde são exibidas informações sobre as transações registradas no aplicativo, de forma consolidada. No momento, exibe apenas a última transação registrada (planeja-se incluir outras informações relevantes, como gráficos de entradas e saídas).

- Extrato: visualização de todos os registros efetuados em determinado mês, incluindo o resultado diário, mensal e acumulado.

- Orçamento: permite informar um valor estipulado para cada categoria em cada mês do ano e acompanhar, a partir dos registros efetuados, os gastos efetivamente realizados (e a diferença entre o previsto e o realizado).

- Categorias: lista de categorias (ex.: automóvel, lazer, moradia etc) e subcategorias (gasolina, cinema, aluguel etc) às quais as transações devem ser associadas.

- Contas: lista de contas nas quais as despesas, receitas e transferências são registradas. Na concepção, são as contas bancárias (Banco do Brasil, Itaú etc), a carteira, os cartões de crédito etc - mas o usuário pode organizar como quiser.

Por enquanto, é isso!

O ControleSimples tem interface responsiva em celulares. Porém, o seu uso é melhor em telas grandes.

---

## Instalação

Para instalar, é necessário:

1. Um servidor web com suporte a PHP; e
2. Um servidor de banco de dados MySQL ou MariaDB.

Obs.: para a segurança das suas informações, recomendo FORTEMENTE que a hospedagem ofereça tráfego de informações via HTTPS com SSL. O [Let's Encrypte](https://letsencrypt.org/) oferece certificados SSL gratuitos, procure o suporte da sua hospedagem para saber como instalar.

Então, o passo a passo para realizar a instalação é o seguinte:

1. Baixar uma cópia do projeto a partir do GitHub;

1. Criar um banco de dados MySQL/MariaDB no servidor de banco de dados - mas não crie nenhuma tabela, isso será feito automaticamente durante a configuração;

1. Editar, com um editor de texto comum na sua máquina local, o arquivo _bd.php_, para incluir as seguintes informações:

- **$bdServidor** = _o endereço do servidor do banco de dados_;
- **$bdUsuario** = _o nome de usuário no servidor do banco de dados_;
- **$bdSenha** = _a senha do usuário no servidor do banco de dados_;
- **$bdBanco** = _o nome do banco de dados criado no servidor_;

Atenção: todas as informações acima devem estar entre aspas simples '' e são fornecidas pelo seu servidor de banco de dados.

3. Subir todos os arquivos para o seu servidor web com suporte a PHP. Em caso de dúvidas, consulte o suporte da sua hospedagem.

4. Após subir todos os arquivos, faça o primeiro acesso no domínio contratado junto ao seu servidor (ex.: www.seunome.com.br). O ControleSimples identificará que se trata de uma nova instalação e iniciará uma rápida configuração inicial.

5. Pronto!

Caso prefira, você pode instalar o ControleSimples em um servidor web local como o XAMPP/LAMPP. Nesse caso, você acessará a aplicação somente no computador em que o servidor foi instalado e deve criar uma rotina de backup do seu banco de dados.

---

## Funções planejadas

O ControleSimples é um projeto em desenvolvimento. Dentro da perspectiva de manter a gestão financeira familiar de forma simplificada, sem excessos de opções e recursos desnecessários, planejamos, para o futuro, algumas funções como:

- Painel de visualização de informações com gráficos e estatísticas gerais;
- Gestão de cartões de crédito de forma dedicada;
- Melhoria na gestão de usuários;
- Outros ajustes menores, como: implementação de tema dark, melhorias gerais de design/layout e edição de contas de origem e destino nas transferências.

## IMPORTANTE

O ControleSimples é um projeto de um desenvolvedor iniciante. Isso significa que alguns comportamentos inesperados podem ocorrer. Embora eu já o utilize como meu único gestor de finanças pessoais, recomendo utilizá-lo em paralelo ao seu gestor de finanças atual nos primeiros meses para assegurar que ele atenderá às suas necessidades.
