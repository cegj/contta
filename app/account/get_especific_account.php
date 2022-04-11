<?php

function get_especific_account($bdConexao, $id_conta = null, $nome_conta = null)
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
