<?php

function delete_account($bdConexao, $id_conta, $removeMantemRegistros)
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
