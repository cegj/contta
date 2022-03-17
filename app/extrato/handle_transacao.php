<?php include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

$origin = $_SERVER['HTTP_REFERER'];
echo $_SERVER['HTTP_REFERER'];

if (isset($_POST['edicao']) && $_POST['edicao'] == true) {
    $edicao = true;
} else {
    $edicao = false;
}

//GUARDA OS VALORES NAS VARIÁVEIS:

if (isset($_POST['data']) && $_POST['data'] != '') {

    $registro = array();

    if ($edicao == true && $reg_edicao_tipo == 'T') {
        $registro['tipo'] = $reg_edicao_tipo;
    } else {
        $registro['tipo'] = $_POST['tipo'];
    }

    $registro['data'] = $_POST['data'];

    $valorSemMascara = ajustaValorMoeda($_POST['valor']);

    if ($registro['tipo'] == 'D' or $registro['tipo'] == 'T') {
        $registro['valor'] = $valorSemMascara * -1;
    } else {
        $registro['valor'] = $valorSemMascara;
    }

    $registro['descricao'] = $_POST['descricao'];

    if ($registro['tipo'] == 'D' or $registro['tipo'] == 'R') {
        $registro['categoria'] = $_POST['categoria'];
    } else {
        $registro['categoria'] = null;
    }
    if ($edicao == true && $reg_edicao_tipo == 'T') {
        $registro['conta'] = $reg_edicao_conta;
    } else {
        $registro['conta'] = $_POST['conta'];
    }

    if ($edicao == false && $registro['tipo'] == 'T') {
        $registro['contadestino'] = $_POST['contadestino'];
    } else {
        $registro['contadestino'] = null;
    }

    if ($edicao == false && isset($_POST['parcelas'])) {
        $registro['parcelas'] = $_POST['parcelas'];
    } else if ($edicao == true && isset($_POST['parcela']) && isset($_POST['total-parcelas'])) {
        $registro['parcela'] = $_POST['parcela'];
        $registro['total-parcelas'] = $_POST['total-parcelas'];
        $editarParcelas = $_POST['editar-parcelas'];
    }

    // CHAMA AS FUNÇÕES PARA INCLUIR/EDITAR/APAGAR:

    if (isset($_POST['apagar']) && $_POST['apagar'] == true) {
        apagar_registro($bdConexao, $registro, $id_reg, $editarParcelas);
        header('Location: ' . $origin);
        die();
    } else if ($edicao == true) {
        cadastrar_registro($bdConexao, $registro, $edicao, $id_reg, $editarParcelas);
        header('Location: ' . $origin);
        die();
    } else {
        cadastrar_registro($bdConexao, $registro, $edicao, null);
        header('Location: ' . $origin);
        die();
    }
}
