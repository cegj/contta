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

  <!-- Caixas de saldos -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/saldos.php'); ?>

  <!-- Opções -->
  <?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/opcoes.php'); ?>

  <?php

  if (isset($_POST['campo-categoria']) && isset($_POST['campo-mes']) && isset($_POST['campo-valor'])) {
    $catEmEdicao = $_POST['campo-categoria'];
    $mesEmEdicao = $_POST['campo-mes'];
    $novoValor = $_POST['campo-valor'];

    update_budget_value($bdConexao, $catEmEdicao, $mesEmEdicao, $novoValor);
  }

  ?>

  <script type="text/javascript">
    var ultimaIdEditada;
    //ID = 28/janeiro
    function abrirEdicao(id) {

      if (ultimaIdEditada != undefined) {
        ultimaIdEditada.classList.remove('em-edicao');
      }

      var idEmEdicao = document.getElementById(id);
      var idArray = id.split('/');
      var categoriaId = idArray[0];
      var categoriaNome = document.getElementById(categoriaId).innerText;
      var mes = idArray[1];
      var valorString = document.getElementById(id).innerText;
      var valor = valorString.replace(/\./g, "").replace(/,/g, ".");

      var valorExecutado = document.getElementById(id + "-executado").innerText;
      var campoValorExecutado = document.getElementById('campo-valor-executado');

      var formAlteracao = document.getElementById('form-alteracao');
      var campoCategoria = document.getElementById('campo-categoria');
      var campoMes = document.getElementById('campo-mes');
      var campoValor = document.getElementById('campo-valor');
      var botaoCancelar = document.getElementById('botao-cancelar');
      var containerFormAlteracao = document.getElementById('container-alteracao-orcamento');

      formAlteracao.setAttribute("action", "#" + id);
      campoCategoria.value = categoriaId;
      campoMes.value = mes;
      campoValorExecutado.value = valorExecutado;
      campoValor.value = valor;
      formAlteracao.style.display = "flex";
      botaoCancelar.style.display = "inline-block";

      document.getElementById('nome-cat-label').innerText = categoriaNome;
      document.getElementById('mes-label').innerText = mes;
      containerFormAlteracao.style.display = "block";
      idEmEdicao.classList.add('em-edicao');

      ultimaIdEditada = idEmEdicao;

      campoValor.focus();
    }

    function fecharEdicao() {
      var formAlteracao = document.getElementById('form-alteracao');
      var botaoCancelar = document.getElementById('botao-cancelar');
      var containerFormAlteracao = document.getElementById('container-alteracao-orcamento');

      containerFormAlteracao.style.display = "none";

      if (ultimaIdEditada != undefined) {
        ultimaIdEditada.classList.remove('em-edicao');
      }

    }

    function copiarValorExecutado() {
      var campoValor = document.getElementById('campo-valor');
      var valorExecutadoString = document.getElementById('campo-valor-executado').value;
      var valorExecutado = valorExecutadoString.replace(/\./g, "");

      campoValor.value = valorExecutado;

    }
  </script>

  <div class="box formulario" id="container-alteracao-orcamento">
    <div class="container-form-botoes">
      <form style="display:none" class="form-alteracao-orcamento" id="form-alteracao" method="POST">
        <input style='display: none' type="number" id="campo-categoria" name="campo-categoria" readonly />
        <input style='display: none' type="text" id="campo-mes" name="campo-mes" readonly />
        <input style='display: none' type="text" id="campo-valor-executado" readonly />
        <img src="/img/icos/editar.svg" class="icone-editar" alt="Editar">
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

                  <img class='icone-filtrar' src='/img/icos/filtrar.svg'>

                </a>

              <?php endif; ?>

            </td>
            <td class="valor-resultado money
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

              <td class="valor-previsto money
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

              <td id="<?php echo $dadoOrcamento['id_cat'] . "/" . $meses[$i] . "-executado" ?>" class="valor-executado money
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

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-previsto money
                    <?php if (check_selected_month_budget($meses[$i], $mes)) {
                      echo "mes-selecionado";
                    } ?>">

            <?php echo format_value(sum_budget_value($bdConexao, $meses[$i])) ?>

          </td>

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado money
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

        <td class="valor-resultado money" name="<?php echo "{$linha['total']}"; ?>">
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

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado money
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

                  <img class='icone-filtrar' src='/img/icos/filtrar.svg'>

                </a>

              <?php endif; ?>

            </td>

            <td class="valor-resultado money
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

              <td class="valor-previsto money
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

              <td id="<?php echo $dadoOrcamento['id_cat'] . "/" . $meses[$i] . "-executado" ?>" class="valor-executado money
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

        <td class="valor-resultado money" name="<?php echo "{$linha['total']}"; ?>">
        </td>

        <?php for ($i = 6; $i < 12; $i++) : ?>

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-previsto money
                  <?php if (check_selected_month_budget($meses[$i], $mes)) {
                    echo "mes-selecionado";
                  } ?>">

            <?php echo format_value(sum_budget_value($bdConexao, $meses[$i])) ?>

          </td>

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado money
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

        <td class="valor-resultado money" name="<?php echo "{$linha['total']}"; ?>">
        </td>

        <?php for ($i = 6; $i < 12; $i++) : ?>

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-previsto money
                  <?php if (check_selected_month_budget($meses[$i], $mes)) {
                    echo "mes-selecionado";
                  } ?>">

            <?php $acumuladoAnoPrevisto = $acumuladoAnoPrevisto + sum_budget_value($bdConexao, $meses[$i]);

            echo format_value($acumuladoAnoPrevisto);  ?>

          </td>

          <td name="<?php echo "{$meses[$i]}-{$linha['total']}"; ?>" class="resultado-executado money
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

  <!-- Calcular e exibir a diferença entre previsto e executado via javascript -->
  <script type="text/javascript">
    function converteNumeroParaMes(num) {
      var mesExtenso;

      switch (num) {
        case '01':
          mesExtenso = 'janeiro';
          break;
        case '02':
          mesExtenso = 'fevereiro';
          break;
        case '03':
          mesExtenso = 'março';
          break;
        case '04':
          mesExtenso = 'abril';
          break;
        case '05':
          mesExtenso = 'maio';
          break;
        case '06':
          mesExtenso = 'junho';
          break;
        case '07':
          mesExtenso = 'julho';
          break;
        case '08':
          mesExtenso = 'agosto';
          break;
        case '09':
          mesExtenso = 'setembro';
          break;
        case '10':
          mesExtenso = 'outubro';
          break;
        case '11':
          mesExtenso = 'novembro';
          break;
        case '12':
          mesExtenso = 'dezembro';
          break;
      }

      return mesExtenso;
    }

    window.mes = '<?= $mes ?>';

    var mesSelecionado = converteNumeroParaMes(window.mes);

    var linhasOrcamento = document.getElementsByClassName('linha');

    if (mes <= 6) {
      linhaOrcamento = 0;
    } else {
      linhaOrcamento = <?php echo $linha['parcial']; ?>
    }

    for (linhaOrcamento; linhaOrcamento <= linhasOrcamento.length; linhaOrcamento++) {

      var nameHtml = mesSelecionado + "-" + linhaOrcamento;

      var valores = document.getElementsByName(nameHtml);
      var celulaResultado = document.getElementsByName(linhaOrcamento);

      if (valores[0] != undefined) {
        var valorPrevistoString = (valores[0].innerText).replace(/\./g, '').replace(/\,/g, '.');
        var valorExecutadoString = (valores[1].innerText).replace(/\./g, '').replace(/\,/g, '.');

        valorPrevisto = parseFloat(valorPrevistoString).toFixed(2);
        valorExecutado = parseFloat(valorExecutadoString).toFixed(2);


        if (valorExecutado <= 0) {
          var resultado = Math.abs(valorPrevisto) - Math.abs(valorExecutado);
        } else if (valorExecutado > 0) {
          var resultado = Math.abs(valorExecutado) - Math.abs(valorPrevisto);
        }

        var resultadoConvertido = Intl.NumberFormat('pt-BR', {
          style: 'decimal',
          currency: 'BRL',
          minimumFractionDigits: '2'
        }).format(resultado)

        celulaResultado[0].innerText = resultadoConvertido;

        if (resultado > 0) {
          celulaResultado[0].style.color = "green";
        } else if (resultado < 0) {
          celulaResultado[0].style.color = "red";
        } else {
          celulaResultado[0].style.color = "lightgray";
        }
      }

    }
  </script>

</main>

<script type="text/javascript">
  document.querySelector('body').addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {
      fecharEdicao();
    }

  });
</script>