<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_especific_category.php');

function create_account($bdConexao, $conta, $edicao, $id_conta)
{
    //FUNÇÃO PARA CADASTRAR/ALTERAR O SALDO INICIAL APÓS CADASTRAR/ALTERAR A CONTA

    function insert_openning_balance($bdConexao, $edicao, $saldoinicial, $id_conta)
    {

        $hoje = date('Y-m-d');
        $data_insert = date('Y-m-d H:i:s');

        $catSaldoInicial = get_especific_category($bdConexao, null, 'Saldo inicial');
        $idCatSaldoInicial = $catSaldoInicial['id_cat'];

        if ($edicao == false) {

            $bdBuscarUltimaContaCadastrada = "
            SELECT * FROM contas ORDER BY id_con DESC LIMIT 1;
            ";

            $resultado = mysqli_query($bdConexao, $bdBuscarUltimaContaCadastrada);

            $conta = mysqli_fetch_array($resultado);

            $bdGravar = "
            INSERT INTO extrato
            (
                data_insert,
                tipo,
                data,
                descricao,
                valor,
                id_categoria,
                id_conta
                )
            VALUES
            (
                '{$data_insert}',
                'SI',
                '{$hoje}',
                'Saldo inicial',
                {$saldoinicial},
                '{$idCatSaldoInicial}',
                '{$conta['id_con']}'
                )
                ";
        } else if ($edicao == true) {
            $bdGravar = "
                UPDATE extrato
                SET
                valor={$saldoinicial}
                WHERE tipo = 'SI' and id_conta = {$id_conta};
            ";
        }

        mysqli_query($bdConexao, $bdGravar);
    }

    //AQUI COMEÇA A FUNÇÃO PARA GRAVAR/ALTERAR CONTA

    if ($edicao == false) {

        $bdGravar = "
        INSERT INTO contas
        (conta,
        tipo_conta,
        saldo_inicial,
        exibir)
        VALUES (
            '{$conta['nomeconta']}',
            '{$conta['tipoconta']}',
            {$conta['saldoinicial']},
            {$conta['exibir']}
            )
        ";

        mysqli_query($bdConexao, $bdGravar);

        insert_openning_balance($bdConexao, $edicao, $conta['saldoinicial'], null);
    } else if ($edicao == true) {

        $bdGravar = "
        UPDATE
        contas
        SET
        conta='{$conta['nomeconta']}',
        tipo_conta='{$conta['tipoconta']}',
        saldo_inicial={$conta['saldoinicial']},
        exibir={$conta['exibir']}
        WHERE id_con = {$id_conta};
        ";

        mysqli_query($bdConexao, $bdGravar);

        insert_openning_balance($bdConexao, $edicao, $conta['saldoinicial'], $id_conta);
    }
}
