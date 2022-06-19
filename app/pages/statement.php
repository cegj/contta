<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/database/table_is_not_empty.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/get_days_in_month.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/transaction/get_transactions.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/translate_date_to_br.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/remove_url_param.php');

$edicao = filter_input(INPUT_GET, 'editar', FILTER_VALIDATE_BOOL);

$id_transacao = filter_input(INPUT_GET, 'id_transacao', FILTER_VALIDATE_INT);

$queryWithoutIdTransaction = remove_url_param($url, 'id_transacao');

?>
<main class="container-principal" data-page-name="Extrato">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>


  <div class="container uma-coluna">

    <h2 class="titulo-container">Extrato</h2>

    <?php if (table_is_not_empty($bdConexao, 'extrato')) : ?>

      <table class="tabela extrato tabela-responsiva">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Data</th>
            <th>Descrição</th>
            <th>Valor</th>
            <th class="filtrar-titulo">Categoria</th>
            <th class="filtrar-titulo">Conta</th>
            <th>Ações</th>
          </tr>
        </thead>

        <?php

        if ($tudo != true) :

          $totalDiasMes = get_days_in_month($mes, $ano);

          for ($dia = 1; $dia <= $totalDiasMes; $dia++) :

            $transacoes = get_transactions($bdConexao, $dia, $mes, $ano, $tudo);

            if (sizeof($transacoes) != 0) :

              $resultadoDia = calculate_result($bdConexao, $mes, $ano, 'SSM', null, null, null, $dia);

              $resultadoDiaAcumuladoMes = calculate_result($bdConexao, $mes, $ano, 'SAM', null, null, null, $dia, true);

              $resultadoDiaAcumuladoTotal = calculate_result($bdConexao, $mes, $ano, 'SAM', null, null, null, $dia);

              foreach ($transacoes as $transacao) :

                $data = translate_date_to_br($transacao['data']);

                $valorFormatado = $transacao['valor'];

                echo "<tr class='linha-extrato'>
            <td class='linha-extrato-tipo'>{$transacao['tipo']}</td>
            <td>{$data}</td>
            <td>{$transacao['descricao']}</td>
            <td class='linha-extrato-valor'><span data-showhide>{$valorFormatado}</span></td>
            <td><a class='filtrar' href='?p=category&categoria={$transacao['id_categoria']}'>{$transacao['nome_cat']} <img class='icone-filtrar' src='/assets/img/ico/filter.svg'></a></td>
            <td><a class='filtrar' href='?p=account&conta={$transacao['id_con']}'>{$transacao['conta']} <img class='icone-filtrar' src='/assets/img/ico/filter.svg'></a></td>
            <td class='coluna-acoes'>";
                if ($transacao['tipo'] == 'T' && $transacao['valor'] > 0 or $transacao['tipo'] == 'SI') {
                  echo "";
                } else {
                  echo "<a class='edit-btn' href='?{$queryWithoutIdTransaction}&id_transacao={$transacao['id']}'></a>";
                  echo "
                </td>
                </tr>
            ";
                }
              endforeach;
              echo "
                  <tr>
                    <td class='linha-resultado-dia-extrato' colspan='7'>
                      <span class='valor-resultado-dia-extrato'>Resultado diário: <span data-showhide>{$resultadoDia}</span></span>
                      <span class='valor-resultado-dia-extrato'>Acumulado mês: <span data-showhide>{$resultadoDiaAcumuladoMes}</span></span>
                      <span class='valor-resultado-dia-extrato'>Acumulado total: <span data-showhide>{$resultadoDiaAcumuladoTotal}</span></span>
                    </td>
                  </tr>
                  ";

            endif;

          endfor;

        else :

          $transacoes = get_transactions($bdConexao, null, null, null, $tudo);

          foreach ($transacoes as $transacao) :

            $data = translate_date_to_br($transacao['data']);

            $valorFormatado = $transacao['valor'];

            echo "
                  <tr class='linha-extrato'>
                    <td class='linha-extrato-tipo'>{$transacao['tipo']}</td>
                    <td>{$data}</td>
                    <td>{$transacao['descricao']}</td>
                    <td class='linha-extrato-valor'><span data-showhide>{$valorFormatado}</span></td>
                    <td><a href='/categorias.php?categoria={$transacao['id_categoria']}'>{$transacao['nome_cat']}</a></td>
                    <td><a href='/contas.php?conta={$transacao['id_con']}'>{$transacao['conta']}</a></td>
                    <td>";
            if ($transacao['tipo'] == 'T' && $transacao['valor'] > 0 or $transacao['tipo'] == 'SI') {
              echo "";
            } else {
              echo "<a href='extrato.php?id_transacao={$transacao['id']}&editar=true#caixa-registrar'><img class='icone-editar' alt='Editar' src='/assets/img/ico/edit.svg'/></a>";
              echo "
                          </td>
                  </tr>
                ";
            }
          endforeach;

        endif;
        ?>
        </tr>
      </table>

    <?php else : ?>

      <p class="info-tabela-vazia">Não há transações registradas no extrato.</p>

    <?php endif; ?>

  </div>

</main>

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