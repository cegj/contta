<?php

function delete_category_from_budget($bdConexao, $id_cat, $cat_principal)
{

    if ($cat_principal == null) {
        $bdGravar = "
        DELETE orcamento 
        FROM orcamento 
        INNER JOIN categorias 
        ON id_categoria=id_cat
        WHERE cat_principal = '{$cat_principal}'
        ";

        mysqli_query($bdConexao, $bdGravar);
    }

    $bdGravar = "
    DELETE FROM orcamento
    WHERE id_categoria = {$id_cat}
    ";

    mysqli_query($bdConexao, $bdGravar);
}
