<?php $url = $_SERVER['SCRIPT_NAME']; ?>

<section class="caixas-saldos">
  <div class="caixa-saldo" id="saldo-mes">
    <h3>Saldo do mês</h3>
    <span class="valor">

      <?php if ($url == '/contas.php' && isset($_GET['conta'])) :
        $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SSM', $_GET['conta']);
        echo "R$ <span id='valor-mes' class='money'>" . $resultadoMes . "</span>";

      else :

        if ($url == '/categorias.php' && isset($_GET['categoria'])) :
          $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SSM', null, $_GET['categoria']);
          echo "R$ <span id='valor-mes' class='money'>" . $resultadoMes . "</span>";

        else :

          $resultadoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM'));
          echo "R$ <span id='valor-mes' class='money'>" . $resultadoMes . "</span>";

        endif;
      endif;
      ?>

    </span>
  </div>

  <div class="caixa-saldo" id="saldo-acumulado">
    <h3>Saldo acumulado até o mês</h3>
    <span class="valor">

      <?php if ($url == '/contas.php' && isset($_GET['conta'])) :
        $resultadoAcumulado = calcula_resultado($bdConexao, $mes, $ano, 'SAM', $_GET['conta']);
        echo "R$ <span id='valor-acumulado' class='money'>" . $resultadoAcumulado . "</span>";

      else :

        if ($url == '/categorias.php' && isset($_GET['categoria'])) :
          $resultadoAcumulado = calcula_resultado($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria']);
          echo "R$ <span id='valor-acumulado' class='money'>" . $resultadoAcumulado . "</span>";

        else :

          $resultadoAcumulado = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM'));
          echo "R$ <span id='valor-acumulado' class='money'>" . $resultadoAcumulado . "</span>";

        endif;
      endif;
      ?>

    </span>
  </div>
  <div class="caixa-saldo" id="saldo-geral">
    <h3>Saldo acumulado geral</h3>
    <span class="valor">

      <?php if ($url == '/contas.php' && isset($_GET['conta'])) :
        $resultadoGeral = calcula_resultado($bdConexao, $mes, $ano, 'SAG', $_GET['conta']);
        echo "R$ <span id='valor-geral' class='money'>" . $resultadoGeral . "</span>";

      else :

        if ($url == '/categorias.php' && isset($_GET['categoria'])) :
          $resultadoGeral = calcula_resultado($bdConexao, $mes, $ano, 'SAG', null, $_GET['categoria']);
          echo "R$ <span id='valor-geral' class='money'>" . $resultadoGeral . "</span>";

        else :

          $resultadoGeral = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAG'));
          echo "R$ <span id='valor-geral' class='money'>" . $resultadoGeral . "</span>";

        endif;
      endif;
      ?>

    </span>
  </div>
</section>

<script>
  caixaSaldoMes = document.getElementById('saldo-mes')
  caixaSaldoAcumulado = document.getElementById('saldo-acumulado')
  caixaSaldoGeral = document.getElementById('saldo-geral')
  valorMes = document.getElementById('valor-mes')
  valorAcumulado = document.getElementById('valor-acumulado')
  valorGeral = document.getElementById('valor-geral')

  if (parseFloat(valorMes.innerText) >= 0) {
    caixaSaldoMes.classList.add('positivo');
  } else if (parseFloat(valorMes.innerText) < 0) {
    caixaSaldoMes.classList.add('negativo');
  }

  if (parseFloat(valorAcumulado.innerText) >= 0) {
    caixaSaldoAcumulado.classList.add('positivo');
  } else if (parseFloat(valorAcumulado.innerText) < 0) {
    caixaSaldoAcumulado.classList.add('negativo');
  }

  if (parseFloat(valorGeral.innerText) >= 0) {
    caixaSaldoGeral.classList.add('positivo');
  } else if (parseFloat(valorGeral.innerText) < 0) {
    caixaSaldoGeral.classList.add('negativo');
  }
</script>