<?php

include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/unlogged-header.php');

?>

<main class="main-login">
  <div class="box login">
    <form method="POST" action="/app/form_handler/handle_login.php">
      <label>Usuário:</label><input type="text" name="login" id="login">
      <label>Senha:</label><input type="password" name="senha" id="senha">
      <div class="container-botao-entrar">
        <input class="botao-acao-principal entrar" type="submit" value="Entrar" id="entrar" name="entrar"><br>
      </div>
      <p class="text-cadastro"><a href="/app/setup/signup.php">Tem um código de autorização? Cadastre-se.</a></p>
    </form>
  </div>
</main>