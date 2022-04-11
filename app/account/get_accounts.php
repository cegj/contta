<?php

function get_accounts($bdConexao)
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
