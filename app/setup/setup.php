<?php 

  include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/style/style.css">
  <link rel="stylesheet" href="/assets/style/login-cadastro-setup.css">
  <script src="/plugin/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <title>Contta | Configuração inicial</title>
</head>
<body>

<?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/unlogged-header.php'); ?>


<script language='javascript' type='text/javascript'>
            Swal.fire({
                imageUrl: '/assets/img/Contta_logo.png',
                imageWidth: 300,
                title: 'Seja bem vindo!',
                text: 'Para começar a utilizar o Contta, é necessário fazer uma rápida configuração inicial. Vamos começar?',
                // icon: 'info',
                confirmButtonText: 'Iniciar configuração'
            });
        </script>


    <main class="main-cadastro">
    <div class="box login">
      <p class="text-apresentacao"><strong>Configurar usuário administrador</strong><br/>
      Antes de começar, precisamos fazer uma rápida configuração inicial, que consiste na criação do seu nome de usuário, senha e código de autorização para o cadastro posterior de novos usuários.</p>
      <form method="POST" action="/app/form_handler/handle_setup.php">
        <label>Usuário:</label><input type="text" name="usuario" id="usuario">
        <label>Senha:</label><input type="password" name="senha" id="senha">
        <label>Código de autorização:</label><input type="password" name="cod_autorizacao" id="cod_autorizacao">
        <div class='div-checkbox input-lista-padrao-categorias'>
          <input type='checkbox' name='preConfigurarCats' id="preConfigurarCats" value='true'>
          <label for='preConfigurarCats'>Pré-configurar lista de categorias</label>
        </div>
        <div class="container-botao-entrar">
        <input class="botao-acao-principal entrar" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
        </div>
      </form>
    </div>
    <div class="info-box">
      <p>Para que outras pessoas possam criar uma conta e efetuar registros e consultas, você deve fornecer a elas o <b>código de autorização</b> que será criado agora. Guarde esse código com cuidado, pois qualquer pessoa que tenha acesso a ele poderá criar uma conta e visualizar as suas informações.</p>
    </div>
</main>
  
<script language='javascript' type='text/javascript'>

  botaoCadastrar = document.getElementById('cadastrar');

  botaoCadastrar.addEventListener('click', function(){

    Swal.fire({
    title: 'Configurando...',
    text: 'Não feche esta tela até a conclusão da configuração',
    icon: 'info',
    showConfirmButton: false,
  });

  });

</script>

</body>
</html>