<?php

//CADASTRAR NOVA CONTA OU EDITAR CONTA CADASTRADA

// function cadastrar_conta($bdConexao, $conta, $edicao, $id_conta)
// {
//   //FUNÇÃO PARA CADASTRAR/ALTERAR O SALDO INICIAL APÓS CADASTRAR/ALTERAR A CONTA

//   function gravar_saldo_inicial($bdConexao, $edicao, $saldoinicial, $id_conta)
//   {

//     $hoje = date('Y-m-d');
//     $data_insert = date('Y-m-d H:i:s');

//       $catSaldoInicial = buscar_cat_especifica($bdConexao, null, 'Saldo inicial');
//       $idCatSaldoInicial = $catSaldoInicial['id_cat'];

//     if ($edicao == false) {

//       $bdBuscarUltimaContaCadastrada = "
//   SELECT * FROM contas ORDER BY id_con DESC LIMIT 1;
//   ";

//       $resultado = mysqli_query($bdConexao, $bdBuscarUltimaContaCadastrada);

//       $conta = mysqli_fetch_array($resultado);

//       $bdGravar = "
//   INSERT INTO extrato
//   (
//     data_insert,
//     tipo,
//     data,
//     descricao,
//     valor,
//     id_categoria,
//     id_conta
//     )
//   VALUES
//   (
//     '{$data_insert}',
//     'SI',
//     '{$hoje}',
//     'Saldo inicial',
//     {$saldoinicial},
//     '{$idCatSaldoInicial}',
//     '{$conta['id_con']}'
//     )
//     ";
//     } else if ($edicao == true) {
//       $bdGravar = "
//     UPDATE extrato
//     SET
//     valor={$saldoinicial}
//     WHERE tipo = 'SI' and id_conta = {$id_conta};
//   ";
//     }
//     mysqli_query($bdConexao, $bdGravar);
//   }

//   //AQUI COMEÇA A FUNÇÃO PARA GRAVAR/ALTERAR CONTA

//   if ($edicao == false) {

//     $bdGravar = "
//   INSERT INTO contas
//   (conta,
//   tipo_conta,
//   saldo_inicial,
//   exibir)
//   VALUES (
//     '{$conta['nomeconta']}',
//     '{$conta['tipoconta']}',
//     {$conta['saldoinicial']},
//     {$conta['exibir']}
//     )
//   ";

//     mysqli_query($bdConexao, $bdGravar);
//     gravar_saldo_inicial($bdConexao, $edicao, $conta['saldoinicial'], null);

//   } else if ($edicao == true) {
//     $bdGravar = "
//   UPDATE
//   contas
//   SET
//   conta='{$conta['nomeconta']}',
//   tipo_conta='{$conta['tipoconta']}',
//   saldo_inicial={$conta['saldoinicial']},
//   exibir={$conta['exibir']}
//   WHERE id_con = {$id_conta};
//   ";

//     mysqli_query($bdConexao, $bdGravar);
//     gravar_saldo_inicial($bdConexao, $edicao, $conta['saldoinicial'], $id_conta);
//   }
// }

//BUSCAR CONTAS

function buscar_contas($bdConexao)
{

  $bdBuscar = "
  SELECT * FROM contas
  ORDER BY tipo_conta, conta
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $contas = array();

  while ($conta = mysqli_fetch_assoc($resultado)) {
    $contas[] = $conta;
  }

  return $contas;
}

//BUSCAR INFORMAÇÕES DE UMA CONTA ESPECÍFICA

function buscar_conta_especifica($bdConexao, $id_conta = null, $nome_conta = null)
{

  if (isset($id_conta)) {
    $parametroConta = "WHERE id_con = {$id_conta}";
  } else if (isset($nome_conta)) {
    $parametroConta = "WHERE conta = '{$nome_conta}'";
  }

  $bdBuscar = "
  SELECT
  id_con,
  conta,
  tipo_conta,
  saldo_inicial,
  exibir
  FROM contas
  {$parametroConta}
  ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $arrayResultados[] = mysqli_fetch_array($resultado);

  foreach ($arrayResultados as $resultado) :
    $contaEspecifica = $resultado;
  endforeach;

  return $contaEspecifica;
}

//APAGAR UMA CONTA

function apagar_conta($bdConexao, $id_conta, $removeMantemRegistros)
{

  $bdApagarConta = "
  DELETE FROM contas
  WHERE id_con = {$id_conta}
  ";

  mysqli_query($bdConexao, $bdApagarConta);


  if ($removeMantemRegistros == 'mantem-registros') {

    $bdZerarIdContaExtrato = "
    UPDATE extrato
    SET
    id_conta = null
    WHERE id_conta = {$id_conta}
    ";

    mysqli_query($bdConexao, $bdZerarIdContaExtrato);
  } else if ($removeMantemRegistros == 'remove-registros') {

    $bdApagarRegistros = "
  DELETE FROM extrato
  WHERE id_conta = {$id_conta}
  ";

    mysqli_query($bdConexao, $bdApagarRegistros);
  }
}

function buscar_tipos_conta()
{
  $tiposConta = array('Conta bancária', 'Cartão de crédito', 'Carteira', 'Investimentos');
  return $tiposConta;
}
