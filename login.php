<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/setup/login-cadastro-setup.css">
</head>

<body>
  <!-- Cabeçalho -->
  <header>
    <?php include('partes-template/cabecalho.php') ?>
  </header>
  <main class="main-login">
    <div class="caixa login">
      <form method="POST" action="login_valida.php">
        <label>Usuário:</label><input type="text" name="login" id="login"><br>
        <label>Senha:</label><input type="password" name="senha" id="senha"><br>
        <div class="container-botao-entrar">
          <input class="botao-entrar" type="submit" value="Entrar" id="entrar" name="entrar"><br>
        </div>
        <p class="text-cadastro"><a href="/cadastro.php">Tem um código de autorização? Cadastre-se.</a></p>
      </form>
    </div>
  </main>
</body>

</html>