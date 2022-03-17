<?php
$tiposRegistro = array('D', 'R', 'T');
$hoje = date('Y-m-d');
?>

<link rel="stylesheet" href="/extrato/formulario_registrar.css">

<form class="form-cadastrar-editar" action="/app/model/handle_form_transacao.php" method="POST">

  <?php if ($edicao == true) {
    echo "<input class='edicao' type='text' name='edicao' value='{$edicao}' class='input-id' readonly>";
    echo "<input class='campo-id-edicao' type='text' name='id' value='{$id_reg}' class='input-id' readonly>";
    echo "<input class='campo-id-edicao' type='text' name='parcela' value='{$reg_edicao_parcela}' class='input-id' readonly>";
    echo "<input class='campo-id-edicao' type='text' name='total-parcelas' value='{$reg_edicao_total_parcelas}' class='input-id' readonly>";
  }
  ?>

  <div>
    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" <?php if ($edicao == true && $reg_edicao_tipo == 'T') {
                                    echo 'disabled';
                                  } ?>>

      <?php

      foreach ($tiposRegistro as $tipoRegistro) {

        $tipoRegistroExtenso = traduz_registro($tipoRegistro);

        if ($edicao == true && $tipoRegistro == $reg_edicao_tipo) {

          echo "<option value='{$tipoRegistro}' selected>{$tipoRegistroExtenso}</option>";
        } else {
          echo "<option value='{$tipoRegistro}'>{$tipoRegistroExtenso}</option>";
        }
      }
      ?>
    </select>
  </div>
  <div>
    <label for="data">Data:</label>
    <input type="date" id="data" name="data" <?php if ($edicao == true) {
                                                echo "value='{$reg_edicao_data}'";
                                              } else {
                                                echo "value='{$hoje}'";
                                              } ?> required />
  </div>
  <div>
    <label for="valor">Valor:</label>
    <input id="valor" type="text" inputmode="numeric" id="valor" name="valor" <?php if ($edicao == true) {
                                                                                echo "value='{$reg_edicao_valor}'";
                                                                              } ?> required />
  </div>
  <div>
    <label for="descricao">Descrição:</label>
    <input type="text" id="descricao" name="descricao" <?php if ($edicao == true) {
                                                          echo "value='{$reg_edicao_descricao}'";
                                                        } ?> required />
  </div>

  <?php
  if ($edicao == true && $reg_edicao_tipo == 'T') : ?>
    <div>
      <p>As contas de origem e de destino de uma transferência não podem ser editadas. Se for necessário alterá-las, você deve excluir o registro atual e cadastrá-lo novamente.</p>
    </div>
  <?php else : ?>
    <div>
      <label for="conta">Conta:</label>

      <select id="conta" name="conta">
        <option disabled selected value>Selecione uma conta</option>
        <?php

        $tiposConta = buscar_tipos_conta();

        for ($i = 0; $i < sizeof($tiposConta); $i++) {
          echo "<optgroup label='{$tiposConta[$i]}'>";

          $contas = buscar_contas($bdConexao);

          foreach ($contas as $conta) {

            if ($conta['tipo_conta'] == $tiposConta[$i]) {

              if ($edicao == true && $conta['id_con'] == $reg_edicao_conta) {
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
      <label for="contadestino">Conta de destino:</label>

      <select id="contadestino" name="contadestino" disabled>
        <option disabled selected value>Selecione uma conta</option>
        <?php

        $tiposConta = buscar_tipos_conta();

        for ($i = 0; $i < sizeof($tiposConta); $i++) {
          echo "<optgroup label='{$tiposConta[$i]}'>";

          $contas = buscar_contas($bdConexao);

          foreach ($contas as $conta) {

            if ($conta['tipo_conta'] == $tiposConta[$i]) {

              if ($edicao == true && $conta['id_con'] == $reg_edicao_conta) {
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
      <label for="categoria">Categoria:</label>

      <select class="choice categoria" id="categoria" name="categoria" required>

        <?php if ($edicao == false) : ?>
          <option disabled selected value>Selecione uma categoria</option>
        <?php endif; ?>
        <?php
        $categoriasPrincipais = buscar_cat_principal($bdConexao);

        foreach ($categoriasPrincipais as $categoriaPrincipal) :
          echo "<optgroup label='{$categoriaPrincipal['nome_cat']}'>";

          $categoriasSecundarias = buscar_cat_secundaria($bdConexao, $categoriaPrincipal);

          foreach ($categoriasSecundarias as $categoriaSecundaria) {

            if ($edicao == true && $categoriaSecundaria['id_cat'] == $reg_edicao_categoria) {

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
    <?php if ($edicao != true) : ?>
      <div>
        <label for="parcelas">Parcelas:</label>
        <input id="parcelas" type="number" inputmode="numerico" min="0" step="1" id="parcelas" name="parcelas">
      </div>
    <?php endif; ?>
  <?php endif; ?>
  <?php if ($edicao == true) : ?>
    <div class="container-apagar div-checkbox">
      <input type='checkbox' id='apagar' name='apagar' value='true' />
      <label class='label-apagar' for='apagar'>Apagar registro</label>
    </div>
  <?php endif; ?>
  <?php if ($edicao == true && $reg_edicao_parcela != null) : ?>
    <div class="container-edicao-parcelas div-checkbox">
      <input type='checkbox' id='editar-parcelas' name='editar-parcelas' value='true' />
      <label class='label-apagar' for='editar-parcelas'>Aplicar mudanças às parcelas seguintes<br></label>
    </div>
  <?php endif; ?>
  <div class="container-botao-acao-principal">
    <?php if ($edicao == true) : ?>
      <button class="botao-acao-principal" type="submit">Confirmar alteração</button>
    <?php else : ?>
      <button class="botao-acao-principal" type="submit">Registrar transação</button>
    <?php endif; ?>
  </div>
  <?php if ($edicao == true) : ?>
    <span class="info-box formulario" id="alerta-apagar">Atenção: apagar um registro é uma ação irreversível.
    <?php endif; ?>
    </span>

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
      <?php if ($edicao != true) : ?>
        parcelas.disabled = true;
        parcelas.style.cursor = "not-allowed";
      <?php endif; ?>
    } else if (value == "D" || value == "R") {
      categoria.disabled = false;
      choiceCategoria.enable();
      contadestino.disabled = true;
      choiceContaDestino.disable();
      <?php if ($edicao != true) : ?>
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