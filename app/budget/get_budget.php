<?php

function get_budget($bdConexao, $categoriaPrincipal)
{
    $bdBuscar = "
    SELECT id_cat, nome_cat, eh_cat_principal, janeiro, fevereiro, março, abril, maio, junho, julho, agosto, setembro, outubro, novembro, dezembro FROM orcamento
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
