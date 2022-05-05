<?php

function delete_transaction($bdConexao, $registro, $id_reg, $editarParcelas = false)
{

    if ($registro['tipo'] == 'T') {

        $idRegDestino = $id_reg + 1;

        $bdApagarOrigem = "
        DELETE FROM extrato
        WHERE id = {$id_reg};
        ";

        $bdApagarDestino = "
        DELETE FROM extrato
        WHERE id = {$idRegDestino}
        ";

        mysqli_query($bdConexao, $bdApagarOrigem);
        mysqli_query($bdConexao, $bdApagarDestino);
    } else if ($editarParcelas == true) {

        $novaUltimaParcela = $registro['parcela'] - 1;
        $idPrimeiraParcela = $id_reg - ($registro['parcela'] - 1);

        $partesDescricao = explode('(', $registro['descricao']);
        $descricaoSemParcelas = $partesDescricao[0];

        $parcela = 1;

        for ($idParcela = $idPrimeiraParcela; $idParcela < $id_reg; $idParcela++) {

            $bdGravar = "
            UPDATE extrato
            SET
            descricao='{$descricaoSemParcelas} ({$parcela} / {$novaUltimaParcela})',
            total_parcelas={$novaUltimaParcela}
            WHERE id={$idParcela}
            ";

            mysqli_query($bdConexao, $bdGravar);

            $parcela++;
        }

        for ($parcela = $registro['parcela']; $parcela <= $registro['total-parcelas']; $parcela++) {

            $bdApagar = "
            DELETE FROM extrato
            WHERE id = {$id_reg}
            ";

            mysqli_query($bdConexao, $bdApagar);

            $id_reg++;
        }
    } else {

        $bdApagar = "
        DELETE FROM extrato
        WHERE id = {$id_reg}
        ";

        mysqli_query($bdConexao, $bdApagar);
    }
}
