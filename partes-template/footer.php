<footer id="footer">

  <div class="rodape">
      <?php   if(isset($login_cookie)) {
      
      echo "<p>Usuário: {$login_cookie}</p>";

      }
      ?>
      <nav class="menu-secundario">
        <ul>
          <li><a href="#header">Subir tudo</a></li>
          <li><a href="/usuarios.php">Gerenciar usuários</a></li>
          <li><a href="#">Documentação de ajuda</a></li>
          <li><a href="?sair=true">Sair</a></li>
        </ul>
      </nav>
      <p>Criado por <a href="https://github.com/cegj" target="_blank">Carlos Eduardo Gaspar Jr</a>.</p>
    </div>

    <script src="/geral/geral.js"></script>

</footer>