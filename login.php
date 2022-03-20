<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/setup/login-cadastro-setup.css">
</head>

<body>

  <!-- Cabeçalho (barra superior) -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/header.php') ?>

  <main class="main-login">
    <div class="box login">
      <form method="POST" action="handle_login.php">
        <label>Usuário:</label><input type="text" name="login" id="login">
        <label>Senha:</label><input type="password" name="senha" id="senha">
        <div class="container-botao-entrar">
          <input class="botao-acao-principal entrar" type="submit" value="Entrar" id="entrar" name="entrar"><br>
        </div>
        <p class="text-cadastro"><a href="/cadastro.php">Tem um código de autorização? Cadastre-se.</a></p>
      </form>
    </div>
  </main>
</body>

</html>