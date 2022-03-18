<?php

include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

$origin = $_SERVER['HTTP_REFERER'];
$origin = explode('?', $origin)[0];

$id_transacao = filter_input(INPUT_POST, 'id_transacao', FILTER_VALIDATE_INT);

if ($id_transacao) {
    $transacao_especifica = buscar_reg_especifico($bdConexao, $id_transacao);

    foreach ($transacao_especifica as $transacao_em_edicao) :
        $transacao_edicao_tipo = $transacao_em_edicao['tipo'];
        $transacao_edicao_data = $transacao_em_edicao['data'];
        $transacao_edicao_descricao = $transacao_em_edicao['descricao'];
        $transacao_edicao_valor = formata_valor(abs($transacao_em_edicao['valor']), 2, ',', '.');
        $transacao_edicao_categoria = $transacao_em_edicao['id_categoria'];
        $transacao_edicao_conta = $transacao_em_edicao['id_conta'];
        $transacao_edicao_parcela = $transacao_em_edicao['parcela'];
        $transacao_edicao_total_parcelas = $transacao_em_edicao['total_parcelas'];
    endforeach;
} else {
    $transacao_edicao_tipo = '';
    $transacao_edicao_data = '';
    $transacao_edicao_descricao = '';
    $transacao_edicao_valor = '';
    $transacao_edicao_categoria = '';
    $transacao_edicao_conta = '';
    $transacao_edicao_parcela = '';
    $transacao_edicao_total_parcelas = '';
}


//Guarda os valores na variável $transacao para usar na query

$transacao = array();

if ($id_transacao && $transacao_edicao_tipo == 'T') {
    $transacao['tipo'] = $transacao_edicao_tipo;
} else {
    $transacao['tipo'] = $_POST['tipo'];
}

$transacao['data'] = $_POST['data'];

$valorSemMascara = ajustaValorMoeda($_POST['valor']);

if ($transacao['tipo'] == 'D' or $transacao['tipo'] == 'T') {
    $transacao['valor'] = $valorSemMascara * -1;
} else {
    $transacao['valor'] = $valorSemMascara;
}

$transacao['descricao'] = $_POST['descricao'];

if ($transacao['tipo'] == 'D' or $transacao['tipo'] == 'R') {
    $transacao['categoria'] = $_POST['categoria'];
} else {
    $transacao['categoria'] = null;
}
if ($id_transacao && $transacao_edicao_tipo == 'T') {
    $transacao['conta'] = $transacao_edicao_conta;
} else {
    $transacao['conta'] = $_POST['conta'];
}

if (!$id_transacao && $transacao['tipo'] == 'T') {
    $transacao['contadestino'] = $_POST['contadestino'];
} else {
    $transacao['contadestino'] = null;
}

if (!$id_transacao && isset($_POST['parcelas'])) {
    $transacao['parcelas'] = $_POST['parcelas'];
} else if ($id_transacao && isset($_POST['parcela']) && isset($_POST['total-parcelas'])) {
    $transacao['parcela'] = $_POST['parcela'];
    $transacao['total-parcelas'] = $_POST['total-parcelas'];
    $editarParcelas = $_POST['editar-parcelas'];
}

// CHAMA AS FUNÇÕES PARA INCLUIR/EDITAR/APAGAR:

if (isset($_POST['apagar']) && $_POST['apagar'] == true) {
    apagar_registro($bdConexao, $transacao, $id_transacao, $editarParcelas);
    header('Location: ' . $origin);
    die();
} else if ($id_transacao) {
    cadastrar_registro($bdConexao, $transacao, true, $id_transacao, $editarParcelas);
    header('Location: ' . $origin);
    die();
} else {
    cadastrar_registro($bdConexao, $transacao, false, null);
    header('Location: ' . $origin);
    die();
}
