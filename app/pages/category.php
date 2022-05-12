<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/database/table_is_not_empty.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_secondary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_especific_category.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/transaction/get_transactions.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/format_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/get_days_in_month.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/translate_date_to_br.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/remove_url_param.php');

$configuracao = filter_input(INPUT_GET, 'configurar', FILTER_VALIDATE_BOOL);

$id_cat = filter_input(INPUT_GET, 'id_cat', FILTER_VALIDATE_INT);

$queryWithoutIdTransaction = remove_url_param($url, 'id_transacao');
$queryWithoutIdCat = remove_url_param($url, 'id_cat');

?>

<main class="container-principal">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>

  <div class="container duas-colunas <?php if ($configuracao == false) : ?>com-extrato<?php else : ?>sem-bg<?php endif; ?>">

    <?php if (table_is_not_empty($bdConexao, 'categorias')) :
    ?>
      <div class="item-grid-principal">
        <?php if ($configuracao == true) : ?>
          <h2 class="titulo-container">Configuração das categorias</h2>
        <?php else : ?>
          <h2 class="titulo-container">Categorias</h2>
        <?php endif; ?>
        <div class="container-tabela">
          <table class="tabela">
            <?php if ($configuracao == true) : ?>
              <thead>
                <tr>
                  <th>Título da categoria</th>
                  <th class="coluna-acoes">Ações</th>
                </tr>
              </thead>
            <?php endif; ?>
            <tr>
              <?php
              $categoriasPrincipais = get_primary_categories($bdConexao);

              foreach ($categoriasPrincipais as $categoriaPrincipal) :

                $saldoMesCatPrincipal = format_value(calculate_result($bdConexao, $mes, $ano, 'SSM', null, null,  $categoriaPrincipal['nome_cat']));


                echo "<tr class='cat-principal'>
          <td class='td-cat-principal'>{$categoriaPrincipal['nome_cat']}</td>";

                if ($configuracao != true) :

                  echo "<td>R$ <span class='money'>{$saldoMesCatPrincipal}</span></td>";

                endif;

                if ($configuracao == true) {
                  echo "
                      <td class='coluna-acoes'><a class='edit-btn' href='?{$queryWithoutIdCat}&id_cat={$categoriaPrincipal['id_cat']}'></a>";
                }

                echo "</tr>";

                $categoriasSecundarias = get_secondary_categories($bdConexao, $categoriaPrincipal);

                foreach ($categoriasSecundarias as $categoriaSecundaria) :

                  $saldoMes = format_value(calculate_result($bdConexao, $mes, $ano, 'SSM', null, $categoriaSecundaria['id_cat']));

                  echo "<tr>";

                  if ($configuracao != true) :
                    echo "<td class='td-cat-secundaria'><a class='filtrar' href='?p={$pageName}&categoria={$categoriaSecundaria['id_cat']}'>{$categoriaSecundaria['nome_cat']} <img class='icone-filtrar' src='/assets/img/ico/filter.svg'></a></td>";

                  else :
                    echo "<td class='td-cat-secundaria'>{$categoriaSecundaria['nome_cat']}</td>";

                  endif;

                  if ($configuracao != true) :

                    echo "<td>R$ <span class='money'>{$saldoMes}</span></td>";

                  endif;

                  if ($configuracao == true) {
                    echo "
                            <td class='coluna-acoes'><a class='edit-btn' href='?{$queryWithoutIdCat}&id_cat={$categoriaSecundaria['id_cat']}'></a></td>";
                  }
                  echo "</tr>";
                endforeach;

              endforeach;
              ?>
            </tr>
          </table>
        </div>
      <?php else : ?>
        <div>
          <p class="info-tabela-vazia">Não há categorias cadastradas</p>
          <div>
          <?php endif; ?>
          </div>

          <?php if ($configuracao != true) : ?>
            <div class="item-grid-secundario">
              <?php if (isset($_GET['categoria']) && isset($mes) && isset($ano)) : ?>

                <?php $catSelecionada = get_especific_category($bdConexao, $_GET['categoria']);

                ?>
                <div class="container-titulo-subtitulo">
                  <h2 class="titulo-container titulo-extrato com-subtitulo">Extrato da categoria</h2>
                  <h3 class="subtitulo-container"><?php echo $catSelecionada['nome_cat'] ?></h3>
                </div>
                <div class="container-tabela">
                  <table class="tabela extrato compacto tabela-responsiva">
                    <thead>
                      <tr>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Conta</th>
                        <th>Editar</th>
                      </tr>
                    </thead>
                    <tr>
                      <?php

                      $totalDiasMes = get_days_in_month($mes, $ano);

                      for ($dia = 1; $dia <= $totalDiasMes; $dia++) :

                        $registros = get_transactions($bdConexao, $dia, $mes, $ano, null, null, $_GET['categoria']);

                        if (sizeof($registros) != 0) :

                          $resultadoDia = format_value(calculate_result($bdConexao, $mes, $ano, 'SSM', null, $_GET['categoria'], null, $dia));

                          $resultadoDiaAcumuladoMes = format_value(calculate_result($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria'], null, $dia, true));

                          $resultadoDiaAcumuladoTotal = format_value(calculate_result($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria'], null, $dia));

                          foreach ($registros as $registro) :

                            $data = translate_date_to_br($registro['data']);
                            $valor = format_value($registro['valor']);

                            echo "<tr class='linha-extrato'>
          <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
          <td>{$data}</td>
          <td>{$registro['descricao']}</td>
          <td class='linha-extrato-valor'>R$ <span class='money'>{$valor}</span></td>
          <td>{$registro['conta']}</td>
          <td class='coluna-acoes'>";
                            if ($registro['tipo'] == 'T' && $registro['valor'] > 0 or $registro['tipo'] == 'SI') {
                              echo "";
                            } else {
                              echo "<a class='edit-btn' href='?{$queryWithoutIdTransaction}&id_transacao={$registro['id']}'></a>";
                              echo "
              </td>
              </tr>
          ";
                            }
                          endforeach;

                          echo "
              <tr>
                <td class='linha-resultado-dia-extrato' colspan='6' class='linha-resultado-dia-extrato'>
                  <span class='valor-resultado-dia-extrato'>Resultado diário: R$ <span class='money'>{$resultadoDia}</span></span>
                  <span class='valor-resultado-dia-extrato'>Acumulado mês: R$ <span class='money'>{$resultadoDiaAcumuladoMes}</span></span>
                  <span class='valor-resultado-dia-extrato'>Acumulado total: R$ <span class='money'>{$resultadoDiaAcumuladoTotal}</span></span>
                </td>
              </tr>
              ";

                        endif;

                      endfor;

                      ?>
                    </tr>
                  </table>
                </div>
              <?php else : ?>
                <p class="instrucao">Escolha uma categoria para ver o seu histórico no mês selecionado.</p>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <?php if ($configuracao == true) : ?>
            <div class="box formulario" id="box-formulario">
              <!-- Formulário -->
              <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/form_category.php') ?>
            </div>
          <?php endif; ?>

</main>

<script src="/categorias/categorias.js" defer></script>

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