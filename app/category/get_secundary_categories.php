<?php

function get_secondary_categories($bdConexao, $categoriaPrincipal)
{

    $bdBuscar = "
    SELECT * FROM categorias
    WHERE cat_principal = '{$categoriaPrincipal['nome_cat']}' 
    ORDER BY nome_cat
    ";

    $resultado = mysqli_query($bdConexao, $bdBuscar);

    $categoriasSecundarias = array();

    while ($categoriaSecundaria = mysqli_fetch_assoc($resultado)) {
        $categoriasSecundarias[] = $categoriaSecundaria;
    }

    return $categoriasSecundarias;
}
