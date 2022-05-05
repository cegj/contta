<?php

function get_primary_categories($bdConexao)
{

    $bdBuscar = "
    SELECT * FROM categorias
    WHERE eh_cat_principal = 1
    ORDER BY nome_cat
    ";

    $resultado = mysqli_query($bdConexao, $bdBuscar);

    $categoriasPrincipais = array();

    while ($categoriaPrincipal = mysqli_fetch_assoc($resultado)) {
        $categoriasPrincipais[] = $categoriaPrincipal;
    }

    return $categoriasPrincipais;
}
