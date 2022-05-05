<?php

function update_budget_value($bdConexao, $catEmEdicao, $mesEmEdicao, $novoValor)
{

    $bdAlterar = "
    UPDATE orcamento
    SET
    {$mesEmEdicao} = {$novoValor}
    WHERE id_categoria = $catEmEdicao;
    ";

    $resultado = mysqli_query($bdConexao, $bdAlterar);
}
