<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');

$bdBuscar = "
SHOW TABLES;
";

$resultado = mysqli_query($bdConexao, $bdBuscar);

$NumTabelas = mysqli_num_rows($resultado);

if (($NumTabelas) == 0) {
    echo 'true';
} else {
    echo 'false';
}