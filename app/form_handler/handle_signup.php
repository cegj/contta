<?php 

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
      
?>

<html>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/style/style.css">
  <link rel="stylesheet" href="/assets/style/login-cadastro-setup.css">
  <script src="/plugin/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
  <title>Contta | Cadastro</title>
</head>
<body>

<?php

function busca_cod_autorizacao($bdConexao){
  $bdBuscar = "
  SELECT codigo_autorizacao
  FROM usuarios
  WHERE administrador = 1
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $cods_autorizacao[] = mysqli_fetch_assoc($resultado);

  return $cods_autorizacao;
}

$cods_autorizacao = busca_cod_autorizacao($bdConexao);

foreach ($cods_autorizacao as $cod){
  $cod_autorizacao = $cod;
}

if (isset($_POST['cod_autorizacao']) && MD5($_POST['cod_autorizacao']) == $cod_autorizacao['codigo_autorizacao']) {

$login = $_POST['login'];
$senha = MD5($_POST['senha']);
$query_select = "SELECT login FROM usuarios WHERE login = '$login'";
$select = mysqli_query($bdConexao, $query_select);
$array = mysqli_fetch_array($select);
if(isset($array['login'])){
$logarray = $array['login'];
} else {
  $logarray = "";
}

  if(strlen($login) == 00 || $login == null){
    echo"
    <script language='javascript' type='text/javascript'>
    Swal.fire({
      title: 'O nome de usuário deve ser preenchido',
      icon: 'error',
      confirmButtonText: 'Tentar novamente',
      didClose: function(){
        window.location.href='/app/setup/signup.php';
        }
    });
    </script>
    ";

    }else{
      if($logarray == $login){

        echo"
        <script language='javascript' type='text/javascript'>
        Swal.fire({
          title: 'O nome de usuário já existe',
          text: 'Escolha outro nome de usuário para realizar o cadastro ou, caso você já tenha um cadastro, faça login.',
          icon: 'error',
          confirmButtonText: 'Tentar novamente',
          didClose: function(){
            window.location.href='/app/setup/signup.php';
            }
        });
        </script>
        ";

        die();

      }else{

        //VALIDAÇÃO DA SENHA

        if (strlen($_POST['senha']) == 00 || $_POST['senha'] == null) {
          echo"
          <script language='javascript' type='text/javascript'>
          Swal.fire({
            title: 'Uma senha deve ser informada',
            text: 'Não é possível cadastrar um usuário sem senha',
            icon: 'error',
            confirmButtonText: 'Tentar novamente',
            didClose: function(){
              window.location.href='/app/setup/signup.php';
              }
          });
          </script>
          ";

          die();
        } else if (strlen($_POST['senha']) < 10) {
          echo"
          <script language='javascript' type='text/javascript'>
          Swal.fire({
            title: 'A senha é muito pequena',
            text: 'Para a sua segurança, informe uma senha de, pelo menos, dez caracteres',
            icon: 'error',
            confirmButtonText: 'Tentar novamente',
            didClose: function(){
              window.location.href='/app/setup/signup.php';
              }
          });
          </script>
          ";

          die();
        } else {


        $query = "INSERT INTO usuarios (login,senha,administrador,codigo_autorizacao) VALUES ('$login','$senha',0,'')";
        $insert = mysqli_query($bdConexao, $query);

        if($insert){

          echo"
          <script language='javascript' type='text/javascript'>
          Swal.fire({
            title: 'Usuário cadastrado com sucesso',
            text: 'Faça login para começar a utilizar o Contta',
            icon: 'success',
            confirmButtonText: 'Fazer login',
            didClose: function(){
              window.location.href='/';
              }
          });
          </script>
          ";  

        }else{

          echo"
          <script language='javascript' type='text/javascript'>
          Swal.fire({
            title: 'Não foi possível cadastrar este usuário',
            text: 'Por favor, tente novamente.',
            icon: 'error',
            confirmButtonText: 'Tentar novamente',
            didClose: function(){
              window.location.href='/app/setup/signup.php';
              }
          });
          </script>
          ";  
        }
      }
    }
  }
  } else {

    echo"
    <script language='javascript' type='text/javascript'>
    Swal.fire({
      title: 'Código de autorização inválido',
      text: 'Solicite o código de autorização ao administrador do sistema e tente novamente.',
      icon: 'error',
      confirmButtonText: 'Tentar novamente',
      didClose: function(){
        window.location.href='/app/setup/signup.php';
        }
    });
    </script>
    ";  
  }
?>

</body>
</html>