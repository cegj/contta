<?php

if ($id_cat) {
  $cat_especifica = buscar_cat_especifica($bdConexao, $id_cat);
  $cat_edicao_nome = $cat_especifica['nome_cat'];
  $cat_edicao_cat_principal = $cat_especifica['cat_principal'];
  $cat_edicao_eh_cat_principal = $cat_especifica['eh_cat_principal'];
} else {
  $cat_edicao_nome = "";
  $cat_edicao_cat_principal = "";
  $cat_edicao_eh_cat_principal = "";
}

?>

<?php if (!$id_cat) :
?>
  <h2 class="titulo-box cadastrar">Cadastrar categoria</h2>
<?php else : ?>
  <div class="container-titulo-subtitulo">
    <h2 class="titulo-container titulo-editar com-subtitulo">Editar categoria</h2>
    <h3 class="subtitulo-container"><?php echo $cat_edicao_nome; ?></h3>
  </div>
<?php endif; ?>


<form id="form-categoria" class="form-cadastrar-editar" action="/app/model/handle_form_categoria.php" method="POST">
  <?php if ($id_cat) {
    echo "<input class='campo-id-edicao' type='text' name='id_cat' value='{$id_cat}' class='input-id' readonly>";
  }
  ?>
  <div class="input-nome-categoria">
    <label for="nomecat">Nome da categoria:</label>
    <input type="text" id="nomecat" name="nomecat" <?php preencher_valor_atual('text', $id_cat, $cat_edicao_nome); ?> />
  </div>
  <div class="input-eh-cat-categoria div-checkbox">
    <input type="checkbox" id="ehcatprincipal" name="ehcatprincipal" onclick="habilitar();" value="1" <?php preencher_valor_atual('checkbox', $id_cat, $cat_edicao_eh_cat_principal); ?> />
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

          if ($id_cat && $categoriaPrincipal['nome_cat'] == $cat_edicao_cat_principal) {
            echo "<option selected> {$categoriaPrincipal['nome_cat']}</option>";
          } else {
            echo "<option> {$categoriaPrincipal['nome_cat']}</option>";
          }
        endforeach;
        ?>
      </select>

    <?php endif; ?>
  </div>
  <?php if ($id_cat) {
    echo "
    <div class='div-checkbox container-apagar'>
    <input type='checkbox' id='apagar' name='apagar' value='true' />
    <label class='label-apagar' for='apagar'>Apagar categoria</label>
    </div>
    ";
  }
  ?>
  <?php if ($id_cat) : ?>
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

<script type="text/javascript">
  function habilitar() {
    if (document.getElementById('ehcatprincipal').checked == true) {
      document.getElementById('catprincipal').setAttribute('disabled', 'true');
    } else {
      document.getElementById('catprincipal').removeAttribute('disabled');
    }
  }
</script>