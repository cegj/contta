<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/budget/delete_category_from_budget.php');

function delete_category($bdConexao, $id_cat, $nome_cat, $cat_principal)
{

    if ($cat_principal == null) {

        delete_category_from_budget($bdConexao, $id_cat, $cat_principal);

        $bdGravar = "
        DELETE FROM categorias
        WHERE cat_principal = '{$nome_cat}'
        ";
        mysqli_query($bdConexao, $bdGravar);
    }

    delete_category_from_budget($bdConexao, $id_cat, $cat_principal);

    $bdGravar = "
    DELETE FROM categorias
    WHERE id_cat = {$id_cat}
    ";

    mysqli_query($bdConexao, $bdGravar);
}
