<div class="opcoes">

  <?php if (isset($mes) && $mes != "") : ?>
    <span class="mes-ano-selecionado"><?php echo ($mes . '/' . $ano) ?></span>
  <?php endif; ?>

  <a class="botao-opcoes botao-mes-ano" id="selecionar-mes-ano">Alterar mês/ano</a>

  <?php if ($url != '/index.php') :  ?>
    <a class="botao-opcoes botao-novo" id="opcao-registrar-transacao">Registrar transação</a>
  <?php endif; ?>

  <a class="botao-opcoes botao-final-pagina" href="#footer">Descer tudo</a>

  <!-- Opções de Extrato -->
  <?php if ($url == '/extrato.php') :  ?>
    <?php if ($tudo == true) : ?>
      <a class="botao-opcoes botao-extrato-outlined" href="?">Ver extrato mensal</a>
    <?php else : ?>
      <a class="botao-opcoes botao-extrato" href="?tudo=true">Ver extrato completo</a>
    <?php endif; ?>

    <?php if ($tudo == true) : ?>
      <a class="botao-opcoes botao-exportar" href="/extrato/exportar.php" target="_blank">Exportar extrato completo</a>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Opções de categorias -->
  <?php if ($url == '/categorias.php') :  ?>
    <?php if ($configuracao == false) : ?>
      <a class="botao-opcoes botao-configurar" href="?configurar=true">Configurar categorias</a>
    <?php else : ?>
      <a class="botao-opcoes botao-sair" href="/categorias.php">Sair das configurações</a>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Opções de contas -->
  <?php if ($url == '/contas.php') :  ?>
    <?php if ($configuracao == false) : ?>
      <a class="botao-opcoes botao-configurar" href="?configurar=true">Configurar contas</a>
    <?php else : ?>
      <a class="botao-opcoes botao-sair" href="/contas.php">Sair das configurações</a>
    <?php endif; ?>
  <?php endif; ?>

</div>

<!-- Formulário de mês e ano -->
<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/mes_ano.php'); ?>

<!-- Formulário de registrar transação (modal) -->
<?php if ($url != '/index.php') :  ?>

  <div class="container-formulario-registrar-transacao-opcoes" id="janela-registrar-transacao" <?php if (filter_input(INPUT_GET, 'id_transacao', FILTER_VALIDATE_INT)) : ?> style="display: block !important" <?php endif; ?>>

    <div id="caixa-registrar-modal" class="box formulario oculto">
      <?php include($_SERVER["DOCUMENT_ROOT"] . '/extrato/formulario_registrar.php'); ?>
    </div>
  </div>

<?php endif; ?>

<script>
  // ABRIR E FECHAR O SELETOR DE MÊS E ANO AO CLICAR NO BOTÃO

  botaoAbrirRegistroTransacao = document.getElementById('opcao-registrar-transacao')
  janelaRegistroTransacao = document.getElementById('janela-registrar-transacao')

  botaoAbrirRegistroTransacao.addEventListener('click', function() {
    if (janelaRegistroTransacao.classList.contains('show')) {
      janelaRegistroTransacao.classList.remove('show');
      janelaRegistroTransacao.classList.add('hide');
      botaoAbrirRegistroTransacao.classList.remove('botao-sair');
      botaoAbrirRegistroTransacao.classList.add('botao-novo');
    } else {
      janelaRegistroTransacao.classList.add('show');
      janelaRegistroTransacao.classList.remove('hide');
      botaoAbrirRegistroTransacao.classList.remove('botao-novo');
      botaoAbrirRegistroTransacao.classList.add('botao-sair');
    }
  })

  janelaRegistroTransacao.addEventListener('animationend', function() {
    console.log("Disparou!")
    if (janelaRegistroTransacao.classList.contains('hide')) {
      console.log("Entrou no if!")
      janelaRegistroTransacao.style.display = "none";
    }
  });


  // FECHAR COM ESC

  document.querySelector('body').addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
      janelaRegistroTransacao.classList.remove('exibir');
      botaoAbrirRegistroTransacao.classList.remove('botao-sair');
      botaoAbrirRegistroTransacao.classList.add('botao-novo');
    }
  });
</script>