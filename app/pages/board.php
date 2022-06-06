<?php

include_once($_SERVER["DOCUMENT_ROOT"] . './app/function/transaction/get_transactions.php');
include_once($_SERVER["DOCUMENT_ROOT"] . './app/function/utils/translate_date_to_br.php');
include_once($_SERVER["DOCUMENT_ROOT"] . './app/function/utils/format_value.php');

?>

<main class="container-principal">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>

  <div class="container duas-colunas sem-bg">

    <div class="box informacoes">
      
      <?php $buscaUltimoRegistro = get_transactions($bdConexao, null, $mes, $ano, false, true);

      if ($buscaUltimoRegistro != null) :

        foreach ($buscaUltimoRegistro as $registro) {
          $ultimoregistro = $registro;
        }
      ?>
        <h2 class="titulo-box ultimo">Último registro efetuado</h2>
        <dl>
          <dt>📝 Descrição:</dt>
          <dd><?php echo $ultimoregistro['descricao'] ?></dd>
        </dl>
        <dl>
          <dt>📅 Data:</dt>
          <dd><?php echo translate_date_to_br($ultimoregistro['data']) ?></dd>
        </dl>
        <dl>
          <dt>💵 Valor:</dt>
          <dd>R$ <span data-money><?php echo format_value($ultimoregistro['valor']) ?></span></dd>
        </dl>
        <dl>
          <dt>🏷️ Categoria:</dt>
          <dd><?php echo $ultimoregistro['nome_cat'] ?></dd>
        </dl>
        <dl>
          <dt>🏦 Conta:</dt>
          <dd><?php echo $ultimoregistro['conta'] ?></dd>
        </dl>
      <?php else : ?>
        <p>Não há registros cadastrados no mês.</p>
      <?php endif; ?>
    </div>

</main>