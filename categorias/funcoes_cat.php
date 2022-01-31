<?php 

//CADASTRAR NOVA CATEGORIA OU EDITAR CATEGORIA CADASTRADA

function cadastrar_cat($bdConexao, $categoria, $edicao = false, $id_cat = null, $cat_edicao_nome = null, $cat_edicao_cat_principal = null){

if($edicao == false) {

if ($categoria['ehcatprincipal'] == 1) {
  $bdGravar = "
  INSERT INTO categorias
  (eh_cat_principal, nome_cat)
  VALUES
  (
    {$categoria['ehcatprincipal']},
    '{$categoria['nomecat']}'
    )
  ";

  mysqli_query($bdConexao, $bdGravar);

  adicionar_ultima_cat_ao_orcamento($bdConexao);
  
  $bdGravarOutros = "
  INSERT INTO categorias
  (eh_cat_principal,nome_cat, cat_principal)
  VALUES
  (
    0,
    'Outros ({$categoria['nomecat']})',
    '{$categoria['nomecat']}'
    )
  ";
  mysqli_query($bdConexao, $bdGravarOutros);

  adicionar_ultima_cat_ao_orcamento($bdConexao);
  
} else {
  $bdGravar = "
  INSERT INTO categorias
  (eh_cat_principal,nome_cat, cat_principal)
  VALUES
  (
    {$categoria['ehcatprincipal']},
    '{$categoria['nomecat']}',
    '{$categoria['catprincipal']}'
    )
  ";
  mysqli_query($bdConexao, $bdGravar);

  adicionar_ultima_cat_ao_orcamento($bdConexao);
}


} else if ($edicao == true){
  $bdAlterarSubCategoriasAssociadas = "
  UPDATE
  categorias
  SET
  cat_principal = '{$categoria['nomecat']}'
  WHERE eh_cat_principal = 0 AND cat_principal = '{$cat_edicao_nome}';
  ";

  $bdAlterarCategoria = "
  UPDATE
  categorias
  SET
  eh_cat_principal={$categoria['ehcatprincipal']},
  nome_cat='{$categoria['nomecat']}',
  cat_principal='{$categoria['catprincipal']}'
  WHERE `id_cat` = {$id_cat};
  ";

  mysqli_query($bdConexao, $bdAlterarSubCategoriasAssociadas);
  mysqli_query($bdConexao, $bdAlterarCategoria);
}
}

//BUSCAR CATEGORIAS PRINCIPAIS

function buscar_cat_principal($bdConexao){

  $bdBuscar = "
  SELECT * FROM categorias
  WHERE eh_cat_principal = 1
  ORDER BY nome_cat
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $categoriasPrincipais = array();

  while ($categoriaPrincipal = mysqli_fetch_assoc($resultado)) {
    $categoriasPrincipais[] = $categoriaPrincipal;
  }

    return $categoriasPrincipais;

}

//BUSCAR CATEGORIAS SECUNDÁRIAS

function buscar_cat_secundaria($bdConexao, $categoriaPrincipal){

  $bdBuscar = "
  SELECT * FROM categorias
  WHERE cat_principal = '{$categoriaPrincipal['nome_cat']}' 
  ORDER BY nome_cat
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $categoriasSecundarias = array();

  while ($categoriaSecundaria = mysqli_fetch_assoc($resultado)){
    $categoriasSecundarias[] = $categoriaSecundaria;
  }

  return $categoriasSecundarias;

}

//BUSCAR INFORMAÇÕES DE UMA CATEGORIA ESPECÍFICA

function buscar_cat_especifica($bdConexao, $id_cat=null, $nome_cat=null){

  if (isset($id_cat)){
    $parametroCat = "WHERE id_cat = {$id_cat}";
  } else if (isset($nome_cat)){
    $parametroCat = "WHERE nome_cat = '{$nome_cat}'";
  }

  $bdBuscar = "
  SELECT id_cat, eh_cat_principal, nome_cat, cat_principal
  FROM categorias
  {$parametroCat}
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $arrayResultados[] = mysqli_fetch_assoc($resultado);

  foreach ($arrayResultados as $resultado) :
    $catEspecifica = $resultado;
  endforeach;

  return $catEspecifica;

}

//APAGAR UMA CATEGORIA E SUAS CATEGORIAS SECUNDÁRIAS (SE FOR PRINCIPAL)

function apagar_cat($bdConexao, $id_cat, $nome_cat, $cat_principal){
  
  if ($cat_principal == null){

    apagar_cat_do_orcamento($bdConexao, $id_cat, $cat_principal);

    $bdGravar = "
    DELETE FROM categorias
    WHERE cat_principal = '{$nome_cat}'
    ";
    mysqli_query($bdConexao, $bdGravar);
  }

  apagar_cat_do_orcamento($bdConexao, $id_cat, $cat_principal);
  
  $bdGravar = "
  DELETE FROM categorias
  WHERE id_cat = {$id_cat}
  ";
  mysqli_query($bdConexao, $bdGravar);

}

?>