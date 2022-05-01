<?php

function table_is_not_empty($bdConexao, $tabela)
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
