<?php

function calcula_resultado($bdConexao, $mes, $ano, $tipo, $conta = null, $categoriaSecundaria = null, $categoriaPrincipal = null, $dia = null, $soMesAtual = false)
{

    // TIPOS: SSM (saldo só mês), SAM (saldo acumulado até o mês) e SAG (saldo acumulado geral)

    // Se conta estiver definida, filtrar pela conta
    //Recebe o ID da conta
    if (isset($conta)) {
        $filtraConta = "contas.id_con = '{$conta}'";
    } else {
        $filtraConta = "contas.exibir = 1";
    }

    // Se categoria estiver definida, filtrar pela categoria

    //Recebe o ID da cat. secundária
    if (isset($categoriaSecundaria)) {
        $filtraCategoriaSec = "and categorias.id_cat = {$categoriaSecundaria}";
    } else {
        $filtraCategoriaSec = "";
    }

    //Recebe o nome da cat. principal
    if (isset($categoriaPrincipal)) {
        $filtraCategoriaPri = "and categorias.cat_principal = '{$categoriaPrincipal}'";
    } else {
        $filtraCategoriaPri = "";
    }

    // Se for informado um dia específico, filtrar pelo dia
    if (isset($dia)) {
        if ($tipo == 'SSM') {
            $filtraDia = "and data = '{$ano}-{$mes}-{$dia}'";
        } else if ($tipo == 'SAM') {
            $filtraDia = "and data <= '{$ano}-{$mes}-{$dia}'";
        }
    } else {
        $filtraDia = '';
    }

    // Se o valor acumulado deve considerar só o mês atual no cálculo do tipo SAM (saldo acumulado mês)
    if ($soMesAtual == true) {
        $filtraMesAcum = "MONTH(data) = '{$mes}'";
    } else {
        $filtraMesAcum = "MONTH(data) <= '{$mes}'";
    }

    //SSM - Saldo Só Mês: só do mês selecionado

    if ($tipo == 'SSM') {

        $bdSomar = "
        SELECT sum(valor) FROM extrato
        LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
        INNER JOIN contas ON extrato.id_conta = contas.id_con
        WHERE MONTH(data) = '{$mes}'
                and YEAR(data) = '{$ano}'
                {$filtraDia}
                and {$filtraConta}
                {$filtraCategoriaSec}
                {$filtraCategoriaPri}
        ORDER BY data ASC;
        ";
    }

    //SAM - Saldo Acumulado Mês: todos os meses até o atual

    if ($tipo == 'SAM') {

        $bdSomar = "
        SELECT sum(valor) FROM extrato
        LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
        INNER JOIN contas ON extrato.id_conta = contas.id_con
        WHERE {$filtraMesAcum}
                and YEAR(data) <= '{$ano}'
                {$filtraDia}
                and {$filtraConta}
                {$filtraCategoriaSec}
                {$filtraCategoriaPri}
        ORDER BY data ASC;
        ";
    }

    //SAG - Saldo Acumulado Geral: saldo total incluindo todos os valores passados e futuros

    if ($tipo == 'SAG') {

        $bdSomar = "
        SELECT sum(valor) FROM extrato
        LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
        INNER JOIN contas ON extrato.id_conta = contas.id_con
        WHERE {$filtraConta}
            {$filtraCategoriaSec}
            {$filtraCategoriaPri}
        ORDER BY data ASC;
        ";
    }

    if ($tipo == 'OCP') {

        $bdSomar = "
        SELECT sum(valor) FROM extrato
        LEFT JOIN categorias ON extrato.id_categoria = categorias.id_cat
        INNER JOIN contas ON extrato.id_conta = contas.id_con
        WHERE MONTH(data) = '{$mes}' and YEAR(data) = '{$ano}' and contas.exibir = 1 and categorias.cat_principal = '{$categoriaPrincipal}'
        ORDER BY data ASC;
        ";
    }

    $resultado = mysqli_query($bdConexao, $bdSomar);

    $soma = mysqli_fetch_array($resultado);

    if (isset($soma['sum(valor)'])) {
        return $soma['sum(valor)'];
    } else {
        return "0.00";
    }
}
