<?php

include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

$origin = $_SERVER['HTTP_REFERER'];
$origin = explode('?', $origin)[0];

$edicao = filter_input(INPUT_POST, 'editar', FILTER_VALIDATE_BOOLEAN);

//Guarda os valores na variável $transacao para usar na query

$transacao = array();

if ($edicao == true && $reg_edicao_tipo == 'T') {
    $transacao['tipo'] = $reg_edicao_tipo;
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
if ($edicao == true && $reg_edicao_tipo == 'T') {
    $transacao['conta'] = $reg_edicao_conta;
} else {
    $transacao['conta'] = $_POST['conta'];
}

if ($edicao == false && $transacao['tipo'] == 'T') {
    $transacao['contadestino'] = $_POST['contadestino'];
} else {
    $transacao['contadestino'] = null;
}

if ($edicao == false && isset($_POST['parcelas'])) {
    $transacao['parcelas'] = filter_var($_POST['parcelas'], FILTER_SANITIZE_NUMBER_INT);
} else if ($edicao == true && isset($_POST['parcela']) && isset($_POST['total-parcelas'])) {
    $transacao['parcelas'] = filter_var($_POST['parcelas'], FILTER_SANITIZE_NUMBER_INT);
    $transacao['total-parcelas'] = filter_var($_POST['total-parcelas'], FILTER_SANITIZE_NUMBER_INT);
    $editarParcelas = filter_var($_POST['editar-parcelas'], FILTER_VALIDATE_BOOL);
}

// CHAMA AS FUNÇÕES PARA INCLUIR/EDITAR/APAGAR:

if (isset($_POST['apagar']) && $_POST['apagar'] == true) {
    apagar_registro($bdConexao, $transacao, $id_reg, $editarParcelas);
    header('Location: ' . $origin);
    die();
} else if ($edicao == true) {
    cadastrar_registro($bdConexao, $transacao, $edicao, $id_reg, $editarParcelas);
    header('Location: ' . $origin);
    die();
} else {
    cadastrar_registro($bdConexao, $transacao, $edicao, null);
    header('Location: ' . $origin);
    die();
}
