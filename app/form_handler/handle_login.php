<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');

$login = $_POST['login'];
$senha = md5($_POST['senha']);

$verifica = mysqli_query($bdConexao, "SELECT * FROM usuarios WHERE login =
  '$login' AND senha = '$senha'") or die("erro ao selecionar");

if (mysqli_num_rows($verifica) <= 0) {
  header("Location: /?p=login&&e=loginerror");
} else {
  session_start();
  $_SESSION['username'] = $login;
  header("Location: /index.html");
}

?>

<!-- <script language='javascript' type='text/javascript'>
  Swal.fire({
    title: 'Nome de usuário ou senha inválidos',
    icon: 'error',
    confirmButtonText: 'Tentar novamente',
    didClose: function() {
      window.location.href = '/login.php';
    }
  });
</script> -->