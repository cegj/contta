<div class="opcoes">

  <?php if (isset($mes) && $mes != "") : ?>
    <span class="mes-ano-selecionado"><?php echo ($mes . '/' . $ano) ?></span>
  <?php endif; ?>

  <a class="botao-opcoes botao-mes-ano" id="opcao-selecionar-mes-ano">Alterar mês/ano</a>

  <a class="botao-opcoes botao-novo" id="opcao-registrar-transacao">Registrar transação</a>

  <a class="botao-opcoes botao-final-pagina" href="#footer">Descer tudo</a>

  <!-- Opções de Extrato -->
  <?php if ($urlPath == '/extrato.php') :  ?>
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
  <?php if ($urlPath == '/categorias.php') :  ?>
    <?php if ($configuracao == false) : ?>
      <a class="botao-opcoes botao-configurar" href="?configurar=true">Configurar categorias</a>
    <?php else : ?>
      <a class="botao-opcoes botao-sair" href="/categorias.php">Sair das configurações</a>
    <?php endif; ?>
  <?php endif; ?>

  <!-- Opções de contas -->
  <?php if ($urlPath == '/contas.php') :  ?>
    <?php if ($configuracao == false) : ?>
      <a class="botao-opcoes botao-configurar" href="?configurar=true">Configurar contas</a>
    <?php else : ?>
      <a class="botao-opcoes botao-sair" href="/contas.php">Sair das configurações</a>
    <?php endif; ?>
  <?php endif; ?>

</div>

<!-- Formulário de mês e ano -->
<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/mes_ano.php'); ?>

<!-- Formulário de registrar transação -->

<div id="caixa-registrar-modal" class="box formulario box-opcoes hide" <?php if (filter_input(INPUT_GET, 'id_transacao', FILTER_VALIDATE_INT)) : ?> style="display: block !important" <?php endif; ?>>
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/extrato/formulario_registrar.php'); ?>

</div>
</div>