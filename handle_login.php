<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');
include($_SERVER["DOCUMENT_ROOT"] . '/setup/funcoes_setup.php');
?>

<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/setup/login-cadastro-setup.css">
  <script src="/plugin/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
</head>

<body>

  <?php

  $login = $_POST['login'];
  $entrar = $_POST['entrar'];
  $senha = md5($_POST['senha']);

  if (isset($entrar)) {

    $verifica = mysqli_query($bdConexao, "SELECT * FROM usuarios WHERE login =
  '$login' AND senha = '$senha'") or die("erro ao selecionar");
    if (mysqli_num_rows($verifica) <= 0) : ?>

      <script language='javascript' type='text/javascript'>
        Swal.fire({
          title: 'Nome de usuário ou senha inválidos',
          icon: 'error',
          confirmButtonText: 'Tentar novamente',
          didClose: function() {
            window.location.href = '/login.php';
          }
        });
      </script>

  <?php die();

    else :

      setcookie("login", $login);
      header("Location:index.html");

    endif;
  }
  ?>

</body>

</html>