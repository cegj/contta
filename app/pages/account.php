<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/database/table_is_not_empty.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/get_accounts.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/get_especific_account.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/parse_boolean.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/format_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/get_days_in_month.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/translate_date_to_br.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/transaction/get_transactions.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/remove_url_param.php');

$configuracao = filter_input(INPUT_GET, 'configurar', FILTER_VALIDATE_BOOL);

$id_conta = filter_input(INPUT_GET, 'id_conta', FILTER_VALIDATE_INT);

$queryWithoutIdTransacao = remove_url_param($url, 'id_transacao');
$queryWithoutIdConta = remove_url_param($url, 'id_conta');

?>

<main class="container-principal" data-page-name="Contas">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>

  <div class="container duas-colunas <?php if ($configuracao == false) : ?>com-extrato<?php else : ?>sem-bg<?php endif; ?>">

    <?php if ($configuracao != true) : ?>
      <div class="item-grid-principal">
        <h2 class="titulo-container">Contas</h2>

        <?php if (table_is_not_empty($bdConexao, 'contas')) : ?>

          <table class="tabela">
            <?php
            $contas = get_accounts($bdConexao);

            foreach ($contas as $conta) :
              $exibir = parse_boolean($conta['exibir'], 'Sim', 'Não');
              $saldoMes = format_value(calculate_result($bdConexao, $mes, $ano, 'SSM', $conta['id_con']));
              $saldoAcumulado = format_value(calculate_result($bdConexao, $mes, $ano, 'SAM', $conta['id_con']));

              if ($saldoMes == 0) {
                $saldoMes = "0,00";
              }
              if ($saldoAcumulado == 0) {
                $saldoAcumulado = "0,00";
              }

              echo "<tr>
                        <td class='td-conta'><a class='filtrar' href='?p={$pageName}&conta={$conta['id_con']}'>{$conta['conta']} <img class='icone-filtrar' src='/assets/img/ico/filter.svg'></a></td>
                        <td class='td-conta'>R$ <span data-showhide>{$saldoAcumulado}</span></td>
                        </tr>
                        ";

            endforeach;
            ?>
          </table>

        <?php else : ?>

          <p class="info-tabela-vazia">Não há contas cadastradas</p>

        <?php endif; ?>

      </div>

      <div class="item-grid-secundario">

        <?php

        if (isset($_GET['conta']) && isset($mes) && isset($ano)) : ?>

          <?php $contaSelecionada = get_especific_account($bdConexao, $_GET['conta']); ?>
          <div class="container-titulo-subtitulo">
            <h2 class="titulo-container titulo-extrato com-subtitulo">Extrato da conta</h2>
            <h3 class="subtitulo-container"><?php echo $contaSelecionada['conta'] ?></h3>
          </div>
          <table class="tabela extrato compacto tabela-responsiva">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Categoria</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tr>
              <?php

              $totalDiasMes = get_days_in_month($mes, $ano);

              for ($dia = 1; $dia <= $totalDiasMes; $dia++) :

                $registros = get_transactions($bdConexao, $dia, $mes, $ano, null, null, null, $_GET['conta']);

                if (sizeof($registros) != 0) :

                  $resultadoDia = format_value(calculate_result($bdConexao, $mes, $ano, 'SSM', $_GET['conta'], null, null, $dia));

                  $resultadoDiaAcumuladoMes = format_value(calculate_result($bdConexao, $mes, $ano, 'SAM', $_GET['conta'], null, null, $dia, true));

                  $resultadoDiaAcumuladoTotal = format_value(calculate_result($bdConexao, $mes, $ano, 'SAM', $_GET['conta'], null, null, $dia));


                  foreach ($registros as $registro) :

                    $data = translate_date_to_br($registro['data']);
                    $valor = format_value($registro['valor']);

                    echo "<tr class='linha-extrato'>
            <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
            <td>{$data}</td>
            <td>{$registro['descricao']}</td>
            <td class='linha-extrato-valor'>R$ <span data-showhide>{$valor}</span></td>
            <td><a class='filtrar' href='?p=category&categoria={$registro['id_categoria']}'>{$registro['nome_cat']}</a></td>
            <td class='coluna-acoes'>";
                    if ($registro['tipo'] == 'T' && $registro['valor'] > 0 or $registro['tipo'] == 'SI') {
                      echo "";
                    } else {
                      echo "<a class='edit-btn' href='?{$queryWithoutIdTransacao}&id_transacao={$registro['id']}'></a>";
                      echo "
            </td>
            </tr>
            ";
                    }
                  endforeach;

                  echo "
            <tr>
             <td class='linha-resultado-dia-extrato' colspan='6'>
                <span class='valor-resultado-dia-extrato'>Resultado diário: R$ <span data-showhide>{$resultadoDia}</span></span>
                <span class='valor-resultado-dia-extrato'>Acumulado mês: R$ <span data-showhide>{$resultadoDiaAcumuladoMes}</span></span>
                <span class='valor-resultado-dia-extrato'>Acumulado total: R$ <span data-showhide>{$resultadoDiaAcumuladoTotal}</span></span>
              </td>
            </tr>
            ";

                endif;

              endfor;

              ?>
            </tr>
          </table>

        <?php else : ?>
          <p class="instrucao">Escolha uma conta para ver o seu histórico no mês selecionado.</p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($configuracao == true) : ?>
      <div class="item-grid-principal">
        <?php if (table_is_not_empty($bdConexao, 'contas')) :
        ?>
          <h2 class="titulo-container">Configuração das contas</h2>
          <table class="tabela tabela-responsiva" id="tabela-contas-cadastradas">
            <thead>
              <tr>
                <th>Conta</th>
                <th>Tipo</th>
                <th>Saldo inicial</th>
                <th>Exibir</th>
                <th class="coluna-acoes">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $contas = get_accounts($bdConexao);

              foreach ($contas as $conta) :
                $exibir = parse_boolean($conta['exibir'], 'Sim', 'Não');
                $saldoInicialFormatado = format_value($conta['saldo_inicial']);

                echo "<tr>
                      <td class='td-conta'>{$conta['conta']}</td>
                      <td class='td-conta'>{$conta['tipo_conta']}</td>
                      <td class='td-conta'>R$ <span data-showhide>{$saldoInicialFormatado}</span></td>
                      <td class='td-conta'>{$exibir}</td>
                      <td class='coluna-acoes'><a class='edit-btn' href='?{$queryWithoutIdConta}&id_conta={$conta['id_con']}'></a>
                      </tr>
                      ";

              endforeach;

              ?>
            </tbody>
          </table>
      </div>

    <?php else : ?>

      <p>Não há contas cadastradas</p>
  </div>

<?php endif; ?>

<div class="box formulario" id="box-formulario">
  <!-- Formulário -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/form-account.php') ?>
</div>

</div>

<?php endif; ?>
</main>

<script src="/contas/contas.js" defer></script>

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

<script src="/contas/contas.js" type="text/javascript"></script>