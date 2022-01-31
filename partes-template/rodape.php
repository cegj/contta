    <div class="rodape">
      <?php   if(isset($login_cookie)) {
      
      echo "<p>Usuário: {$login_cookie}</p>";

      }
      ?>
      <nav class="menu-secundario">
        <ul>
        <li><a href="#">Sobre & Privacidade*</a></li>
          <li><a href="#">Gerenciar usuários*</a></li>
          <li><a href="?sair=true">Sair</a></li>
        </ul>
      </nav>
      <p>Criado por <a href="https://github.com/cegj" target="_blank">Kadu Gaspar</a>.</p>
    </div>

    <script src="/geral/geral.js"></script>