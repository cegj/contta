<?php

function get_especific_category($bdConexao, $id_cat = null, $nome_cat = null)
{

    if (isset($id_cat)) {
        $parametroCat = "WHERE id_cat = {$id_cat}";
    } else if (isset($nome_cat)) {
        $parametroCat = "WHERE nome_cat = '{$nome_cat}'";
    }

    $bdBuscar = "
    SELECT id_cat, eh_cat_principal, nome_cat, cat_principal
    FROM categorias
    {$parametroCat}
    ";

    $resultado = mysqli_query($bdConexao, $bdBuscar);

    $arrayResultados[] = mysqli_fetch_assoc($resultado);

    foreach ($arrayResultados as $resultado) :
        $catEspecifica = $resultado;
    endforeach;

    return $catEspecifica;
}
