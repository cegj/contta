<?php

function sum_budget_value($bdConexao, $mes, $catEspecifica = null, $acumulado = false)
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
