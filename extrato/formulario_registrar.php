<?php
$tiposRegistro = array('D', 'R', 'T');
$hoje = date('Y-m-d');

$id_transacao = filter_input(INPUT_GET, 'id_transacao', FILTER_VALIDATE_INT);

if ($id_transacao) {
  $transacao_especifica = buscar_reg_especifico($bdConexao, $id_transacao);

  foreach ($transacao_especifica as $transacao_em_edicao) :
    $transacao_edicao_tipo = $transacao_em_edicao['tipo'];
    $transacao_edicao_data = $transacao_em_edicao['data'];
    $transacao_edicao_descricao = $transacao_em_edicao['descricao'];
    $transacao_edicao_valor = formata_valor(abs($transacao_em_edicao['valor']), 2, ',', '.');
    $transacao_edicao_categoria = $transacao_em_edicao['id_categoria'];
    $transacao_edicao_conta = $transacao_em_edicao['id_conta'];
    $transacao_edicao_parcela = $transacao_em_edicao['parcela'];
    $transacao_edicao_total_parcelas = $transacao_em_edicao['total_parcelas'];
  endforeach;
} else {
  $transacao_edicao_tipo = '';
  $transacao_edicao_data = '';
  $transacao_edicao_descricao = '';
  $transacao_edicao_valor = '';
  $transacao_edicao_categoria = '';
  $transacao_edicao_conta = '';
  $transacao_edicao_parcela = '';
  $transacao_edicao_total_parcelas = '';
}

?>

<link rel="stylesheet" href="/extrato/formulario_registrar.css">

<form id="form-transacao" class="form-cadastrar-editar" action="/app/model/handle_form_transacao.php" method="POST">

  <?php if ($id_transacao) {
    echo "<input class='campo-id-edicao' type='text' name='id_transacao' value='{$id_transacao}' class='input-id' readonly>";
    echo "<input class='campo-id-edicao' type='text' name='parcela' value='{$transacao_edicao_parcela}' class='input-id' readonly>";
    echo "<input class='campo-id-edicao' type='text' name='total-parcelas' value='{$transacao_edicao_total_parcelas}' class='input-id' readonly>";
  }
  ?>

  <div>
    <input type="checkbox" tabindex="-1" id="fixar-tipo" class="checkbox-fixar"><label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" <?php if ($id_transacao && $transacao_edicao_tipo == 'T') {
                                    echo 'disabled';
                                  } ?>>

      <?php

      foreach ($tiposRegistro as $tipoRegistro) {

        $tipoRegistroExtenso = traduz_registro($tipoRegistro);

        if ($id_transacao == true && $tipoRegistro == $transacao_edicao_tipo) {

          echo "<option value='{$tipoRegistro}' selected>{$tipoRegistroExtenso}</option>";
        } else {
          echo "<option value='{$tipoRegistro}'>{$tipoRegistroExtenso}</option>";
        }
      }
      ?>
    </select>
  </div>
  <div>
    <input type="checkbox" tabindex="-1" id="fixar-data" class="checkbox-fixar"><label for="data">Data:</label>
    <input type="date" id="data" name="data" <?php if ($id_transacao) {
                                                echo "value='{$transacao_edicao_data}'";
                                              } else {
                                                echo "value='{$hoje}'";
                                              } ?> required />
  </div>
  <div>
    <input type="checkbox" tabindex="-1" id="fixar-valor" class="checkbox-fixar"><label for="valor">Valor:</label>
    <input id="valor" type="text" inputmode="numeric" id="valor" name="valor" <?php if ($id_transacao) {
                                                                                echo "value='{$transacao_edicao_valor}'";
                                                                              } ?> required />
  </div>
  <div>
    <input type="checkbox" tabindex="-1" id="fixar-descricao" class="checkbox-fixar"><label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" <?php if ($id_transacao) {
                                                          echo "value='{$transacao_edicao_descricao}'";
                                                        } ?> required />
  </div>

  <?php
  if ($id_transacao && $transacao_edicao_tipo == 'T') : ?>
    <div>
      <p>As contas de origem e de destino de uma transferência não podem ser editadas. Se for necessário alterá-las, você deve excluir o registro atual e cadastrá-lo novamente.</p>
    </div>
  <?php else : ?>
    <div>
      <input type="checkbox" tabindex="-1" id="fixar-conta" class="checkbox-fixar"><label for="conta">Conta:</label>

      <select id="conta" name="conta">
        <option disabled selected value>Selecione uma conta</option>
        <?php

        $tiposConta = buscar_tipos_conta();

        for ($i = 0; $i < sizeof($tiposConta); $i++) {
          echo "<optgroup label='{$tiposConta[$i]}'>";

          $contas = buscar_contas($bdConexao);

          foreach ($contas as $conta) {

            if ($conta['tipo_conta'] == $tiposConta[$i]) {

              if ($id_transacao && $conta['id_con'] == $transacao_edicao_conta) {
                echo "<option value='{$conta['id_con']}' selected>{$conta['conta']}</option>";
              } else {
                echo "<option value='{$conta['id_con']}'>{$conta['conta']}</option>";
              }
            }
          }
          echo "</optgroup>";
        }
        ?>
      </select>
    </div>

    <div>
      <input type="checkbox" tabindex="-1" id="fixar-contadestino" class="checkbox-fixar"><label for="contadestino">Conta de destino:</label>

      <select id="contadestino" name="contadestino" disabled>
        <option disabled selected value>Selecione uma conta</option>
        <?php

        $tiposConta = buscar_tipos_conta();

        for ($i = 0; $i < sizeof($tiposConta); $i++) {
          echo "<optgroup label='{$tiposConta[$i]}'>";

          $contas = buscar_contas($bdConexao);

          foreach ($contas as $conta) {

            if ($conta['tipo_conta'] == $tiposConta[$i]) {

              if ($id_transacao && $conta['id_con'] == $transacao_edicao_conta) {
                echo "<option value='{$conta['id_con']}' selected>{$conta['conta']}</option>";
              } else {
                echo "<option value='{$conta['id_con']}'>{$conta['conta']}</option>";
              }
            }
          }
          echo "</optgroup>";
        }
        ?>
      </select>
    </div>

    <div>
      <input type="checkbox" tabindex="-1" id="fixar-categoria" class="checkbox-fixar"><label for="categoria">Categoria:</label>

      <select class="choice categoria" id="categoria" name="categoria" required>

        <option disabled selected value>Selecione uma categoria</option>

        <?php
        $categoriasPrincipais = buscar_cat_principal($bdConexao);

        foreach ($categoriasPrincipais as $categoriaPrincipal) :
          echo "<optgroup label='{$categoriaPrincipal['nome_cat']}'>";

          $categoriasSecundarias = buscar_cat_secundaria($bdConexao, $categoriaPrincipal);

          foreach ($categoriasSecundarias as $categoriaSecundaria) {

            if ($id_transacao && $categoriaSecundaria['id_cat'] == $transacao_edicao_categoria) {

              echo "<option value='{$categoriaSecundaria['id_cat']}' selected>{$categoriaSecundaria['nome_cat']}</option>";
            } else {
              echo "<option value='{$categoriaSecundaria['id_cat']}'>{$categoriaSecundaria['nome_cat']}</option>";
            }
          }

          echo "</optgroup>";

        endforeach;
        ?>
      </select>
    </div>
    <?php if (!$id_transacao) : ?>
      <div>
        <input type="checkbox" tabindex="-1" id="fixar-parcelas" class="checkbox-fixar"><label for="parcelas">Parcelas:</label>
        <input id="parcelas" type="number" inputmode="numerico" min="0" step="1" id="parcelas" name="parcelas">
      </div>
    <?php endif; ?>
  <?php endif; ?>
  <?php if ($id_transacao) : ?>
    <div class="container-apagar div-checkbox">
      <input type='checkbox' id='apagar' name='apagar' value='true' />
      <label class='label-apagar' for='apagar'>Apagar registro</label>
    </div>
  <?php endif; ?>
  <?php if ($id_transacao && $transacao_edicao_parcela != null) : ?>
    <div class="container-edicao-parcelas div-checkbox">
      <input type='checkbox' id='editar-parcelas' name='editar-parcelas' value='true' />
      <label class='label-apagar' for='editar-parcelas'>Aplicar mudanças às parcelas seguintes<br></label>
    </div>
  <?php endif; ?>
  <div class="container-botao-acao-principal">
    <?php if ($id_transacao) : ?>
      <button class="botao-acao-principal" id="botao-registrar-transacao" type="submit">Confirmar alteração</button>
    <?php else : ?>
      <button class="botao-acao-principal" id="botao-registrar-transacao" type="submit">Registrar transação</button>
    <?php endif; ?>
  </div>
  <div class="opcoes-formulario">
    <span id="btn-limpar-form-transacao" class="botao-acao-secundario neutro">Limpar seleção</span>
    <span id="btn-fixar-form-transacao" class="botao-acao-secundario neutro">Manter aberto</span>
  </div>

</form>

<script src="/extrato/extrato.js" defer></script>

<script>
  //Campos SELECT com busca por meio do plugin choices.js
  const choiceConta = new Choices('#conta', {
    searchPlaceholderValue: "Digite para buscar um conta"
  });
  const choiceContaDestino = new Choices('#contadestino', {
    searchPlaceholderValue: "Digite para buscar conta"
  });
  const choiceCategoria = new Choices('#categoria', {
    searchPlaceholderValue: "Digite para buscar um categoria"
  });
</script>

<script type="text/javascript">
  function verifica(value) {
    var categoria = document.getElementById("categoria");
    var contadestino = document.getElementById("contadestino");
    var campoValor = document.getElementById("valor");
    var campoParcelas = document.getElementById("parcelas");
    var caixaRegistrar = document.getElementById("caixa-registrar");

    if (value == "T") {
      categoria.disabled = true;
      choiceCategoria.disable();
      contadestino.disabled = false;
      choiceContaDestino.enable();
      <?php if (!$id_transacao) : ?>
        parcelas.disabled = true;
        parcelas.style.cursor = "not-allowed";
      <?php endif; ?>
    } else if (value == "D" || value == "R") {
      categoria.disabled = false;
      choiceCategoria.enable();
      contadestino.disabled = true;
      choiceContaDestino.disable();
      <?php if (!$id_transacao) : ?>
        parcelas.disabled = false;
        parcelas.style.cursor = "auto";
      <?php endif; ?>
    }

    if (value == "T") {
      campoValor.style.backgroundColor = "#264b7f";
      caixaRegistrar.style.backgroundColor = "#f4f8ff";
    } else if (value == "D") {
      campoValor.style.backgroundColor = "#ad2f1b";
      caixaRegistrar.style.backgroundColor = "#ffeeec";
    } else if (value == "R") {
      campoValor.style.backgroundColor = "#3e7f26";
      caixaRegistrar.style.backgroundColor = "#f1ffec";
    }

  };

  var tipo = document.getElementById("tipo");

  tipo.addEventListener('change', function() {
    verifica(this.value)
  });

  VMasker(document.querySelector("#valor")).maskMoney({
    precision: 2,
    separator: ',',
    delimiter: '.',
    unit: 'R$',
  });
</script>