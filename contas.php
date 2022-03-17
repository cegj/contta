<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

if (filter_input(INPUT_GET, 'configurar', FILTER_VALIDATE_BOOL)) {
  $configuracao = true;
} else {
  $configuracao = false;
}

if (isset($_GET['editar']) && $_GET['editar'] = true) {
  $edicao = true;

  $id_conta = $_GET['id'];

  $conta_em_edicao = buscar_conta_especifica($bdConexao, $id_conta);

  $conta_edicao_nome = $conta_em_edicao['conta'];
  $conta_edicao_tipo = $conta_em_edicao['tipo_conta'];
  $conta_edicao_saldo_inicial = $conta_em_edicao['saldo_inicial'];
  $conta_edicao_exibir = $conta_em_edicao['exibir'];
} else {
  $edicao = false;

  $conta_edicao_nome = "";
  $conta_edicao_tipo = "";
  $conta_edicao_saldo_inicial = "";
  $conta_edicao_exibir = "";
}
?>

<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/contas/contas.css">
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

      <div class="container duas-colunas <?php if ($configuracao == false) : ?>com-extrato<?php else : ?>sem-bg<?php endif; ?>">

        <?php if ($configuracao != true) : ?>
          <div class="item-grid-principal">
            <h2 class="titulo-container">Contas</h2>
            <table class="tabela">
              <?php
              $contas = buscar_contas($bdConexao);

              foreach ($contas as $conta) :
                $exibir = traduz_boolean($conta['exibir'], 'Sim', 'Não');
                $saldoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM', $conta['id_con']));
                $saldoAcumulado = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM', $conta['id_con']));

                if ($saldoMes == 0) {
                  $saldoMes = "0,00";
                }
                if ($saldoAcumulado == 0) {
                  $saldoAcumulado = "0,00";
                }

                echo "<tr>
                      <td class='td-conta'><a class='filtrar' href='/contas.php?conta={$conta['id_con']}'>{$conta['conta']} <img class='icone-filtrar' src='/img/icos/filtrar.svg'></a></td>
                      <td class='td-conta'>R$ {$saldoAcumulado}</td>
                      </tr>
                      ";

              endforeach;
              ?>
            </table>
          </div>

          <div class="item-grid-secundario">

            <?php

            if (isset($_GET['conta']) && isset($mes) && isset($ano)) : ?>

              <?php $contaSelecionada = buscar_conta_especifica($bdConexao, $_GET['conta']); ?>
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

                  $totalDiasMes = days_in_month($mes, $ano);

                  for ($dia = 1; $dia <= $totalDiasMes; $dia++) :

                    $registros = buscar_registros($bdConexao, $dia, $mes, $ano, null, null, null, $_GET['conta']);

                    if (sizeof($registros) != 0) :

                      $resultadoDia = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM', $_GET['conta'], null, null, $dia));

                      $resultadoDiaAcumuladoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM', $_GET['conta'], null, null, $dia, true));

                      $resultadoDiaAcumuladoTotal = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM', $_GET['conta'], null, null, $dia));


                      foreach ($registros as $registro) :

                        $data = traduz_data_para_br($registro['data']);
                        $valor = formata_valor($registro['valor']);

                        echo "<tr class='linha-extrato'>
            <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
            <td>{$data}</td>
            <td>{$registro['descricao']}</td>
            <td class='linha-extrato-valor'>R$ {$valor}</td>
            <td>{$registro['nome_cat']}</td>
            <td class='coluna-acoes'>";
                        if ($registro['tipo'] == 'T' && $registro['valor'] > 0 or $registro['tipo'] == 'SI') {
                          echo "";
                        } else {
                          echo "<a href='extrato.php?id={$registro['id']}&editar=true#caixa-registrar'><img class='icone-editar' alt='Editar' src='/img/icos/editar.svg'/></a>";
                          echo "
            </td>
            </tr>
            ";
                        }
                      endforeach;

                      echo "
            <tr>
            <td class='linha-resultado-dia-extrato' colspan='6'> <span class='valor-resultado-dia-extrato'>Resultado diário: R$ {$resultadoDia}</span> <span class='valor-resultado-dia-extrato'>Acumulado mês: {$resultadoDiaAcumuladoMes}</span> <span class='valor-resultado-dia-extrato'>Acumulado total: R$ {$resultadoDiaAcumuladoTotal}</span> </td>
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
            <?php if (tabela_nao_esta_vazia($bdConexao, 'contas')) :
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
                  $contas = buscar_contas($bdConexao);

                  foreach ($contas as $conta) :
                    $exibir = traduz_boolean($conta['exibir'], 'Sim', 'Não');
                    $saldoInicialFormatado = formata_valor($conta['saldo_inicial']);

                    echo "<tr>
                      <td class='td-conta'>{$conta['conta']}</td>
                      <td class='td-conta'>{$conta['tipo_conta']}</td>
                      <td class='td-conta'>R$ {$saldoInicialFormatado}</td>
                      <td class='td-conta'>{$exibir}</td>
                      <td class='coluna-acoes'><a href='contas.php?id={$conta['id_con']}&configurar=true&editar=true#header'><img class='icone-editar' alt='Editar' src='/img/icos/editar.svg'/></a>
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
      <?php if ($edicao == false) :
      ?>
        <h2 class="titulo-box cadastrar">Cadastrar conta</h2>
      <?php else : ?>
        <div class="container-titulo-subtitulo">
          <h2 class="titulo-container titulo-editar com-subtitulo">Editar conta:</h2>
          <h3 class="subtitulo-container"><?php echo $conta_edicao_nome; ?></h3>
        </div>
      <?php endif; ?>
      <!-- Formulário -->
      <?php include($_SERVER["DOCUMENT_ROOT"] . '/contas/formulario_contas.php') ?>
    </div>

    </div>

  <?php endif; ?>
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

</body>

</html>