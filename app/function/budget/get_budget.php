<?php

function get_budget($bdConexao, $categoriaPrincipal, $ano)
{
    $bdBuscar = "
    SELECT id_cat, nome_cat, eh_cat_principal, {$ano}_1, {$ano}_2, {$ano}_3, {$ano}_4, {$ano}_5, {$ano}_6, {$ano}_7, {$ano}_8, {$ano}_9, {$ano}_10, {$ano}_11, {$ano}_12 FROM orcamento
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
