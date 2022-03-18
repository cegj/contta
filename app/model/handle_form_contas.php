<?php

include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

$origin = $_SERVER['HTTP_REFERER'];
$origin = explode('?', $origin)[0] . '?configurar=true';

$id_conta = filter_input(INPUT_POST, 'id_conta', FILTER_VALIDATE_INT);

//Guardar os dados na variável $categoria para inserir no BD

$conta = array();

$conta['nomeconta'] = $_POST['nomeconta'];

$conta['tipoconta'] = $_POST['tipoconta'];

if (isset($_POST['saldoinicial']) && $_POST['saldoinicial'] != "") {
    $valorSemMascara = ajustaValorMoeda($_POST['saldoinicial']);
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
    apagar_conta($bdConexao, $id_conta, $_POST['apagar']);
    header('Location: ' . $origin);
    die();
} else if ($id_conta) {
    cadastrar_conta($bdConexao, $conta, true, $id_conta);
    header('Location: ' . $origin);
    die();
} else {
    cadastrar_conta($bdConexao, $conta, false, null);
    header('Location: ' . $origin);
    die();
}
