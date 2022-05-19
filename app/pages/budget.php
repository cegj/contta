<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/update_budget_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/get_budget.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/sum_budget_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/check_selected_month_budget.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_secondary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/format_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/database/there_is_no_table.php');

$edicao = false;

?>

<!-- <script>
  if (screen.width < 640) {
    window.location.href = '/orcamento-m.php';
  }
</script> -->

<main class="container-principal">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>

  <?php

  if (isset($_POST['campo-categoria']) && isset($_POST['campo-mes']) && isset($_POST['campo-valor'])) {
    $catEmEdicao = $_POST['campo-categoria'];
    $mesEmEdicao = $_POST['campo-mes'];
    $novoValor = $_POST['campo-valor'];

    update_budget_value($bdConexao, $catEmEdicao, $mesEmEdicao, $novoValor);
  }

  $months = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];

  // Build table header for each month
  $tableMonthsTitle = "";
  foreach($months as $month){
    $tableMonthsTitle = $tableMonthsTitle . "<th colspan='2'>{$month}</th>";
  }

  $tablePlanExecTitle = "";
  foreach($months as $month){
    $tablePlanExecTitle = $tablePlanExecTitle . "<th>Prev.</th><th>Exec.</th>";
  }

  //Get categories and build html for each of them

  $primaryCategories = get_primary_categories($bdConexao);

  $budgetLines = "";

  foreach ($primaryCategories as $primaryCategory){

    $budgetData = get_budget($bdConexao, $primaryCategory['nome_cat']);

    foreach ($budgetData as $data){

      $budgetLines .= "<tr>";

      //Define datasets
      $dataSets = "";
      $dataSets .= "data-cat-id='{$data['id_cat']}'";
      if ($data['eh_cat_principal']){
        $dataSets .= "data-primary-cat='true'";
      }

      //Create cell (td) elements
      ////Category name
      $budgetLines .= "<td data-type='cat-name' data-fixed-column='first' $dataSets>
                        {$data['nome_cat']}
                      </td>";

      ////Category result
      $budgetLines .= "<td data-type='cat-result' data-fixed-column='second' $dataSets>
                      </td>";

      foreach ($months as $month){

        $monthYear = $ano . "_" . $month;

        $monthDataSets = "";

        $monthDataSets .= "data-month='{$monthYear}'";
        if (check_selected_month_budget($month, $mes)){
          $monthDataSets .= "data-selected='true'";
        }

        ////Planned value
        $budgetLines .= "<td data-type='plan' $dataSets $monthDataSets>
                          {$data[$monthYear]}
                        </td>";

        ////Executed value
        $monthCatBalance = calculate_result($bdConexao, $month, $ano, 'SSM', null, $data['id_cat']);
        $budgetLines .= "<td data-type='exec' $dataSets $monthDataSets>
                          {$monthCatBalance}
                        </td>";
      }

      $budgetLines .= "</tr>";

    }

  }

  ////Month result
  $budgetLines .= "<tr>";
  $budgetLines .= "<td data-fixed-column='first'>Resultado mês:</td>";
  $budgetLines .= "<td data-fixed-column='second'>R$ 0,00</td>";

  foreach ($months as $month){

    $monthYear = $ano . "_" . $month;
  
    //Planned month result (sum)
    $budgetLines .= "<td>" . sum_budget_value($bdConexao, $monthYear) . "</td>";
    
    //Executed month result (sum)
    $budgetLines .= "<td>" . calculate_result($bdConexao, $month, $ano, 'SSM') . "</td>";

  }

  $budgetLines .= "</tr>";  

  ////Acumulated result
  $budgetLines .= "<tr>";
  $budgetLines .= "<td data-fixed-column='first'>Resultado acumulado:</td>";
  $budgetLines .= "<td data-fixed-column='second'>R$ 0,00</td>";

  foreach ($months as $month){

    $monthYear = $ano . "_" . $month;
  
    //Planned month result (sum) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!IT'S NEEDED TO ACUMULATE!!!!!!!!!!!!!!!!!!!!!!
    $budgetLines .= "<td>" . sum_budget_value($bdConexao, $monthYear) . "</td>";
    
    //Executed month result (sum)
    $budgetLines .= "<td>" . calculate_result($bdConexao, $month, $ano, 'SAM') . "</td>";

  }

  $budgetLines .= "</tr>";  



  ?>

  <style>
    .table-container {
      max-width: 100%;
      overflow: auto;
    }

    .tabela {
      display: block;
      width: 100%;
      height: 100%;
    }
  </style>

<!-- EDITING BUDGET MODAL -->
<div class="box formulario" id="container-alteracao-orcamento">
    <div class="container-form-botoes">
      <form style="display:none" class="form-alteracao-orcamento" id="form-alteracao" method="POST">
        <input style='display: none' type="number" id="campo-categoria" name="campo-categoria" readonly />
        <input style='display: none' type="text" id="campo-mes" name="campo-mes" readonly />
        <input style='display: none' type="text" id="campo-valor-executado" readonly />
        <img src="/assets/img/ico/edit.svg" class="icone-editar" alt="Editar">
        <label for="valor">Alterar o valor de <span id="nome-cat-label"></span> no mês de <span id=mes-label></span>:</label>
        <input type="number" step="any" id="campo-valor" name="campo-valor" />
        <button class="botao-acao-secundario confirmar" type="submit">Alterar</button>
      </form>
      <button onclick="copiarValorExecutado()" class="botao-acao-secundario neutro" id="botao-copiar">Copiar executado</button>
      <button onclick="fecharEdicao()" class="botao-acao-secundario cancelar" id="botao-cancelar" style="display:none">Cancelar</button>
    </div>
    <p><strong>Importante:</strong> a previsão de despesas deve ser informada em valores negativos.</p>
  </div>

  <div class="container uma-coluna">
    <h2 class="titulo-container">Orçamento</h2>
    <div class="table-container">
      <table id="budget-table" class="tabela orcamento">
        <thead>
          <tr>
            <th rowspan="2" data-fixed-column='first' class="titulo-coluna-categoria filtrar-titulo">Categoria</th>
            <th rowspan="2" data-fixed-column='second' class="titulo-coluna-resultado">Resultado</th>
            <?php echo $tableMonthsTitle; ?>
          </tr>
          <tr>
            <?php echo $tablePlanExecTitle; ?>
          </tr>
        </thead>
        <tbody>
            <?php echo $budgetLines; ?>
        </tbody>
      </table>
    </div>
  </div>

</main>