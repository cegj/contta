<form id="form-usuarios-edicao" class="form-cadastrar-editar" action="#" method="POST">
  <?php if ($edicao == true) {
    echo "<input class='campo-id-edicao' type='text' name='id' value='{$id_usuario}' class='input-id' readonly>";
  }
  ?>
  <div>
    <label for="nomeusuario">Nome do usuário:</label>
    <input type="text" id="nomeusuario" name="nomeusuario" <?php preencher_valor_atual('text', $edicao, $usuario_edicao_nome); ?> required />
  </div>
  <div>
    <label for="administrador">Administrador:</label>
    <select name="administrador" id="administrador" required>

      <?php
      
        if ($edicao == true && $usuario_edicao_administrador == 1) {
          echo "
          <option value='1' selected>Sim</option>
          <option value='0'>Não</option>
          ";
        } else {
          echo "
          <option value='1'>Sim</option>
          <option value='0' selected>Não</option>
          ";
        }
      ?>
    </select>
  </div>
  <div>
    <label for="novasenha">Nova senha:</label>
    <input type="password" id="senha" name="novasenha" />
  </div>
  <div>
    <label for="novocodautorizacao">Novo cod. autorização:</label>
    <input type="password" id="codautorizacao" name="novocodautorizacao" />
  </div>

  <div class='div-checkbox container-apagar'>
    <input type='checkbox' id='apagar' name='apagar' value='true' />
    <label class='label-apagar' for='apagar'>Apagar usuário</label>
  </div>

    <?php if($edicao == true) : ?>
    <div class="container-botao-acao-principal">
    <button class="botao-acao-principal" type="submit">Confirmar alteração</button>
    </div>

    <span class="info-box formulario" id="alerta-apagar">Cuidado: apagar um usuário é um procedimento irreversível. Para habilitar o usuário novamente, será necessário recadastrá-lo.
    </span>

    <?php endif; ?>

</form>

<?php

//Guardar os dados na variável $categoria para inserir no BD

if (isset($_POST['nomeusuario']) && $_POST['nomeusuario'] != '') {
  $usuario = array();

  $usuario['nome'] = $_POST['nomeusuario'];

  $usuario['administrador'] = $_POST['administrador'];

  if (isset($_POST['novasenha']) && $_POST['novasenha'] != "") {
    $usuario['novasenha'] = MD5($_POST['novasenha']);
  }

  if (isset($_POST['novocodautorizacao']) && $_POST['novocodautorizacao'] != "") {
    $usuario['novocodautorizacao'] = MD5($_POST['novocodautorizacao']);
  }

  //Chama as funções conforme o caso

  if (isset($_POST['apagar']) && $_POST['apagar'] == true) {
    apagar_usuario($bdConexao, $id_usuario);
    echo "<script>
    window.location.replace('/usuarios.php');
    </script>";
  } else {
    editar_usuario($bdConexao, $id_usuario, $usuario);
    echo "<script>
    window.location.replace('/usuarios.php');
    </script>";
  } 
  }

?>

<script>

  caixaAdministrador = document.getElementById('administrador');
  caixaNovoCodAutorizacao = document.getElementById('codautorizacao');

  caixaAdministrador.addEventListener('change', function(){

    if (caixaAdministrador.value == '0') {
      caixaNovoCodAutorizacao.disabled = true;
    } else if (caixaAdministrador.value == '1') {
      caixaNovoCodAutorizacao.disabled = false;
    }

  });

</script>