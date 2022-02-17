<?php

function busca_orcamento($bdConexao, $categoriaPrincipal)
{
  $bdBuscar = "
    SELECT id_cat, nome_cat, eh_cat_principal, janeiro, fevereiro, março, abril, maio, junho, julho, agosto, setembro, outubro, novembro, dezembro FROM orcamento
    INNER JOIN categorias ON orcamento.id_categoria = categorias.id_cat
    WHERE categorias.cat_principal = '{$categoriaPrincipal}' OR categorias.nome_cat = '{$categoriaPrincipal}'
    ORDER BY eh_cat_principal DESC, nome_cat ASC;
";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $itensOrcamento = array();

  while ($item = mysqli_fetch_assoc($resultado)) {
    $itensOrcamento[] = $item;
  }

  return $itensOrcamento;
}

function alterar_valor_orcamento($bdConexao, $catEmEdicao, $mesEmEdicao, $novoValor)
{

  $bdAlterar = "
  UPDATE orcamento
  SET
  {$mesEmEdicao} = {$novoValor}
  WHERE id_categoria = $catEmEdicao;
  ";

  $resultado = mysqli_query($bdConexao, $bdAlterar);
}

function somar_gasto_previsto($bdConexao, $mes, $catEspecifica = null, $acumulado = false)
{


  if (isset($catEspecifica)) {
    $bdSomar = "
      SELECT sum({$mes}) FROM orcamento
      INNER JOIN categorias ON orcamento.id_categoria = categorias.id_cat
      WHERE categorias.cat_principal = '{$catEspecifica}'
      ";
  } else {
    $bdSomar = "
    SELECT sum({$mes}) FROM orcamento
    ";
  }

  $resultado = mysqli_query($bdConexao, $bdSomar);

  $soma = mysqli_fetch_array($resultado);

  $string = 'sum(' . $mes . ')';

  return $soma[$string];
}

//ADICIONA O ID DA ÚLTIMA CATEGORIA CADASTRADA NA TABELA CATEGORIAS À TABELA DE ORÇAMENTO

function adicionar_ultima_cat_ao_orcamento($bdConexao)
{
  $bdBuscarId = "
  SELECT id_cat FROM categorias ORDER BY id_cat DESC LIMIT 1
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscarId);

  $linhas[] = mysqli_fetch_assoc($resultado);

  foreach ($linhas as $linha) {
    $cat[] = $linha['id_cat'];
  }

  $bdGravarTabOrcamento = "
  INSERT INTO orcamento
  (id_categoria)
  VALUES
  ({$cat[0]})
  ";

  mysqli_query($bdConexao, $bdGravarTabOrcamento);
}

//APAGA DO ORÇAMENTO O ID DE UMA CATEGORIA QUE FOI EXCLUÍDA

function apagar_cat_do_orcamento($bdConexao, $id_cat, $cat_principal)
{

  if ($cat_principal == null) {
    $bdGravar = "
    DELETE orcamento 
    FROM orcamento 
    INNER JOIN categorias 
    ON id_categoria=id_cat
    WHERE cat_principal = '{$cat_principal}'
    ";

    mysqli_query($bdConexao, $bdGravar);
  }

  $bdGravar = "
  DELETE FROM orcamento
  WHERE id_categoria = {$id_cat}
  ";
  mysqli_query($bdConexao, $bdGravar);
}


//VERIFICAR SE A CELULA É REFERENTE AO MÊS SELECIONADO E RETORNA A STRING "SELECIONADO" SE FOR

function verificaMesSelecionado($mes, $id)
{

  switch ($mes) {
    case 'janeiro':
      $mesNum = '01';
      break;
    case 'fevereiro':
      $mesNum = '02';
      break;
    case 'março':
      $mesNum = '03';
      break;
    case 'abril':
      $mesNum = '04';
      break;
    case 'maio':
      $mesNum = '05';
      break;
    case 'junho':
      $mesNum = '06';
      break;
    case 'julho':
      $mesNum = '07';
      break;
    case 'agosto':
      $mesNum = '08';
      break;
    case 'setembro':
      break;
      $mesNum = '09';
      break;
    case 'outubro':
      break;
      $mesNum = '10';
    case 'novembro':
      break;
      $mesNum = '11';
    case 'dezembro':
      $mesNum = '12';
      break;
  }

  if ($id == $mesNum) {
    return true;
  } else {
    return false;
  }

}
