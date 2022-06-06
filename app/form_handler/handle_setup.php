<?php 

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/setup/create_tables.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/setup/create_initial_categories.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
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
  <?php

  if (isset($_POST['usuario']) && $_POST['usuario'] != '' && $_POST['usuario'] != null  && isset($_POST['senha']) && $_POST['senha'] != '' && $_POST['senha'] != null && isset($_POST['cod_autorizacao']) && $_POST['cod_autorizacao'] != '' && $_POST['cod_autorizacao'] != null) : 

    $login = $_POST['usuario'];
    $senha = MD5($_POST['senha']);
    $cod_autorizacao = MD5($_POST['cod_autorizacao']);

    create_tables($bdConexao);

    if (isset($_POST['preConfigurarCats']) && $_POST['preConfigurarCats'] == true) {
      $preConfigurarCats = true;
    } else {
      $preConfigurarCats = false;
    }

    create_initial_categories($bdConexao, $preConfigurarCats);

  $bdCadastrarAdministrador = "INSERT INTO usuarios (login,senha,administrador,codigo_autorizacao) VALUES ('$login','$senha',1,'$cod_autorizacao')";

  $bdCadastrar = mysqli_query($bdConexao, $bdCadastrarAdministrador);

  if ($bdCadastrar) : ?>

    <script language='javascript' type='text/javascript'>
      Swal.fire({
        title: 'Configuração concluída!',
        text: 'Faça login para começar a utilizar o Contta',
        icon: 'success',
        confirmButtonText: 'Começar',
        didClose: function() {
          window.location.href = '/';
        }
      });
    </script>

  <?php else : ?>

    <script language='javascript' type='text/javascript'>
      Swal.fire({
        title: 'Não foi possível cadastrar o usuário e concluir a instalação',
        text: 'Por favor, tente novamente. Recomendamos apagar todas as tabelas e iniciar a configuração do zero.',
        icon: 'error',
        confirmButtonText: 'Começar novamente',
        didClose: function() {
          window.location.href = '/app/setup/setup.php';
        }
      });
    </script>

  <?php endif; ?>

  <?php else : ?>

    <script language='javascript' type='text/javascript'>
      Swal.fire({
        title: 'Informe todos os campos',
        text: 'Para configurar a conta de administrador e concluir a instalação, você deve criar um nome de usuário, uma senha e um código de autorização.',
        icon: 'error',
        confirmButtonText: 'Tentar novamente',
        didClose: function() {
          window.location.href = 'setup.php';
        }
      });
    </script>

  <?php die();
  endif; ?>
  
</body>
</html>