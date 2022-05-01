<?php

function there_is_no_table($bdConexao)
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
