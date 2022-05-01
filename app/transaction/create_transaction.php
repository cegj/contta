<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/account/get_especific_account.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/category/get_especific_category.php');

function create_transaction($bdConexao, $registro, $edicao, $id_reg, $editarParcelas = false)
{

    $data_insert = date('Y-m-d H:i:s');

    if ($edicao == false or $edicao == '') {

        if ($registro['tipo'] == 'T') {

            $contaOrigem = get_especific_account($bdConexao, $registro['conta'], null);
            $contaDestino = get_especific_account($bdConexao, $registro['contadestino'], null);


            //Se a conta origem ou conta destino for oculta, colocar na categoria "Contas ocultas" (para orçamento)
            if ($contaDestino['exibir'] == 0 or $contaOrigem['exibir'] == 0) {
                $catContasOcultas = get_especific_category($bdConexao, null, 'Contas ocultas');
                $idCatContasOcultas = "'{$catContasOcultas['id_cat']}'";
            } else {
                $idCatContasOcultas = "null";
            }

            $bdGravarOrigem = "
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
            '{$registro['tipo']}',
            '{$registro['data']}',
            '{$registro['descricao']}',
            {$registro['valor']},
            {$idCatContasOcultas},
            '{$registro['conta']}'
            )
            ";

            mysqli_query($bdConexao, $bdGravarOrigem);

            $valorDestino = $registro['valor'] * -1;

            $bdGravarDestino = "
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
            '{$registro['tipo']}',
            '{$registro['data']}',
            '{$registro['descricao']}',
            {$valorDestino},
            {$idCatContasOcultas},
            '{$registro['contadestino']}'
            )
            ";

            mysqli_query($bdConexao, $bdGravarDestino);
        } else if (isset($registro['parcelas']) && $registro['parcelas'] > 1) {

            $partesData = explode('-', $registro['data']);
            $dia = $partesData[2];
            $mes = $partesData[1];
            $ano = $partesData[0];

            for ($parcela = 1; $parcela <= $registro['parcelas']; $parcela++) {

                $bdGravar = "
                INSERT INTO extrato
                (
                data_insert,
                tipo,
                data,
                descricao,
                valor,
                parcela,
                total_parcelas,  
                id_categoria,
                id_conta
                )
                VALUES
                (
                '{$data_insert}',
                '{$registro['tipo']}',
                '{$ano}-{$mes}-{$dia}',
                '{$registro['descricao']} ({$parcela} / {$registro['parcelas']})',
                {$registro['valor']},
                {$parcela},
                {$registro['parcelas']},
                '{$registro['categoria']}',
                '{$registro['conta']}'
                )
                ";

                mysqli_query($bdConexao, $bdGravar);

                if ($mes < 12) {
                    $mes++;
                } else {
                    $mes = 1;
                    $ano = $ano + 1;
                }
            }
        } else {

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
            '{$registro['tipo']}',
            '{$registro['data']}',
            '{$registro['descricao']}',
            {$registro['valor']},
            '{$registro['categoria']}',
            '{$registro['conta']}'
            )
            ";

            mysqli_query($bdConexao, $bdGravar);
        }
    } else if ($edicao == true) {

        if ($registro['tipo'] == 'T') {

            $bdGravarOrigem = "
            UPDATE extrato
            SET
            data='{$registro['data']}',
            descricao='{$registro['descricao']}',
            valor={$registro['valor']}
            WHERE id = {$id_reg};
            ";

            mysqli_query($bdConexao, $bdGravarOrigem);

            $valorDestino = $registro['valor'] * -1;
            $idRegDestino = $id_reg + 1;

            $bdGravarDestino = "
            UPDATE extrato
            SET
            data='{$registro['data']}',
            descricao='{$registro['descricao']}',
            valor={$valorDestino}
            WHERE id = {$idRegDestino};
            ";

            mysqli_query($bdConexao, $bdGravarDestino);
        } else if ($editarParcelas == true) {

            $partesDescricao = explode('(', $registro['descricao']);
            $descricaoSemParcelas = $partesDescricao[0];

            $partesData = explode('-', $registro['data']);
            $dia = $partesData[2];
            $mes = $partesData[1];
            $ano = $partesData[0];

            for ($parcela = $registro['parcela']; $parcela <= $registro['total-parcelas']; $parcela++) {
                $bdGravar = "
                UPDATE extrato
                SET
                tipo='{$registro['tipo']}',
                data='{$ano}-{$mes}-{$dia}',
                descricao='{$descricaoSemParcelas} ({$parcela} / {$registro['total-parcelas']})',
                valor={$registro['valor']},
                id_categoria='{$registro['categoria']}',
                id_conta='{$registro['conta']}'
                WHERE id = {$id_reg};    
                ";

                mysqli_query($bdConexao, $bdGravar);

                if ($mes < 12) {
                    $mes++;
                } else {
                    $mes = 1;
                    $ano = $ano + 1;
                }

                $id_reg++;
            }
        } else {

            $bdGravar = "
            UPDATE extrato
            SET
            tipo='{$registro['tipo']}',
            data='{$registro['data']}',
            descricao='{$registro['descricao']}',
            valor={$registro['valor']},
            id_categoria='{$registro['categoria']}',
            id_conta='{$registro['conta']}'
            WHERE id = {$id_reg};
            ";

            mysqli_query($bdConexao, $bdGravar);
        }
    }
}
