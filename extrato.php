<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

if (isset($_GET['editar']) && $_GET['editar'] = true) {
  $edicao = true;

  $id_reg = $_GET['id'];

  $reg_especifico = buscar_reg_especifico($bdConexao, $id_reg);

  foreach ($reg_especifico as $reg_em_edicao) :
    $reg_edicao_tipo = $reg_em_edicao['tipo'];
    $reg_edicao_data = $reg_em_edicao['data'];
    $reg_edicao_descricao = $reg_em_edicao['descricao'];
    $reg_edicao_valor = formata_valor(abs($reg_em_edicao['valor']), 2, ',', '.');
    $reg_edicao_categoria = $reg_em_edicao['id_categoria'];
    $reg_edicao_conta = $reg_em_edicao['id_conta'];
    $reg_edicao_parcela = $reg_em_edicao['parcela'];
    $reg_edicao_total_parcelas = $reg_em_edicao['total_parcelas'];
  endforeach;
} else {
  $edicao = false;

  $reg_edicao_tipo = '';
  $reg_edicao_data = '';
  $reg_edicao_descricao = '';
  $reg_edicao_valor = '';
  $reg_edicao_categoria = '';
  $reg_edicao_conta = '';
  $reg_edicao_parcela = '';
  $reg_edicao_total_parcelas = '';
}

?>


<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/extrato/extrato.css">
</head>

<body>

  <?php //Valida se o usuário está logado
  if (isset($login_cookie)) : ?>

    <!-- Cabeçalho (barra superior) -->
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/header.php') ?>

    <main class="container-principal">

    <!-- Caixas de saldos -->
      <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/saldos.php'); ?>

    <!-- Opções -->
    <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/opcoes.php'); ?>


      <div class="container uma-coluna">

        <?php
        if (isset($_POST['exibirregistro'])) {
          $_SESSION['exibeRegistro'] = $_POST['exibirregistro'];
        }

        if ($edicao == true) {
          $exibeRegistro = true;
        } else 
      if (isset($_SESSION['exibeRegistro'])) {
          $exibeRegistro = $_SESSION['exibeRegistro'];
        } else {
          $exibeRegistro = false;
        }
        ?>

        <h2 class="titulo-container">Extrato</h2>
        <table class="tabela extrato">
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

            $totalDiasMes = days_in_month($mes, $ano);

            for ($dia = 1; $dia <= $totalDiasMes; $dia++) :

              $registros = buscar_registros($bdConexao, $dia, $mes, $ano, $tudo);

              if (sizeof($registros) != 0) :

                $resultadoDia = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM', null, null, null, $dia));

                $resultadoDiaAcumulado = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM', null, null, null, $dia));


                foreach ($registros as $registro) :

                  $data = traduz_data_para_br($registro['data']);

                  $valorFormatado = formata_valor($registro['valor']);

                  echo "<tr class='linha-extrato'>
          <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
          <td>{$data}</td>
          <td>{$registro['descricao']}</td>
          <td class='linha-extrato-valor'>R$ {$valorFormatado}</td>
          <td><a class='filtrar' href='/categorias.php?categoria={$registro['id_categoria']}'>{$registro['nome_cat']} <img class='icone-filtrar' src='/img/icos/filtrar.svg'></a></td>
          <td><a class='filtrar' href='/contas.php?conta={$registro['id_con']}'>{$registro['conta']} <img class='icone-filtrar' src='/img/icos/filtrar.svg'></a></td>
          <td class='coluna-acoes'>";
                  if ($registro['tipo'] == 'T' && $registro['valor'] > 0 or $registro['tipo'] == 'SI') {
                    echo "";
                  } else {
                    echo "<a href='extrato.php?id={$registro['id']}&editar=true#caixa-registrar'><img class='icone-editar' alt='Editar' src='img/icos/editar.svg'/></a>";
                    echo "
              </td>
              </tr>
          ";
                  }
                endforeach;
                echo "
              <tr>
              <td colspan='7' class='linha-resultado-dia-extrato'> Resultado diário: R$ {$resultadoDia} | Resultado acumulado: R$ {$resultadoDiaAcumulado}</td>
              </tr>
              ";

              endif;

            endfor;

          else :

            $registros = buscar_registros($bdConexao, null, null, null, $tudo);

            foreach ($registros as $registro) :

              $data = traduz_data_para_br($registro['data']);

              $valorFormatado = formata_valor($registro['valor']);

              echo "<tr class='linha-extrato'>
          <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
          <td>{$data}</td>
          <td>{$registro['descricao']}</td>
          <td class='linha-extrato-valor'>R$ {$valorFormatado}</td>
          <td><a href='/categorias.php?categoria={$registro['id_categoria']}'>{$registro['nome_cat']}</a></td>
          <td><a href='/contas.php?conta={$registro['id_con']}'>{$registro['conta']}</a></td>
          <td>";
              if ($registro['tipo'] == 'T' && $registro['valor'] > 0 or $registro['tipo'] == 'SI') {
                echo "";
              } else {
                echo "<a href='extrato.php?id={$registro['id']}&editar=true#caixa-registrar'><img class='icone-editar' alt='Editar' src='img/icone-editar.svg'/></a>";
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
      </div>

      <style type="text/css">
        #caixa-registrar {
          display: <?php if ($exibeRegistro == "true") {
                      echo ' block;';
                    } else {
                      echo ' none;';
                    } ?>
        }
      </style>

      <div style="max-width: 700px; margin: auto;">
        <div id="caixa-registrar" class="container-registro">
          <?php if ($edicao == false) :
          ?>
            <h2 class="titulo-caixa">Fazer registro</h2>
          <?php else : ?>
            <h2 class="titulo-caixa">Editar registro</h2>
            <h3><?php echo $reg_edicao_descricao; ?> de <?php echo traduz_data_para_br($reg_edicao_data); ?></h3>
          <?php endif; ?>
          <!-- Formulário -->
          <?php include($_SERVER["DOCUMENT_ROOT"] . '/extrato/formulario_registrar.php') ?>
        </div>
      </div>
      </div>

    </main>

    <!-- Rodapé -->
      <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/footer.php') ?>

  <?php //Caso o usuário não esteja logado, exibe o conteúdo abaixo em vez da página. 
  else :
    echo "
      <div class='alerta-necessidade-login'>
      <p>Para continuar, é necessário fazer login.</p>
      </div>
      ";
    include 'login.php';
  ?>
  <?php endif ?>
</body>


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

</html>