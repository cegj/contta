<?php

function get_especific_transaction($bdConexao, $id_reg)
{

    $bdBuscar = "
    SELECT
    tipo,
    data,
    descricao,
    valor,
    id_categoria,
    nome_cat,
    id_conta,
    conta,
    parcela,
    total_parcelas
    FROM extrato
    LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
    LEFT JOIN contas ON extrato.id_conta = contas.id_con
    WHERE id = {$id_reg}
    ";

    $resultado = mysqli_query($bdConexao, $bdBuscar);

    $reg_especifico[] = mysqli_fetch_assoc($resultado);

    return $reg_especifico;
}
