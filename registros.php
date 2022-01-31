<?php //Valida se o usuário está logado
  if(isset($login_cookie)) : ?>

<?php //Caso o usuário não esteja logado, exibe o conteúdo abaixo em vez da página. 
     else : 
      echo "
      <div class='alerta-necessidade-login'>
      <p>Para continuar, é necessário fazer login.</p>
      </div>
      ";
      include 'login.php';
      ?>  
  <?php endif ?>