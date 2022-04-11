<?php

function get_transactions($bdConexao, $dia, $mes, $ano, $tudo = null, $ultimo = null, $id_cat = null, $id_con = null)
{

    //Se o dia está definido, inclui o filtro de dia no where da query
    if (isset($dia) && $dia != null) {
        $filtraDia = "DAY(data) = '{$dia}' and";
    } else {
        $filtraDia = "";
    }
    //Se o parâmetro categoria está definido, inclui o filtro de categoria no where da query
    if (isset($id_cat)) {
        $busqueCategoriaEspecifica = "and categorias.id_cat = {$id_cat}";
    } else {
        $busqueCategoriaEspecifica = "";
    }
    //Por padrão, não busca os registros de contas ocultas
    $filtrarContasOcultas = "and contas.exibir = 1";

    //Por padrão, não busca os registros do tipo "Saldo inicial"
    $filtraSaldoInicial = "and tipo != 'SI'";

    //Se o parâmetro conta está definido, inclui o filtro de conta no where da query, exibe os valores de contas ocultas e exibe os registros de saldo inicial
    if (isset($id_con)) {
        $busqueContaEspecifica = "and contas.id_con = {$id_con}";
        $filtrarContasOcultas = "";
        $filtraSaldoInicial = "";
    } else {
        $busqueContaEspecifica = "";
    }

    $filtrarMesAno = "
    MONTH(data) = '{$mes}'
    and YEAR(data) = '{$ano}'
    ";

    if ($tudo == true) {
        $filtrarMesAno = "";
    }

    if ($ultimo == true) {
        $ordemRegistros = "data_insert DESC LIMIT 1;";
    } else {
        $ordemRegistros = "data ASC, data_insert ASC;";
    }


    $bdBuscar = "
    SELECT id, tipo, data, descricao, valor, id_categoria, nome_cat, id_con, conta FROM extrato
    LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
    LEFT JOIN contas ON extrato.id_conta = contas.id_con
    WHERE
        {$filtraDia}
        {$filtrarMesAno}
        {$filtraSaldoInicial}
        {$busqueCategoriaEspecifica}
        {$busqueContaEspecifica}
        {$filtrarContasOcultas}
        or
        {$filtraDia}
        {$filtrarMesAno}
        {$filtraSaldoInicial}
        {$busqueCategoriaEspecifica}
        {$busqueContaEspecifica}
        {$filtrarContasOcultas} 
        and id_conta IS NULL
    ORDER BY
        {$ordemRegistros};
    ";

    $resultado = mysqli_query($bdConexao, $bdBuscar);

    $registros = array();

    while ($registro = mysqli_fetch_assoc($resultado)) {
        $registros[] = $registro;
    }

    return $registros;
}
