<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');

$url = $_SERVER['SCRIPT_NAME']; ?>

<section class="caixas-saldos">
  <div class="caixa-saldo" id="saldo-mes">
    <h3>Saldo do mês</h3>
    <span class="valor">

      <?php if ($pageName == 'account' && isset($_GET['conta'])) :
        $resultadoMes = calculate_result($bdConexao, $mes, $ano, 'SSM', $_GET['conta']);
        echo "<span id='valor-mes' data-showhide>" . $resultadoMes . "</span>";

      else :

        if ($pageName == 'category' && isset($_GET['categoria'])) :
          $resultadoMes = calculate_result($bdConexao, $mes, $ano, 'SSM', null, $_GET['categoria']);
          echo "<span id='valor-mes' data-showhide>" . $resultadoMes . "</span>";

        else :

          $resultadoMes = calculate_result($bdConexao, $mes, $ano, 'SSM');
          echo "<span id='valor-mes' data-showhide>" . $resultadoMes . "</span>";

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
        echo "<span id='valor-acumulado' data-showhide>" . $resultadoAcumulado . "</span>";

      else :

        if ($pageName == 'category' && isset($_GET['categoria'])) :
          $resultadoAcumulado = calculate_result($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria']);
          echo "<span id='valor-acumulado' data-showhide>" . $resultadoAcumulado . "</span>";

        else :

          $resultadoAcumulado = calculate_result($bdConexao, $mes, $ano, 'SAM');
          echo "<span id='valor-acumulado' data-showhide>" . $resultadoAcumulado . "</span>";

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
        echo "<span id='valor-geral' data-showhide>" . $resultadoGeral . "</span>";

      else :

        if ($pageName == 'category' && isset($_GET['categoria'])) :
          $resultadoGeral = calculate_result($bdConexao, $mes, $ano, 'SAG', null, $_GET['categoria']);
          echo "<span id='valor-geral' data-showhide>" . $resultadoGeral . "</span>";

        else :

          $resultadoGeral = calculate_result($bdConexao, $mes, $ano, 'SAG');
          echo "<span id='valor-geral' data-showhide>" . $resultadoGeral . "</span>";

        endif;
      endif;
      ?>

    </span>
  </div>
</section>