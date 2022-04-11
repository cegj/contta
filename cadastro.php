<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/setup/login-cadastro-setup.css">
</head>


<body>p
  <!-- Cabeçalho (barra superior) -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/header.php') ?>

  <main class="main-cadastro">
    <div class="box login">
      <form method="POST" action="cadastro_valida.php">
        <label>Usuário:</label><input type="text" name="login" id="login">
        <label>Senha:</label><input type="password" name="senha" id="senha">
        <label>Código de autorização:</label><input type="password" name="cod_autorizacao" id="cod_autorizacao">
        <div class="container-botao-entrar">
          <input class="botao-acao-principal entrar" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
        </div>
        <p class="text-cadastro"><a href="/login.php">Já tem um cadastro? Faça login.</a></p>
      </form>
    </div>
    <div class="info-box">
      <p>O Contta é uma aplicação de uso pessoal. Por isso, para cadastrar-se, é necessário ter um <strong>código de autorização</strong>, que é fornecido pelo administrador do sistema. Caso você queira usar o Contta para administrar suas finanças, faça a sua própria instalação. <a href="https://github.com/cegj/Contta/">Clique aqui para mais informações.</a></p>
    </div>
</body>

</html>