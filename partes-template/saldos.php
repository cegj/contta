<?php $url = $_SERVER['SCRIPT_NAME']; ?>

<section class="caixas-saldos">
  <div class="caixa-saldo">
    <h3>Saldo do mês</h3>
    <span class="valor">

      <?php if($url == '/contas.php' && isset($_GET['conta'])) : 
        $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SSM', $_GET['conta']);
        echo "R$ " . $resultadoMes;
      
      else : 

        if($url == '/categorias.php' && isset($_GET['categoria'])) : 
          $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SSM', null, $_GET['categoria']);
          echo "R$ " . $resultadoMes;
          
        else :

        $resultadoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM'));
        echo "R$ " . $resultadoMes;
      
      endif;
    endif;
      ?>

</span>
  </div>

  <div class="caixa-saldo">
    <h3>Saldo acumulado até o mês</h3>
    <span class="valor">

      <?php if($url == '/contas.php' && isset($_GET['conta'])) : 
        $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SAM', $_GET['conta']);
        echo "R$ " . $resultadoMes;
      
      else : 

        if($url == '/categorias.php' && isset($_GET['categoria'])) : 
          $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria']);
          echo "R$ " . $resultadoMes;
          
        else :

        $resultadoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM'));
        echo "R$ " . $resultadoMes;
      
      endif;
    endif;
      ?>

</span>
  </div>
  <div class="caixa-saldo">
    <h3>Saldo acumulado geral</h3>
    <span class="valor">

      <?php if($url == '/contas.php' && isset($_GET['conta'])) : 
        $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SAG', $_GET['conta']);
        echo "R$ " . $resultadoMes;
      
      else : 

        if($url == '/categorias.php' && isset($_GET['categoria'])) : 
          $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'SAG', null, $_GET['categoria']);
          echo "R$ " . $resultadoMes;
          
        else :

        $resultadoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAG'));
        echo "R$ " . $resultadoMes;
      
      endif;
    endif;
      ?>

</span>
  </div>
</section>