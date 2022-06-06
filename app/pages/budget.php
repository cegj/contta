<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/update_budget_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/get_budget.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/sum_budget_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/check_selected_month_budget.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_secondary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/format_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');

$months = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];

// Build table header for each month
$tableMonthsTitle = "";
foreach($months as $month){
  
  $tableMonthsTitle = $tableMonthsTitle . "<th data-type='month-title' colspan='2'>{$month}</th>";
}

$tablePlanExecTitle = "";
foreach($months as $month){
  $tablePlanExecTitle = $tablePlanExecTitle . "<th data-prev-exec-month='{$month}'>Prev.</th><th data-prev-exec-month='{$month}'>Exec.</th>";
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
    $dataSets .= "data-cat-name='{$data['nome_cat']}'";
    if ($data['eh_cat_principal']){
      $dataSets .= "data-primary-cat='true'";
    }

    //Create cell (td) elements
    ////Category name
    $budgetLines .= "<td data-type='cat-name' data-fixed-column='first' $dataSets>
                      {$data['nome_cat']}
                    </td>";

    ////Category result
    $budgetLines .= "<td data-money='' data-type='selected-result' data-fixed-column='second' $dataSets>
                    </td>";

    foreach ($months as $month){

      $monthYear = $ano . "_" . $month;

      $monthDataSets = "";

      $monthDataSets .= "data-month='{$monthYear}'";
      if (check_selected_month_budget($month, $mes)){
        $monthDataSets .= "data-selected='true'";
      } else {
        $monthDataSets .= "data-selected='false'";
      }

      ////Planned value

      if ($data['eh_cat_principal']){
        $monthCatPlanSum = sum_budget_value($bdConexao, $monthYear, $data['nome_cat']);
      } else {
        $monthCatPlanSum = $data[$monthYear];
      }
      $budgetLines .= "<td data-money data-type='plan' $dataSets $monthDataSets>
                        {$monthCatPlanSum}
                      </td>";

      ////Executed value
      if ($data['eh_cat_principal']){
        $monthCatExecSun = calculate_result($bdConexao, $month, $ano, 'SSM', null, null, $data['nome_cat']);
      } else {
        $monthCatExecSun = calculate_result($bdConexao, $month, $ano, 'SSM', null, $data['id_cat']);
      }
      $budgetLines .= "<td data-money data-type='exec' $dataSets $monthDataSets>
                        {$monthCatExecSun}
                      </td>";
    }

    $budgetLines .= "</tr>";

  }

}

////Month result
$budgetLines .= "<tr>";
$budgetLines .= "<td data-type='month-result-title' data-fixed-column='first'>Resultado mês:</td>";
$budgetLines .= "<td data-type='month-selected-result' data-fixed-column='second'></td>";

foreach ($months as $month){

  $monthYear = $ano . "_" . $month;

  $monthResultDataSets = "";
  $monthResultDataSets .= "data-month='{$monthYear}'";
  if (check_selected_month_budget($month, $mes)){
    $monthResultDataSets .= "data-selected='true'";
  } else {
    $monthResultDataSets .= "data-selected='false'";
  }

  //Planned month result (sum)
  $budgetLines .= "<td data-money data-type='month-result-plan' $monthResultDataSets>" . sum_budget_value($bdConexao, $monthYear) . "</td>";
  
  //Executed month result (sum)
  $budgetLines .= "<td data-money data-type='month-result-exec' $monthResultDataSets>" . calculate_result($bdConexao, $month, $ano, 'SSM') . "</td>";

}

$budgetLines .= "</tr>";  

////Acumulated result

$acumulatedPlanned = 0;

$budgetLines .= "<tr>";
$budgetLines .= "<td data-type='month-result-title' data-fixed-column='first'>Resultado acumulado:</td>";
$budgetLines .= "<td data-type='month-selected-result' data-fixed-column='second'>R$ 0,00</td>";

foreach ($months as $month){

  $monthYear = $ano . "_" . $month;

  $acumulatedResultDataSets = "";
  $acumulatedResultDataSets .= "data-month='{$monthYear}'";
  if (check_selected_month_budget($month, $mes)){
    $acumulatedResultDataSets .= "data-selected='true'";
  } else {
    $acumulatedResultDataSets .= "data-selected='false'";
  }

  //Planned month result (sum)
  $acumulatedPlanned += floatval(sum_budget_value($bdConexao, $monthYear));
  $budgetLines .= "<td data-money data-type='month-result-plan' $acumulatedResultDataSets>" . $acumulatedPlanned . "</td>";
  
  //Executed month result (sum)
  $budgetLines .= "<td data-money data-type='month-result-exec' $acumulatedResultDataSets>" . calculate_result($bdConexao, $month, $ano, 'SAM') . "</td>";

}

$budgetLines .= "</tr>";  

?>


<main class="container-principal">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>

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
<div class="box formulario" id="container-budget-edit-form">
    <div class="container-budget-edit-form-btns">
      <form class="budget-edit-form" id="form-edit-budget" method="POST" action="">
        <input style='display: none' type="number" id="campo-categoria" name="campo-categoria" readonly />
        <input style='display: none' type="text" id="campo-mes" name="campo-mes" readonly />
        <img src="/assets/img/ico/edit.svg" class="icone-editar" alt="Editar">
        <label for="valor">Alterar o valor de <span id="nome-cat-label"></span> no mês de <span id=mes-label></span>:</label>
        <input type="number" step="any" id="campo-valor" name="campo-valor" />
        <button class="botao-acao-secundario confirmar" type="submit">Alterar</button>
      </form>
      <button class="botao-acao-secundario neutro" id="botao-copiar">Copiar executado</button>
      <button class="botao-acao-secundario cancelar" id="botao-cancelar">Cancelar</button>
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