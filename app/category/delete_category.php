<?php

function apagar_cat($bdConexao, $id_cat, $nome_cat, $cat_principal)
{

    if ($cat_principal == null) {

        apagar_cat_do_orcamento($bdConexao, $id_cat, $cat_principal);

        $bdGravar = "
        DELETE FROM categorias
        WHERE cat_principal = '{$nome_cat}'
        ";
        mysqli_query($bdConexao, $bdGravar);
    }

    apagar_cat_do_orcamento($bdConexao, $id_cat, $cat_principal);

    $bdGravar = "
    DELETE FROM categorias
    WHERE id_cat = {$id_cat}
    ";

    mysqli_query($bdConexao, $bdGravar);
}
