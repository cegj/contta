<?php

function add_last_category_to_budget($bdConexao)
{
    $bdBuscarId = "
    SELECT id_cat FROM categorias ORDER BY id_cat DESC LIMIT 1
    ";

    $resultado = mysqli_query($bdConexao, $bdBuscarId);

    $linhas[] = mysqli_fetch_assoc($resultado);

    foreach ($linhas as $linha) {
        $cat[] = $linha['id_cat'];
    }

    $bdGravarTabOrcamento = "
    INSERT INTO orcamento
    (id_categoria)
    VALUES
    ({$cat[0]})
    ";

    mysqli_query($bdConexao, $bdGravarTabOrcamento);
}
