<?php include('partes-template/includesiniciais.php');

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

    <!-- Cabeçalho -->
    <header>
      <?php include('partes-template/cabecalho.php') ?>
      <!-- Menu principal -->
      <?php include('partes-template/menu.php') ?>
    </header>

    <div class="container-form-mes-ano">
        <!-- Formulário de definição de mês e ano -->
        <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/form_mes_ano.php'); ?>
      </div>

    <main class="container-principal contas-container">

    <div class="caixa visao-geral-contas">
      <h2 class="caixa-formulario-titulo">Contas</h2>
      <table class="tabela">
        <tr>
        <th class="filtrar-titulo" rowspan="2">Conta</th>
        <th colspan="2">Saldo</th>
        </tr>
        <tr>
          <th>Mês</th>
          <th>Acumulado</th>
        </tr>
        <?php
        $contas = buscar_contas($bdConexao);

        foreach ($contas as $conta) :
          $exibir = traduz_boolean($conta['exibir'], 'Sim', 'Não');
          $saldoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'CSM', $conta['id_con']));
          $saldoAcumulado = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'CAM', $conta['id_con']));

          if ($saldoMes == 0) {
            $saldoMes = "0,00";
          } if ($saldoAcumulado == 0) {
            $saldoAcumulado = "0,00";
          }

          echo "<tr>
          <td class='td-conta'><a class='filtrar' href='/contas.php?conta={$conta['id_con']}'>{$conta['conta']} <img class='icone-filtrar' src='/img/icos/filtrar.svg'></a></td>
          <td class='td-conta'>R$ {$saldoMes}</td>
          <td class='td-conta'>R$ {$saldoAcumulado}</td>
          </tr>
          ";

        endforeach;
        ?>
      </table>
      </div>

    <div class="caixa extrato-contas">
        <?php if(isset($_GET['conta']) && isset($mes) && isset($ano)) : ?>

          <?php $contaSelecionada = buscar_conta_especifica($bdConexao, $_GET['conta']); ?>

          <h2 class="titulo extrato com-subtitulo">Extrato da conta</h2>
          <h3><?php echo $contaSelecionada['conta']?></h3>

          <div class="dentro-caixa">
          <span class="resultado-extrato">Resultado do mês: <strong>
              <?php
              $resultadoMes = calcula_resultado($bdConexao, $mes, $ano, 'CSM', $_GET['conta']);
              echo "R$ " . $resultadoMes;
              ?>
            </strong>
          </span>
          <br>
          <span class="resultado-extrato">Resultado acumulado: <strong>
              <?php
              $resultadoTotal = calcula_resultado($bdConexao, $mes, $ano, 'CAM', $_GET['conta']);
              echo "R$ " . $resultadoTotal;
              ?>
            </strong>
          </span>
        </div>
          <div class="container-tabela">
          <table class="tabela tabela-responsiva">
            <thead>
              <tr>
                <th class="linha-fixa">Tipo</th>
                <th class="linha-fixa">Data</th>
                <th class="linha-fixa">Descrição</th>
                <th class="linha-fixa">Valor</th>
                <th class="linha-fixa">Categoria</th>
                <th class="linha-fixa">Editar</th>
              </tr>
            </thead>
            <tr>
            <?php $registros = buscar_registros($bdConexao, null, $mes, $ano, false, null, null, $_GET['conta'], true);

            foreach ($registros as $registro) :

              $data = traduz_data_para_br($registro['data']);
              $valor = formata_valor($registro['valor']);

              echo "<tr class='linha-extrato'>
            <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
            <td>{$data}</td>
            <td>{$registro['descricao']}</td>
            <td class='linha-extrato-valor'>R$ {$valor}</td>
            <td>{$registro['nome_cat']}</td>
            <td>";
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
            ?>
            </tr>
            </table>
            </div>
            <?php else : ?>
            <p class="instrucao">Escolha uma conta para ver o seu histórico no mês selecionado.</p>
            <?php endif; ?>
            </div>

      <div class="caixa">
        <?php if ($edicao == false) :
        ?>
          <h2 class="titulo cadastrar">Cadastrar conta</h2>
        <?php else : ?>
          <h2 class="titulo editar com-subtitulo">Editar conta:</h2>
          <h3><?php echo $conta_edicao_nome; ?></h3>
        <?php endif; ?>
        <!-- Formulário -->
        <?php include($_SERVER["DOCUMENT_ROOT"] . '/contas/formulario_contas.php') ?>
      </div>
      <div class="caixa">
        <?php if (tabela_nao_esta_vazia($bdConexao, 'contas')) :
        ?>
          <h2 class="inline-block">Detalhes das contas</h2><span class="botao-ver-ocultar">Ver / ocultar</span>
          <table class="tabela tabela-responsiva" id="tabela-contas-cadastradas">
            <thead>
              <tr>
                <th>Conta</th>
                <th>Tipo</th>
                <th>Saldo inicial</th>
                <th>Exibir</th>
                <th>Editar</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $contas = buscar_contas($bdConexao);

              foreach ($contas as $conta) :
                $exibir = traduz_boolean($conta['exibir'], 'Sim', 'Não');
                $saldoInicialFormatado = formata_valor($conta['saldo_inicial']);

                echo "<tr>
          <td class='td-conta'><a href='/contas.php?conta={$conta['id_con']}'>{$conta['conta']}</a></td>
          <td class='td-conta'>{$conta['tipo_conta']}</td>
          <td class='td-conta'>R$ {$saldoInicialFormatado}</td>
          <td class='td-conta'>{$exibir}</td>
          <td><a href='contas.php?id={$conta['id_con']}&editar=true#form-contas'><img class='icone-editar' alt='Editar' src='/img/icos/editar.svg'/></a>
          </tr>
          ";

              endforeach;
              ?>
            </tbody>
          </table>

        <?php else : ?>

          <p>Não há contas cadastradas</p>

        <?php endif; ?>
      </div>
    </main>
    <!-- Rodapé -->
    <footer>
      <?php include('partes-template/rodape.php') ?>
    </footer>

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