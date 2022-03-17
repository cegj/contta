<?php

include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

$origin = $_SERVER['HTTP_REFERER'];
$origin = explode('?', $origin)[0];

$edicao = filter_input(INPUT_POST, 'editar', FILTER_VALIDATE_BOOLEAN);

$id_conta = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

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
} else if ($edicao == true) {
    cadastrar_conta($bdConexao, $conta, $edicao, $id_conta);
    header('Location: ' . $origin);
    die();
} else {
    cadastrar_conta($bdConexao, $conta, $edicao, null);
    header('Location: ' . $origin);
    die();
}
