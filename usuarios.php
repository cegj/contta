<?php include('partes-template/includesiniciais.php');


if (isset($_GET['editar']) && $_GET['editar'] == true) {
  $edicao = true;

  $id_usuario = $_GET['id'];

  $usuario_especifico = buscar_usuario_especifico($bdConexao, $id_usuario);

    $usuario_edicao_nome = $usuario_especifico['login'];
    $usuario_edicao_administrador = $usuario_especifico['administrador'];

  } else {
  $edicao = false;

  $usuario_edicao_nome = "";
  $usuario_edicao_administrador = "";
}

?>

<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/usuarios/usuarios.css">
</head>

<body>

  <?php //Valida se o usuário está logado
  if (isset($login_cookie)) : ?>

    <!-- Cabeçalho -->
    <header>
      <?php include('partes-template/cabecalho.php') ?>
            <!-- Menu principal -->
            <?php include('partes-template/menu.php') ?>
    </header>

    <div class="container-form-mes-ano">
        <!-- Formulário de definição de mês e ano -->
        <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/form_mes_ano.php'); ?>
      </div>

    <main class="container-principal categorias-container">

    <?php if (tabela_nao_esta_vazia($bdConexao, 'usuarios')) : ?>

        <div class="caixa categorias-cadastradas">
          <h2 class="inline-block">Usuários</h2><span class="botao-ver-ocultar">Ver / ocultar</span>
          <div class="container-tabela">
          <table class="tabela categorias-cadastradas" id="tabela-categorias-cadastradas">
            <tr>
              <th class="linha-fixa">Usuário</th>
              <th class="linha-fixa">Administrador</th>
              <th class="linha-fixa">Editar</th>
            </tr>
              <?php

                $usuarios = buscar_usuarios($bdConexao);

                foreach ($usuarios as $usuario) :

                  $nomeUsuario = $usuario['login'];
                  $ehAdministrador = traduz_boolean($usuario['administrador'], 'Sim', 'Não');

                echo "
                <tr>
                  <td class='centralizar-texto'>{$nomeUsuario}</td>
                  <td class='centralizar-texto'>{$ehAdministrador}</td>
                  <td class='centralizar-texto'><a href='usuarios.php?id={$usuario['ID']}&editar=true#form-categoria'><img class='icone-editar' alt='Editar' src='/img/icos/editar.svg'/></a>
                </tr>
          ";
                endforeach;

              ?>
          </table>
          </div>
        <?php else : ?>

          <p>Não há usuários cadastrados</p>

        <?php endif; ?>
      </div>

      <div class="caixa cadastrar-categorias">
      <?php if ($edicao == true) : ?>
          <h2 class="titulo editar com-subtitulo">Editar usuário</h2>
          <h3><?php echo $usuario_edicao_nome; ?></h3>
        <!-- Formulário -->
        <?php include('usuarios/formulario_usuarios.php') ?>
      <?php else : ?>
      
      <p>Para cadastrar um novo usuário, <a href="/cadastro.php">clique aqui.</a></p>
        
      <?php endif; ?>
      </div>

    </main>
    <!-- Rodapé -->
    <footer>
      <?php include('partes-template/rodape.php') ?>
    </footer>

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

  <script src="/categorias/categorias.js" defer></script>

</body>

<script type="text/javascript">
  //Pinta o valor conforme o tipo de transação no extrato

  var extratoTipo = document.getElementsByClassName('linha-extrato-tipo');
  var extratoValor = document.getElementsByClassName('linha-extrato-valor');

  for (var i = 0; i < extratoTipo.length; i++) {
    if (extratoTipo[i].innerText == "D") {
      extratoValor[i].style.color = "#890000";
    } else if (extratoTipo[i].innerText == "R") {
      extratoValor[i].style.color = "#184f00";
    } else if (extratoTipo[i].innerText == "T") {
      extratoValor[i].style.color = "#002e4f";
    }
  }
</script>

</html>