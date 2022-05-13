<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/bd.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/translate_currency_to_br.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/delete_account.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/account/create_account.php');

$origin = $_SERVER['HTTP_REFERER'];

$id_conta = filter_input(INPUT_POST, 'id_conta', FILTER_VALIDATE_INT);

//Guardar os dados na variável $categoria para inserir no BD

$conta = array();

$conta['nomeconta'] = $_POST['nomeconta'];

$conta['tipoconta'] = $_POST['tipoconta'];

if (isset($_POST['saldoinicial']) && $_POST['saldoinicial'] != "") {
    $valorSemMascara = translate_currency_to_br($_POST['saldoinicial']);
    $conta['saldoinicial'] = $valorSemMascara;
} else {
    $conta['saldoinicial'] = 0;
}

if (isset($_POST['exibirconta']) && $_POST['exibirconta'] == 1) {
    $conta['exibir'] = 1;
} else {
    $conta['exibir'] = 0;
}

//Chama as funções conforme o caso

if (isset($_POST['apagar'])) {
    delete_account($bdConexao, $id_conta, $_POST['apagar']);
    header('Location: ' . $origin);
    die();
} if ($id_conta) {
    create_account($bdConexao, $conta, true, $id_conta);
    header('Location: ' . $origin);
    die();
} else {
    create_account($bdConexao, $conta, false, null);
    header('Location: ' . $origin);
    die();
}
