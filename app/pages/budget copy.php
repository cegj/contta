<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/update_budget_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/get_budget.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/sum_budget_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/check_selected_month_budget.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_secondary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/format_value.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/database/there_is_no_table.php');

$edicao = false;

?>

<script>
  if (screen.width < 640) {
    window.location.href = '/orcamento-m.php';
  }
</script>

<main class="container-principal">

  <!-- Balance boxes -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/balance-boxes.php'); ?>

  <!-- Context options bar -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/app/pages/modules/context-options.php'); ?>

  <?php

  if (isset($_POST['campo-categoria']) && isset($_POST['campo-mes']) && isset($_POST['campo-valor'])) {
    $catEmEdicao = $_POST['campo-categoria'];
    $mesEmEdicao = $_POST['campo-mes'];
    $novoValor = $_POST['campo-valor'];

    update_budget_value($bdConexao, $catEmEdicao, $mesEmEdicao, $novoValor);
  }

  ?>

  <div class="box formulario" id="container-alteracao-orcamento">
    <div class="container-form-botoes">
      <form style="display:none" class="form-alteracao-orcamento" id="form-alteracao" method="POST">
        <input style='display: none' type="number" id="campo-categoria" name="campo-categoria" readonly />
        <input style='display: none' type="text" id="campo-mes" name="campo-mes" readonly />
        <input style='display: none' type="text" id="campo-valor-executado" readonly />
        <img src="/assets/img/ico/edit.svg" class="icone-editar" alt="Editar">
        <label for="valor">Alterar o valor de <span id="nome-cat-label"></span> no mês de <span id=mes-label></span>:</label>
        <input type="number" step="any" id="campo-valor" name="campo-valor" />
        <button class="botao-acao-secundario confirmar" type="submit">Alterar</button>
      </form>
      <button onclick="copiarValorExecutado()" class="botao-acao-secundario neutro" id="botao-copiar">Copiar executado</button>
      <button onclick="fecharEdicao()" class="botao-acao-secundario cancelar" id="botao-cancelar" style="display:none">Cancelar</button>
    </div>
    <p><strong>Importante:</strong> a previsão de despesas deve ser informada em valores negativos.</p>
  </div>

  <div class="container uma-coluna">
    <h2 class="titulo-container">Orçamento</h2>

    <table class="tabela orcamento">

      <?php $meses = array('janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'); ?>

      <!-- PRIMEIRA PARTE DA TABELA (PRIMEIRO SEMESTRE)   -->

      <thead>
        <tr>

          <th rowspan="2" class="titulo-coluna-categoria filtrar-titulo">
            Categoria
          </th>

          <th rowspan="2" class="titulo-coluna-resultado">
            Resultado
          </th>

          <?php for ($i = 0; $i < 6; $i++) : ?>

            <th colspan="2">
              <?php echo $meses[$i]; ?>
            </th>

          <?php endfor; ?>

        </tr>
        <tr>

          <?php $acumuladoAnoPrevisto = 0; ?>

          <?php for ($i = 1; $i <= 6; $i++) : ?>

            <th>
              Prev.
            </th>
            <th>
              Exec.
            </th>

          <?php endfor; ?>

        </tr>

      </thead>

      <?php

      $categoriasPrincipais = get_primary_categories($bdConexao);

      $linha = ['total' => 0, 'parcial' => 0];

      foreach ($categoriasPrincipais as $categoriaPrincipal) :

        $dadosOrcamento = get_budget($bdConexao, $categoriaPrincipal['nome_cat']);

        foreach ($dadosOrcamento as $dadoOrcamento) : ?>

          <tr class="linha
                      <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                        echo 'cat-principal';
                      } ?>">

            <td id="<?php echo $dadoOrcamento['id_cat']; ?>" class="nome-cat <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                                                                                echo "cat-principal";
                                                                              } ?>">

              <?php if ($dadoOrcamento['eh_cat_principal'] == false) : ?>

                <a class="filtrar" href="/categorias.php?categoria=<?php echo $dadoOrcamento['id_cat'] ?>">

                <?php endif; ?>

                <?php echo $dadoOrcamento['nome_cat']; ?>

                <?php if ($dadoOrcamento['eh_cat_principal'] == false) : ?>

                  <img class='icone-filtrar' src='/assets/img/ico/filter.svg'>

                </a>

              <?php endif; ?>

            </td>
            
            <td data-money class="valor-resultado
                      <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                        echo "cat-principal";
                      } ?>" name="<?php echo $linha['total']; ?>">
            </td>

            <?php for ($i = 0; $i < 6; $i++) : ?>

              <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                $previstoMesCat = sum_budget_value($bdConexao, $meses[$i], $dadoOrcamento['nome_cat']);
              } else {
                $previstoMesCat = $dadoOrcamento[$meses[$i]];
              }
              ?>

              <td data-money class="valor-previsto 
                      <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                        echo "cat-principal";
                      } ?>
                      <?php if (check_selected_month_budget($meses[$i], $mes)) {
                        echo "mes-selecionado";
                      } ?>
                      <?php if ($previstoMesCat == 0) {
                        echo "zerado";
                      } ?>" name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" id="<?php echo $dadoOrcamento['id_cat'] . "/" . $meses[$i] ?>" <?php if ($dadoOrcamento['eh_cat_principal'] != true) : ?> ondblclick="abrirEdicao('<?php echo $dadoOrcamento['id_cat'] . '/' . $meses[$i] ?>')" <?php endif; ?>>

                <?php echo format_value($previstoMesCat); ?>

              </td>

              <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                $mesNum = $i + 1;
                $resultadoMesCat = calculate_result($bdConexao, $mesNum, $ano, 'SSM', null, null, $dadoOrcamento['nome_cat']);
              } else {
                $mesNum = $i + 1;
                $resultadoMesCat = calculate_result($bdConexao, $mesNum, $ano, 'SSM', null, $dadoOrcamento['id_cat']);
              }
              ?>

              <td data-money id="<?php echo $dadoOrcamento['id_cat'] . "/" . $meses[$i] . "-executado" ?>" class="valor-executado
                        <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                          echo "cat-principal";
                        } ?>
                        <?php if (check_selected_month_budget($meses[$i], $mes)) {
                          echo "mes-selecionado";
                        } ?>
                        <?php if ($resultadoMesCat == 0) {
                          echo "zerado";
                        } ?>" name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>">

                <?php echo format_value($resultadoMesCat); ?>

              </td>

            <?php endfor; ?>
          </tr>

          <?php
          $linha['total']++;
          $linha['parcial']++;
          ?>

        <?php endforeach; ?>

      <?php endforeach; ?>

      <tr class="linha resultado">

        <td>
          Resultado mês:
        </td>

        <td class="valor-resultado money" name="<?php echo "{$linha['total']}"; ?>">
        </td>

        <?php for ($i = 0; $i < 6; $i++) : ?>

          <td data-money name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-previsto 
                    <?php if (check_selected_month_budget($meses[$i], $mes)) {
                      echo "mes-selecionado";
                    } ?>">

            <?php echo format_value(sum_budget_value($bdConexao, $meses[$i])) ?>

          </td>

          <td data-money name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado 
                  <?php if (check_selected_month_budget($meses[$i], $mes)) {
                    echo "mes-selecionado";
                  } ?>">

            <?php echo format_value(calculate_result($bdConexao, $i + 1, $ano, 'SSM')) ?>

          </td>

        <?php
        endfor;
        $linha['total']++;
        $linha['parcial']++;
        ?>

      </tr>

      <tr class="linha resultado">

        <td>
          Acumulado ano:
        </td>

        <td data-money class="valor-resultado" name="<?php echo "{$linha['total']}"; ?>">
        </td>

        <?php for ($i = 0; $i < 6; $i++) : ?>

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-previsto money
                    <?php if (check_selected_month_budget($meses[$i], $mes)) {
                      echo "mes-selecionado";
                    } ?>">

            <?php $acumuladoAnoPrevisto = $acumuladoAnoPrevisto + sum_budget_value($bdConexao, $meses[$i]);

            echo format_value($acumuladoAnoPrevisto);

            ?>

          </td>

          <td data-money name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado 
                     <?php if (check_selected_month_budget($meses[$i], $mes)) {
                        echo "mes-selecionado";
                      } ?>">

            <?php echo format_value(calculate_result($bdConexao, $i + 1, $ano, 'SAM')) ?>

          </td>

        <?php
        endfor;
        $linha['total']++;
        ?>

      </tr>

      <!-- SEGUNDA PARTE DA TABELA (SEGUNDO SEMESTRE) -->

      <?php
      $linha['parcial']++;
      ?>

      <thead>

        <tr>
          <th class="filtrar-titulo" rowspan="2">
            Categoria
          </th>

          <th rowspan="2">
            Resultado
            </td>

            <?php for ($i = 6; $i < 12; $i++) : ?>

          <th colspan="2">
            <?php echo $meses[$i]; ?>
          </th>

        <?php endfor; ?>

        </tr>

        <tr>

          <?php for ($i = 7; $i <= 12; $i++) : ?>

            <th>
              Prev.
            </th>

            <th>
              Exec.
            </th>

          <?php endfor; ?>

        </tr>

      </thead>

      <?php

      $categoriasPrincipais = get_primary_categories($bdConexao);

      foreach ($categoriasPrincipais as $categoriaPrincipal) :

        $dadosOrcamento = get_budget($bdConexao, $categoriaPrincipal['nome_cat']);

        foreach ($dadosOrcamento as $dadoOrcamento) :
      ?>

          <tr class="linha
                <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                  echo 'cat-principal';
                } ?>">

            <td id="<?php echo $dadoOrcamento['id_cat']; ?>" class="nome-cat <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                                                                                echo "cat-principal";
                                                                              } ?>">
              <?php if ($dadoOrcamento['eh_cat_principal'] == false) : ?>

                <a class="filtrar" href="/categorias.php?categoria=<?php echo $dadoOrcamento['id_cat'] ?>">

                <?php endif; ?>

                <?php echo $dadoOrcamento['nome_cat']; ?>

                <?php if ($dadoOrcamento['eh_cat_principal'] == false) : ?>

                  <img class='icone-filtrar' src='/assets/img/ico/filter.svg'>

                </a>

              <?php endif; ?>

            </td>

            <td data-money class="valor-resultado 
                  <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                    echo "cat-principal";
                  } ?>" name="<?php echo $linha['total']; ?>">
            </td>

            <?php for ($i = 6; $i < 12; $i++) : ?>

              <?php
              if ($dadoOrcamento['eh_cat_principal'] == true) {
                $previstoMesCat = sum_budget_value($bdConexao, $meses[$i], $dadoOrcamento['nome_cat']);
              } else {
                $previstoMesCat = $dadoOrcamento[$meses[$i]];
              }
              ?>

              <td data-money class="valor-previsto 
                  <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                    echo "cat-principal";
                  } ?>
                  <?php if (check_selected_month_budget($meses[$i], $mes)) {
                    echo "mes-selecionado";
                  } ?>
                  <?php if ($previstoMesCat == 0) {
                    echo 'zerado';
                  } ?>" name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" id="<?php echo $dadoOrcamento['id_cat'] . "/" . $meses[$i] ?>" <?php if ($dadoOrcamento['eh_cat_principal'] != true) : ?> ondblclick="abrirEdicao('<?php echo $dadoOrcamento['id_cat'] . '/' . $meses[$i] ?>')" <?php endif; ?>>

                <?php echo format_value($previstoMesCat); ?>

              </td>

              <?php
              if ($dadoOrcamento['eh_cat_principal'] == true) {
                $mesNum = $i + 1;
                $resultadoMesCat = calculate_result($bdConexao, $mesNum, $ano, 'SSM', null, null, $dadoOrcamento['nome_cat']);
              } else {
                $mesNum = $i + 1;
                $resultadoMesCat = calculate_result($bdConexao, $mesNum, $ano, 'SSM', null, $dadoOrcamento['id_cat']);
              }
              ?>

              <td data-money id="<?php echo $dadoOrcamento['id_cat'] . "/" . $meses[$i] . "-executado" ?>" class="valor-executado 
                   <?php if ($dadoOrcamento['eh_cat_principal'] == true) {
                      echo "cat-principal";
                    } ?>
                   <?php if (check_selected_month_budget($meses[$i], $mes)) {
                      echo "mes-selecionado";
                    } ?>
                   <?php if ($resultadoMesCat == 0) {
                      echo "zerado";
                    } ?>" name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>">

                <?php echo format_value($resultadoMesCat); ?>

              </td>

            <?php endfor; ?>

          </tr>

          <?php $linha['total']++; ?>

        <?php endforeach; ?>

      <?php endforeach; ?>

      <tr class="linha resultado">

        <td>
          Resultado mês:
        </td>

        <td data-money class="valor-resultado" name="<?php echo "{$linha['total']}"; ?>">
        </td>

        <?php for ($i = 6; $i < 12; $i++) : ?>

          <td data-money name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-previsto 
                  <?php if (check_selected_month_budget($meses[$i], $mes)) {
                    echo "mes-selecionado";
                  } ?>">

            <?php echo format_value(sum_budget_value($bdConexao, $meses[$i])) ?>

          </td>

          <td data-money name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado 
                  <?php if (check_selected_month_budget($meses[$i], $mes)) {
                    echo "mes-selecionado";
                  } ?>">

            <?php echo format_value(calculate_result($bdConexao, $i + 1, $ano, 'SSM')) ?>

          </td>

        <?php
        endfor;
        $linha['total']++;
        $linha['parcial']++;
        ?>

      </tr>

      <tr class="linha resultado">

        <td>
          Acumulado ano:
        </td>

        <td data-money class="valor-resultado" name="<?php echo "{$linha['total']}"; ?>">
        </td>

        <?php for ($i = 6; $i < 12; $i++) : ?>

          <td data-money name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-previsto 
                  <?php if (check_selected_month_budget($meses[$i], $mes)) {
                    echo "mes-selecionado";
                  } ?>">

            <?php $acumuladoAnoPrevisto = $acumuladoAnoPrevisto + sum_budget_value($bdConexao, $meses[$i]);

            echo format_value($acumuladoAnoPrevisto);  ?>

          </td>

          <td data-money name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado 
            <?php if (check_selected_month_budget($meses[$i], $mes)) {
              echo "mes-selecionado";
            } ?>">

            <?php echo format_value(calculate_result($bdConexao, $i + 1, $ano, 'SAM')) ?>

          </td>

        <?php
        endfor;
        $linha['total']++;
        ?>

      </tr>

    </table>

  </div>
</main>