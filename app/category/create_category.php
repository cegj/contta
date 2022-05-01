<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/budget/add_last_category_to_budget.php');

function create_category($bdConexao, $categoria, $edicao = false, $id_cat = null, $cat_edicao_nome = null, $cat_edicao_cat_principal = null)
{

    if ($edicao == false) {

        if ($categoria['ehcatprincipal'] == 1) {

            $bdGravar = "
            INSERT INTO categorias
            (eh_cat_principal, nome_cat)
            VALUES
            (
                {$categoria['ehcatprincipal']},
                '{$categoria['nomecat']}'
                )
            ";

            mysqli_query($bdConexao, $bdGravar);

            add_last_category_to_budget($bdConexao);

            $bdGravarOutros = "
            INSERT INTO categorias
            (eh_cat_principal,nome_cat, cat_principal)
            VALUES
            (
                0,
                'Outros ({$categoria['nomecat']})',
                '{$categoria['nomecat']}'
                )
            ";

            mysqli_query($bdConexao, $bdGravarOutros);

            add_last_category_to_budget($bdConexao);
        } else {
            $bdGravar = "
            INSERT INTO categorias
            (eh_cat_principal,nome_cat, cat_principal)
            VALUES
            (
                {$categoria['ehcatprincipal']},
                '{$categoria['nomecat']}',
                '{$categoria['catprincipal']}'
                )
            ";

            mysqli_query($bdConexao, $bdGravar);

            add_last_category_to_budget($bdConexao);
        }
    } else if ($edicao == true) {

        $bdAlterarSubCategoriasAssociadas = "
        UPDATE
        categorias
        SET
        cat_principal = '{$categoria['nomecat']}'
        WHERE eh_cat_principal = 0 AND cat_principal = '{$cat_edicao_nome}';
        ";

        $bdAlterarCategoria = "
        UPDATE
        categorias
        SET
        eh_cat_principal={$categoria['ehcatprincipal']},
        nome_cat='{$categoria['nomecat']}',
        cat_principal='{$categoria['catprincipal']}'
        WHERE `id_cat` = {$id_cat};
        ";

        mysqli_query($bdConexao, $bdAlterarSubCategoriasAssociadas);
        mysqli_query($bdConexao, $bdAlterarCategoria);
    }
}
