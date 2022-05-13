<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/get_account_types.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/get_especific_account.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/fill_current_value.php');

$tiposConta = get_account_types();

if ($id_conta) {
  $conta_em_edicao = get_especific_account($bdConexao, $id_conta);
  $conta_edicao_nome = $conta_em_edicao['conta'];
  $conta_edicao_tipo = $conta_em_edicao['tipo_conta'];
  $conta_edicao_saldo_inicial = $conta_em_edicao['saldo_inicial'];
  $conta_edicao_exibir = $conta_em_edicao['exibir'];
} else {
  $conta_edicao_nome = "";
  $conta_edicao_tipo = "";
  $conta_edicao_saldo_inicial = "";
  $conta_edicao_exibir = "";
}

?>

<?php if (!$id_conta) :
?>
  <h2 class="titulo-box cadastrar">Cadastrar conta</h2>
<?php else : ?>
  <div class="container-titulo-subtitulo">
    <h2 class="titulo-container titulo-editar com-subtitulo">Editar conta:</h2>
    <h3 class="subtitulo-container"><?php echo $conta_edicao_nome; ?></h3>
  </div>
<?php endif; ?>

<form id="form-account" class="form-cadastrar-editar" action="app\form_handler\handle_form-account.php" method="POST">
  <?php if ($id_conta) {
    echo "<input class='campo-id-edicao' type='text' name='id_conta' value='{$_GET['id_conta']}' class='input-id' readonly>";
  }
  ?>
  <div>
    <label for="nomeconta">Nome da conta:</label>
    <input type="text" id="nomeconta" name="nomeconta" <?php fill_current_value('text', true, $conta_edicao_nome); ?> required />
  </div>
  <div>
    <label for="tipoconta">Tipo de conta:</label>
    <select name="tipoconta" id="tipoconta" required>

      <?php

      foreach ($tiposConta as $tipoConta) {

        if ($id_conta && $tipoConta == $conta_edicao_tipo) {
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
    <input type="text" inputmode="numeric" id="saldoinicial" name="saldoinicial" <?php fill_current_value('number', true, $conta_edicao_saldo_inicial); ?> />
  </div>
  <div class="div-checkbox container-exibir">
    <input type="checkbox" id="exibirconta" name="exibirconta" value="1" <?php if ($id_conta) {
                                                                            fill_current_value('checkbox', true, $conta_edicao_exibir);
                                                                          } else {
                                                                            echo "checked";
                                                                          } ?> />
    <label for="exibirconta">Exibir conta</label>
  </div>
  <?php if ($id_conta) : ?>
    <div class="div-radio container-apagar ocupar-todas-colunas">
      <input type='radio' id='apagar-remove' class='apagar' name='apagar' value='remove-registros' />
      <label for='apagar-remove' class='label-apagar'>Apagar conta e <strong>remover</strong> histórico</label>
    </div>
    <div class="div-radio container-apagar ocupar-todas-colunas">
      <input type='radio' id='apagar-mantem' class='apagar' name='apagar' value='mantem-registros' />
      <label for='apagar-mantem' class='label-apagar'>Apagar conta e <strong>manter</strong> histórico</label>
    </div>
  <?php endif; ?>

  <?php if ($id_conta) : ?>
    <div class="container-botao-acao-principal">
      <button class="botao-acao-principal" type="submit">Confirmar alteração</button>
    </div>

    <span class="info-box formulario" id="alerta-apagar"><strong>Cuidado:</strong> apagar uma conta é irreversível. Caso queira somente deixar de exibir a conta e suas movimentações, desmarque a opção "Exibir conta" em vez de apagar. <br>
      <span id="limpar-selecao" class="botao-acao-secundario cancelar">Limpar seleção</span></span>

  <?php else : ?>
    <div class="container-botao-acao-principal">
      <button class="botao-acao-principal" type="submit">Cadastrar conta</button>
    </div>
  <?php endif; ?>

</form>

<script>
  VMasker(document.querySelector("#saldoinicial")).maskMoney({
    precision: 2,
    separator: ',',
    delimiter: '.',
    unit: 'R$',
  });
</script>

<script src="/contas/contas.js"></script>