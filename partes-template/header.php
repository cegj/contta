<?php if (isset($login_cookie)) : ?>
  <header id="header">

    <img class="logo" height="70px" src="/img/contta.png" alt="Contta" />
    <nav aria-label="menu-principal">
      <ul class="menu-principal">
        <li><a class="botao-menu-principal" href="?p=index">Painel</a></li>
        <li><a class="botao-menu-principal" href="?p=statement">Extrato</a></li>
        <li><a class="botao-menu-principal" href="?p=budget">Orçamento</a></li>
        <li><a class="botao-menu-principal" href="?p=category">Categorias</a></li>
        <li><a class="botao-menu-principal" href="?p=account">Contas</a></li>
      </ul>
    </nav>
  </header>

<?php else : ?>

  <header class="nao-logado">

    <img class="logo" height="70px" src="/img/contta.png" alt="Contta" />

  </header>

<?php endif; ?>