<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/transaction/get_transactions.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/translate_date_to_br.php');

?>

<main class="container-principal" data-page-name="Painel">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>

  <div class="container duas-colunas sem-bg container-board">
    <div id="chartsContainer">
      <div id="yearlyChartContainer" class="box informacoes">
        <h2 class="titulo-box grafico">Histórico anual</h2>
        <form id="chart-form">
          <div>
            <label for="">Categorias:</label>
            <select id="catSelect">
              <option value="false">Nenhuma</option>
            </select>
          </div>
          <div>
            <label for="">Contas:</label>
            <select id="accountSelect">
              <option value="false">Nenhuma</option>
            </select>
          </div>
          <div>
            <button id="cleanChartBtn">Limpar</button>
          </div>
        </form>
        <div id="yearlyChart"></div>
      </div>
      <div id="monthlyChartContainer" class="box informacoes">
        <h2 class="titulo-box grafico">Categorias no mês</h2>
        <div id="categoriesChart"></div>
      </div>
    </div>

    <div id="lastTransactionContainer" class="box informacoes">
      
      <?php $buscaUltimoRegistro = get_transactions($bdConexao, null, $mes, $ano, false, true);

      if ($buscaUltimoRegistro != null) :

        foreach ($buscaUltimoRegistro as $registro) {
          $ultimoregistro = $registro;
        }
      ?>
        <h2 class="titulo-box ultimo">Último registro</h2>
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
          <dd><span id="lastTransactionValue" data-showhide><?php echo $ultimoregistro['valor'] ?></span></dd>
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