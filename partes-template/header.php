<?php if (isset($login_cookie)) : ?>
  <header id="header">

    <img class="logo" height="70px" src="/img/contta.png" alt="Contta" />
    <nav aria-label="menu-principal">
      <ul class="menu-principal">
        <li><a class="botao-menu-principal" href="/index.html">Painel</a></li>
        <li><a class="botao-menu-principal" href="/statement.html">Extrato</a></li>
        <li><a class="botao-menu-principal" href="/budget.html">Orçamento</a></li>
        <li><a class="botao-menu-principal" href="/category.html">Categorias</a></li>
        <li><a class="botao-menu-principal" href="/account.html">Contas</a></li>
      </ul>
    </nav>
  </header>

<?php else : ?>

  <header class="nao-logado">

    <img class="logo" height="70px" src="/img/contta.png" alt="Contta" />

  </header>

<?php endif; ?>