<?php

function get_budget($bdConexao, $categoriaPrincipal)
{
    $bdBuscar = "
    SELECT id_cat, nome_cat, eh_cat_principal, 2022_1, 2022_2, 2022_3, 2022_4, 2022_5, 2022_6, 2022_7, 2022_8, 2022_9, 2022_10, 2022_11, 2022_12 FROM orcamento
    INNER JOIN categorias ON orcamento.id_categoria = categorias.id_cat
    WHERE categorias.cat_principal = '{$categoriaPrincipal}' OR categorias.nome_cat = '{$categoriaPrincipal}'
    ORDER BY eh_cat_principal DESC, nome_cat ASC;
";

    $resultado = mysqli_query($bdConexao, $bdBuscar);

    $itensOrcamento = array();

    while ($item = mysqli_fetch_assoc($resultado)) {
        $itensOrcamento[] = $item;
    }

    return $itensOrcamento;
}
