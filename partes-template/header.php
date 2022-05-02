<?php if (isset($login_cookie)) : ?>
  <header id="header">

    <img class="logo" height="70px" src="/img/contta.png" alt="Contta" />
    <nav aria-label="menu-principal">
      <ul class="menu-principal">
        <li><a class="botao-menu-principal" href="/index.php">Painel</a></li>
        <li><a class="botao-menu-principal" href="/extrato.php">Extrato</a></li>
        <li><a class="botao-menu-principal" href="/orcamento.php">Orçamento</a></li>
        <li><a class="botao-menu-principal" href="/categorias.php">Categorias</a></li>
        <li><a class="botao-menu-principal" href="/contas.php">Contas</a></li>
      </ul>
    </nav>
  </header>

<?php else : ?>

  <header class="nao-logado">

    <img class="logo" height="70px" src="/img/contta.png" alt="Contta" />

  </header>

<?php endif; ?>