<script type="text/javascript">
  function habilitar() {
    if (document.getElementById('ehcatprincipal').checked == true) {
      document.getElementById('catprincipal').setAttribute('disabled', 'true');
    } else {
      document.getElementById('catprincipal').removeAttribute('disabled');
    }
  }
</script>

<!-- Mudar classe das tags form quando for estilizar -->
<form id="form-categoria" class="form-cadastrar-editar" action="" method="POST">
  <?php if($edicao == true){
    echo "<input class='campo-id-edicao' type='text' name='id' value='{$id_cat}' class='input-id' readonly>";
  }
  ?>
  <div class="input-nome-categoria">
    <label for="nomecat">Nome da categoria:</label>
    <input type="text" id="nomecat" name="nomecat" <?php preencher_valor_atual('text', $edicao, $cat_edicao_nome); ?> />
  </div>
  <div class="input-eh-cat-categoria div-checkbox">
    <input type="checkbox" id="ehcatprincipal" name="ehcatprincipal" onclick="habilitar();" value="1" <?php preencher_valor_atual('checkbox', $edicao, $cat_edicao_eh_cat_principal); ?> />
    <label for="ehcatprincipal">É categoria principal</label>
  </div>
  <div>
    <label for="catprincipal">Categoria principal:</label>

    <?php
    if (buscar_cat_principal($bdConexao) == null) : 
    ?>

    <span>não há categorias principais cadastradas.</span>

    <?php else :

    ?>

    <select class="select-cat-principal" name="catprincipal" id="catprincipal" onclick="habilitar();" ?>>

      <?php
      $categoriasPrincipais = buscar_cat_principal($bdConexao);

      foreach ($categoriasPrincipais as $categoriaPrincipal) :

        if ($edicao == true && $categoriaPrincipal['nome_cat'] == $cat_edicao_cat_principal) {
          echo "<option selected> {$categoriaPrincipal['nome_cat']}</option>";
        } else {
          echo "<option> {$categoriaPrincipal['nome_cat']}</option>";
        }
      endforeach;
      ?>
    </select>

    <?php endif; ?>
  </div>
  <?php if($edicao == true) {
    echo "
    <div class='div-checkbox container-apagar'>
    <input type='checkbox' id='apagar' name='apagar' value='true' />
    <label class='label-apagar' for='apagar'>Apagar categoria</label>
    </div>
    ";
  }
  ?>
  <?php if($edicao == true) : ?>
    <div class="container-botao-acao-principal">
    <button class="botao-acao-principal" type="submit">Confirmar alteração</button>
    </div>
    <span class="info-box formulario" id="alerta-apagar">Atenção: apagar uma categoria é uma ação irreversível.</span>
    <?php else : ?>
    <div class="container-botao-acao-principal">
    <button class="botao-acao-principal" type="submit">Cadastrar categoria</button>
    </div>
    <?php endif; ?>
</form>

<?php

//Guardar os dados na variável $categoria para inserir no BD

if (isset($_POST['nomecat']) && $_POST['nomecat'] != '') {
  $categoria = array();

  $categoria['nomecat'] = $_POST['nomecat'];

  if (isset($_POST['ehcatprincipal'])) {
    $categoria['ehcatprincipal'] = 1;
    $categoria['catprincipal'] = "";
  } else {
    $categoria['ehcatprincipal'] = 0;
    if (buscar_cat_principal($bdConexao) == null){
        echo"<script language='javascript' type='text/javascript'>
        alert('Antes de cadastrar uma categoria secundária, é necessário cadastrar pelo menos uma categoria principal. Tente novamente.');window.location.href='categorias.php';</script>";
        die();
    } else {
    $categoria['catprincipal'] = $_POST['catprincipal'];
    }
  }

  if (isset($_POST['apagar']) && $_POST['apagar'] == true) {
    apagar_cat($bdConexao, $id_cat, $cat_edicao_nome, $cat_edicao_cat_principal);
  } else if($edicao == true){
    cadastrar_cat($bdConexao, $categoria, $edicao, $id_cat, $cat_edicao_nome, $cat_edicao_cat_principal);
    echo "<script>
    window.location.replace('/categorias.php');
    </script>";
  } else {
    cadastrar_cat($bdConexao, $categoria, $edicao, null,null,null);
    echo "<script>
    window.location.replace('/categorias.php');
    </script>";
  }
}
?>