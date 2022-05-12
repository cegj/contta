<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/format_value.php');


$url = $_SERVER['SCRIPT_NAME']; ?>

<section class="caixas-saldos">
  <div class="caixa-saldo" id="saldo-mes">
    <h3>Saldo do mês</h3>
    <span class="valor">

      <?php if ($pageName == 'account' && isset($_GET['conta'])) :
        $resultadoMes = calculate_result($bdConexao, $mes, $ano, 'SSM', $_GET['conta']);
        echo "R$ <span id='valor-mes' class='money'>" . $resultadoMes . "</span>";

      else :

        if ($pageName == 'category' && isset($_GET['categoria'])) :
          $resultadoMes = calculate_result($bdConexao, $mes, $ano, 'SSM', null, $_GET['categoria']);
          echo "R$ <span id='valor-mes' class='money'>" . $resultadoMes . "</span>";

        else :

          $resultadoMes = format_value(calculate_result($bdConexao, $mes, $ano, 'SSM'));
          echo "R$ <span id='valor-mes' class='money'>" . $resultadoMes . "</span>";

        endif;
      endif;
      ?>

    </span>
  </div>

  <div class="caixa-saldo" id="saldo-acumulado">
    <h3>Saldo acumulado até o mês</h3>
    <span class="valor">

      <?php if ($pageName == 'account' && isset($_GET['conta'])) :
        $resultadoAcumulado = calculate_result($bdConexao, $mes, $ano, 'SAM', $_GET['conta']);
        echo "R$ <span id='valor-acumulado' class='money'>" . $resultadoAcumulado . "</span>";

      else :

        if ($pageName == 'category' && isset($_GET['categoria'])) :
          $resultadoAcumulado = calculate_result($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria']);
          echo "R$ <span id='valor-acumulado' class='money'>" . $resultadoAcumulado . "</span>";

        else :

          $resultadoAcumulado = format_value(calculate_result($bdConexao, $mes, $ano, 'SAM'));
          echo "R$ <span id='valor-acumulado' class='money'>" . $resultadoAcumulado . "</span>";

        endif;
      endif;
      ?>

    </span>
  </div>
  <div class="caixa-saldo" id="saldo-geral">
    <h3>Saldo acumulado geral</h3>
    <span class="valor">

      <?php if ($pageName == 'account' && isset($_GET['conta'])) :
        $resultadoGeral = calculate_result($bdConexao, $mes, $ano, 'SAG', $_GET['conta']);
        echo "R$ <span id='valor-geral' class='money'>" . $resultadoGeral . "</span>";

      else :

        if ($pageName == 'category' && isset($_GET['categoria'])) :
          $resultadoGeral = calculate_result($bdConexao, $mes, $ano, 'SAG', null, $_GET['categoria']);
          echo "R$ <span id='valor-geral' class='money'>" . $resultadoGeral . "</span>";

        else :

          $resultadoGeral = format_value(calculate_result($bdConexao, $mes, $ano, 'SAG'));
          echo "R$ <span id='valor-geral' class='money'>" . $resultadoGeral . "</span>";

        endif;
      endif;
      ?>

    </span>
  </div>
</section>