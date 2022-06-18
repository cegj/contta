<!DOCTYPE html>
<html>

<!DOCTYPE html>
<html lang="pt-BT">
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
  <!-- Cabeçalho (barra superior) -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/unlogged-header.php'); ?>

  <main class="main-cadastro">
    <div class="box login">
      <form method="POST" action="/app/form_handler/handle_signup.php">
        <label>Usuário:</label><input type="text" name="login" id="login">
        <label>Senha:</label><input type="password" name="senha" id="senha">
        <label>Código de autorização:</label><input type="password" name="cod_autorizacao" id="cod_autorizacao">
        <div class="container-botao-entrar">
          <input class="botao-acao-principal entrar" type="submit" value="Cadastrar" id="cadastrar" name="cadastrar">
        </div>
        <p class="text-cadastro"><a href="/">Já tem um cadastro? Faça login.</a></p>
      </form>
    </div>
    <div class="info-box">
      <p>O Contta é uma aplicação de uso pessoal. Por isso, para cadastrar-se, é necessário ter um <strong>código de autorização</strong>, que é fornecido pelo administrador do sistema. Caso você queira usar o Contta para administrar suas finanças, faça a sua própria instalação. <a href="https://github.com/cegj/Contta/">Clique aqui para mais informações.</a></p>
    </div>
</body>

</html>