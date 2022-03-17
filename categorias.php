<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');


if (isset($_GET['configurar']) && $_GET['configurar'] == true) {
  $configuracao = true;
} else {
  $configuracao = false;
}

if (isset($_GET['editar']) && $_GET['editar'] == true) {
  $edicao = true;
  $id_cat = $_GET['id'];

  $cat_especifica = buscar_cat_especifica($bdConexao, $id_cat);
  $cat_edicao_nome = $cat_especifica['nome_cat'];
  $cat_edicao_cat_principal = $cat_especifica['cat_principal'];
  $cat_edicao_eh_cat_principal = $cat_especifica['eh_cat_principal'];
} else {
  $edicao = false;
  $cat_edicao_nome = "";
  $cat_edicao_cat_principal = "";
  $cat_edicao_eh_cat_principal = "";
}


?>

<!DOCTYPE html>
<html>

<head>
  <!-- Informações do head -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/head.php'); ?>
  <link rel="stylesheet" href="/categorias/categorias.css">
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

        <?php if (tabela_nao_esta_vazia($bdConexao, 'categorias')) :
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
                  $categoriasPrincipais = buscar_cat_principal($bdConexao);

                  foreach ($categoriasPrincipais as $categoriaPrincipal) :

                    $saldoMesCatPrincipal = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM', null, null,  $categoriaPrincipal['nome_cat']));


                    echo "<tr class='cat-principal'>
          <td class='td-cat-principal'>{$categoriaPrincipal['nome_cat']}</td>";

                    if ($configuracao != true) :

                      echo "<td>R$ {$saldoMesCatPrincipal}</td>";

                    endif;

                    if ($configuracao == true) {
                      echo "
          <td class='coluna-acoes'><a href='categorias.php?id={$categoriaPrincipal['id_cat']}&configurar=true&editar=true#header'><img class='icone-editar' alt='Editar' src='/img/icos/editar.svg'/></a>";
                    }

                    echo "</tr>";

                    $categoriasSecundarias = buscar_cat_secundaria($bdConexao, $categoriaPrincipal);

                    foreach ($categoriasSecundarias as $categoriaSecundaria) :

                      $saldoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM', null, $categoriaSecundaria['id_cat']));

                      echo "<tr>";

                      if ($configuracao != true) :
                        echo "<td class='td-cat-secundaria'><a class='filtrar' href='categorias.php?categoria={$categoriaSecundaria['id_cat']}'>{$categoriaSecundaria['nome_cat']} <img class='icone-filtrar' src='/img/icos/filtrar.svg'></a></td>";

                      else :
                        echo "<td class='td-cat-secundaria'>{$categoriaSecundaria['nome_cat']}</td>";

                      endif;

                      if ($configuracao != true) :

                        echo "<td>R$ {$saldoMes}</td>";

                      endif;

                      if ($configuracao == true) {
                        echo "
          <td class='coluna-acoes'><a href='categorias.php?id={$categoriaSecundaria['id_cat']}&configurar=true&editar=true#header'><img class='icone-editar' alt='Editar' src='img/icos/editar.svg'/></a></td>";
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
              <p>Não há categorias cadastradas</p>
              <div>
              <?php endif; ?>
              </div>

              <?php if ($configuracao != true) : ?>
                <div class="item-grid-secundario">
                  <?php if (isset($_GET['categoria']) && isset($mes) && isset($ano)) : ?>

                    <?php $catSelecionada = buscar_cat_especifica($bdConexao, $_GET['categoria']);

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

                          $totalDiasMes = days_in_month($mes, $ano);

                          for ($dia = 1; $dia <= $totalDiasMes; $dia++) :

                            $registros = buscar_registros($bdConexao, $dia, $mes, $ano, null, null, $_GET['categoria']);

                            if (sizeof($registros) != 0) :

                              $resultadoDia = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SSM', null, $_GET['categoria'], null, $dia));

                              $resultadoDiaAcumuladoMes = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria'], null, $dia, true));

                              $resultadoDiaAcumuladoTotal = formata_valor(calcula_resultado($bdConexao, $mes, $ano, 'SAM', null, $_GET['categoria'], null, $dia));

                              foreach ($registros as $registro) :

                                $data = traduz_data_para_br($registro['data']);
                                $valor = formata_valor($registro['valor']);

                                echo "<tr class='linha-extrato'>
          <td class='linha-extrato-tipo'>{$registro['tipo']}</td>
          <td>{$data}</td>
          <td>{$registro['descricao']}</td>
          <td class='linha-extrato-valor'>R$ {$valor}</td>
          <td>{$registro['conta']}</td>
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
              <td class='linha-resultado-dia-extrato' colspan='6' class='linha-resultado-dia-extrato'> <span class='valor-resultado-dia-extrato'>Resultado diário: R$ {$resultadoDia}</span> <span class='valor-resultado-dia-extrato'>Acumulado mês: {$resultadoDiaAcumuladoMes}</span> <span class='valor-resultado-dia-extrato'>Acumulado total: R$ {$resultadoDiaAcumuladoTotal}</span> </td>
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
                  <?php if ($edicao == false) :
                  ?>
                    <h2 class="titulo-box cadastrar">Cadastrar categoria</h2>
                  <?php else : ?>
                    <div class="container-titulo-subtitulo">
                      <h2 class="titulo-container titulo-editar com-subtitulo">Editar categoria</h2>
                      <h3 class="subtitulo-container"><?php echo $cat_edicao_nome; ?></h3>
                    </div>
                  <?php endif; ?>
                  <!-- Formulário -->
                  <?php include('categorias/formulario_cat.php') ?>
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

  <script src="/categorias/categorias.js" defer></script>

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