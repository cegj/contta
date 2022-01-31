<?php $tiposConta = buscar_tipos_conta(); ?>

<form id="form-contas" class="form-cadastrar-editar" action="#" method="POST">
  <?php if ($edicao == true) {
    echo "<input class='campo-id-edicao' type='text' name='id' value='{$id_conta}' class='input-id' readonly>";
  }
  ?>
  <div>
    <label for="nomeconta">Nome da conta:</label>
    <input type="text" id="nomeconta" name="nomeconta" <?php preencher_valor_atual('text', $edicao, $conta_edicao_nome); ?> required />
  </div>
  <div>
    <label for="tipoconta">Tipo de conta:</label>
    <select name="tipoconta" id="tipoconta" required>

      <?php

      foreach ($tiposConta as $tipoConta) {

        if ($edicao == true && $tipoConta == $conta_edicao_tipo) {
          echo "<option selected>{$tipoConta}</option>";
        } else {
          echo "<option>{$tipoConta}</option>";
        }
      }
      ?>
    </select>
  </div>
  <div>
    <label for="saldoinicial">Saldo inicial:</label>
    <input type="text" inputmode="numeric" id="saldoinicial" name="saldoinicial" <?php preencher_valor_atual('number', $edicao, $conta_edicao_saldo_inicial); ?> />
  </div>
  <div class="div-checkbox container-exibir">
    <input type="checkbox" id="exibirconta" name="exibirconta" value="1" <?php if ($edicao == true) { preencher_valor_atual('checkbox', $edicao, $conta_edicao_exibir);} else {echo "checked";} ?> />
    <label for="exibirconta">Exibir conta</label>
  </div>
  <?php if ($edicao == true) : ?>
    <div class="div-radio container-apagar ocupar-todas-colunas">
      <input type='radio' id='apagar-remove' class='apagar' name='apagar' value='remove-registros' />
      <label for='apagar-remove' class='label-apagar'>Apagar conta e <strong>remover</strong> todo o histórico</label>
  </div>
      <div class="div-radio container-apagar ocupar-todas-colunas">
      <input type='radio' id='apagar-mantem' class='apagar' name='apagar' value='mantem-registros' />
      <label for='apagar-mantem' class='label-apagar'>Apagar conta, mas <strong>manter</strong> todo o histórico</label>
    </div>
  <?php endif; ?>

    <?php if($edicao == true) : ?>
    <div class="container-botao-acao-principal">
    <button class="botao-acao-principal" type="submit">Confirmar alteração</button>
    </div>

    <span class="info-box formulario" id="alerta-apagar">Cuidado: apagar uma conta é um procedimento irreversível. Caso queira somente deixar de exibir a conta e suas movimentações, desmarque a opção "Exibir" em vez de apagar. <br>
    <span id="limpar-selecao" class="botao-acao-secundario cancelar">Limpar seleção</span></span>

    <?php else : ?>
    <div class="container-botao-acao-principal">
    <button class="botao-acao-principal" type="submit">Cadastrar conta</button>
    </div>
    <?php endif; ?>

</form>

<?php

//Guardar os dados na variável $categoria para inserir no BD

if (isset($_POST['nomeconta']) && $_POST['nomeconta'] != '') {
  $conta = array();

  $conta['nomeconta'] = $_POST['nomeconta'];

  $conta['tipoconta'] = $_POST['tipoconta'];

  if (isset($_POST['saldoinicial']) && $_POST['saldoinicial'] != "") {
    $valorSemMascara = ajustaValorMoeda($_POST['saldoinicial']);
    $conta['saldoinicial'] = $valorSemMascara;
  } else {
    $conta['saldoinicial'] = 0;
  }

  if (isset($_POST['exibirconta']) && $_POST['exibirconta'] == 1) {
    $conta['exibir'] = 1;
  } else {
    $conta['exibir'] = 0;
  }

  //Chama as funções conforme o caso

  if (isset($_POST['apagar'])) {
    apagar_conta($bdConexao, $id_conta, $_POST['apagar']);
    echo "<script>
    window.location.replace('/contas.php');
    </script>";
  } else if ($edicao == true) {
    cadastrar_conta($bdConexao, $conta, $edicao, $id_conta);
    echo "<script>
    window.location.replace('/contas.php');
    </script>";
  } else {
    cadastrar_conta($bdConexao, $conta, $edicao, null);
    echo "<script>
    window.location.replace('/contas.php');
    </script>";
  }
}
?>

<script>

VMasker(document.querySelector("#saldoinicial")).maskMoney({
  precision: 2,
  separator: ',',
  delimiter: '.', 
  unit: 'R$',
});

</script>