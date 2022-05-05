<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/transaction/get_especific_transaction.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/transaction/parse_transaction_type.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/get_account_types.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/get_accounts.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_secondary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/format_value.php');


$tiposRegistro = array('D', 'R', 'T');
$hoje = date('Y-m-d');

$id_transacao = filter_input(INPUT_GET, 'id_transacao', FILTER_VALIDATE_INT);

if ($id_transacao) {
  $transacao_especifica = get_especific_transaction($bdConexao, $id_transacao);

  foreach ($transacao_especifica as $transacao_em_edicao) :
    $transacao_edicao_tipo = $transacao_em_edicao['tipo'];
    $transacao_edicao_data = $transacao_em_edicao['data'];
    $transacao_edicao_descricao = $transacao_em_edicao['descricao'];
    $transacao_edicao_valor = format_value(abs($transacao_em_edicao['valor']), 2, ',', '.');
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

<form id="form-transacao" class="form-cadastrar-editar" action="/app/form_handler/handle_transaction.php" method="POST">

  <?php if ($id_transacao) {
    echo "<input class='campo-id-edicao' type='text' name='id_transacao' value='{$id_transacao}' class='input-id' readonly>";
    echo "<input class='campo-id-edicao' type='text' name='parcela' value='{$transacao_edicao_parcela}' class='input-id' readonly>";
    echo "<input class='campo-id-edicao' type='text' name='total-parcelas' value='{$transacao_edicao_total_parcelas}' class='input-id' readonly>";
  }
  ?>

  <div>
    <span class="checkbox-fixar" id="fixar-tipo"></span>
    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" <?php if ($id_transacao && $transacao_edicao_tipo == 'T') {
                                    echo 'disabled';
                                  } ?>>

      <?php

      foreach ($tiposRegistro as $tipoRegistro) {

        $tipoRegistroExtenso = parse_transaction_type($tipoRegistro);

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
    <span class="checkbox-fixar" id="fixar-valor"></span>
    <label for="valor">Valor:</label>
    <input id="valor" type="text" inputmode="numeric" id="valor" name="valor" <?php if ($id_transacao) {
                                                                                echo "value='{$transacao_edicao_valor}'";
                                                                              } ?> required />
  </div>

  <div>
    <span class="checkbox-fixar" id="fixar-data"></span>
    <label for="data">Data:</label>
    <input type="date" id="data" name="data" <?php if ($id_transacao) {
                                                echo "value='{$transacao_edicao_data}'";
                                              } else {
                                                echo "value='{$hoje}'";
                                              } ?> required />
  </div>
  <div>
    <span class="checkbox-fixar" id="fixar-descricao"></span>
    <label for="descricao">Descrição:</label>
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
      <span class="checkbox-fixar" id="fixar-conta"></span>
      <label for="conta">Conta:</label>

      <select id="conta" name="conta">
        <option disabled selected value>Selecione uma conta</option>
        <?php

        $tiposConta = get_account_types();

        for ($i = 0; $i < sizeof($tiposConta); $i++) {
          echo "<optgroup label='{$tiposConta[$i]}'>";

          $contas = get_accounts($bdConexao);

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
      <span class="checkbox-fixar" id="fixar-contadestino"></span>
      <label for="contadestino">Conta de destino:</label>

      <select id="contadestino" name="contadestino" disabled>
        <option disabled selected value>Selecione uma conta</option>
        <?php

        $tiposConta = get_account_types();

        for ($i = 0; $i < sizeof($tiposConta); $i++) {
          echo "<optgroup label='{$tiposConta[$i]}'>";

          $contas = get_accounts($bdConexao);

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
      <span class="checkbox-fixar" id="fixar-categoria"></span>
      <label for="categoria">Categoria:</label>

      <select class="choice categoria" id="categoria" name="categoria" required>

        <option disabled selected value>Selecione uma categoria</option>

        <?php
        $categoriasPrincipais = get_primary_categories($bdConexao);

        foreach ($categoriasPrincipais as $categoriaPrincipal) :
          echo "<optgroup label='{$categoriaPrincipal['nome_cat']}'>";

          $categoriasSecundarias = get_secondary_categories($bdConexao, $categoriaPrincipal);

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
        <span class="checkbox-fixar" id="fixar-parcelas"></span>
        <label for="parcelas">Parcelas:</label>
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
    <span id="btn-fixar-form-transacao" class="botao-acao-secundario neutro">Manter aberto</span>
    <span id="btn-limpar-form-transacao" class="botao-acao-secundario neutro">Limpar fixadores</span>
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
  VMasker(document.querySelector("#valor")).maskMoney({
    precision: 2,
    separator: ',',
    delimiter: '.',
    unit: 'R$',
  });
</script>