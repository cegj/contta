<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php'); 
      include ($_SERVER["DOCUMENT_ROOT"].'/setup/funcoes_setup.php');
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/setup/login-cadastro-setup.css">
  <script src="/plugin/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>

<body>
<?php

if (nao_existem_tabelas($bdConexao)) :

?>


<!-- Cabeçalho (barra superior) -->
<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/header.php') ?>

    <main class="main-cadastro">
    <div class="box login">
      <p class="text-apresentacao"><strong>Configurar usuário administrador</strong><br/>
      Antes de começar, precisamos fazer uma rápida configuração inicial, que consiste na criação do seu nome de usuário, senha e código de autorização para o cadastro posterior de novos usuários.</p>
      <form method="POST" action="setup_validar.php">
        <label>Usuário:</label><input type="text" name="usuario" id="usuario">
        <label>Senha:</label><input type="password" name="senha" id="senha">
        <label>Código de autorização:</label><input type="password" name="cod_autorizacao" id="cod_autorizacao">
        <div class='div-checkbox input-lista-padrao-categorias'>
          <input type='checkbox' name='preConfigurarCats' id="preConfigurarCats" value='true'>
          <label for='preConfigurarCats'>Pré-configurar lista de categorias <a href="">(entenda)</a></label>
        </div>
        <div class="container-botao-entrar">
        <input class="botao-acao-principal entrar" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
        </div>
      </form>
    </div>
    <div class="info-box">
      <p>Para que outras pessoas possam criar uma conta no seu ControleSimples e efetuar registros e consultas, você deve fornecer a elas o <b>código de autorização</b> que será criado agora. Guarde esse código com cuidado, pois qualquer pessoa que tenha acesso a ele poderá criar uma conta e visualizar as suas informações.</p>
    </div>
</main>
  

<?php else : ?>

  <script language='javascript' type='text/javascript'>
  Swal.fire({
    title: 'Não foi possível iniciar a configuração inicial',
    text: 'Já existem tabelas no Banco de Dados. Para realizar uma nova instalação, apague todas as tabelas existentes.',
    icon: 'error',
    confirmButtonText: 'Sair',
    didClose: function(){
      window.location.href='/index.php';
      }
  });
  </script>

<?php die();
endif;
?>

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