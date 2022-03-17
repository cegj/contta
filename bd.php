<?php

//Conexão com o banco de dados

$bdServidor = '127.0.0.1';
$bdUsuario = 'root';
$bdSenha = '';
$bdBanco = 'bdcs';

$bdConexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco);

//VERIFICA SE EXISTEM TABLEAS NO BANCO DE DADOS
function nao_existem_tabelas($bdConexao)
{
  $bdBuscar = "
    SHOW TABLES;
    ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $NumTabelas = mysqli_num_rows($resultado);

  if (($NumTabelas) == 0) {
    return true;
  } else {
    return false;
  }
}

//VERIFICA SE UMA TABELA ESTÁ VAZIA

function tabela_nao_esta_vazia($bdConexao, $tabela)
{

  $bdBuscar = "
    SELECT *  FROM {$tabela}   
    ";

  $resultado = mysqli_query($bdConexao, $bdBuscar);

  $NumLinhas = mysqli_num_rows($resultado);

  if (($NumLinhas) == 0) {
    return false;
  } else {
    return true;
  }
}

//INCLUI AS FUNÇÕES RELACIONADAS COM MANIPULAÇÃO DE CATEGORIAS NO BD
include($_SERVER["DOCUMENT_ROOT"] . '/categorias/funcoes_cat.php');

//INCLUI AS FUNÇÕES RELACIONADAS COM MANIPULAÇÃO DE CONTAS NO BD
include($_SERVER["DOCUMENT_ROOT"] . '/contas/funcoes_conta.php');

//INCLUI AS FUNÇÕES RELACIONADAS COM MANIPULAÇÃO DE REGISTROS DO EXTRATO NO BD
include($_SERVER["DOCUMENT_ROOT"] . '/extrato/funcoes_registros.php');

//INCLUI AS FUNÇÕES RELACIONADAS COM MANIPULAÇÃO DO ORÇAMENTO NO BD
include($_SERVER["DOCUMENT_ROOT"] . '/orcamento/funcoes_orcamento.php');
