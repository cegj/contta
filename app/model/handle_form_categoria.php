<?php

include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

$origin = $_SERVER['HTTP_REFERER'];
$origin = explode('?', $origin)[0];

$edicao = filter_input(INPUT_POST, 'editar', FILTER_VALIDATE_BOOLEAN);

if ($edicao) {
    $id_cat = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $cat_especifica = buscar_cat_especifica($bdConexao, $id_cat);
    $cat_edicao_nome = $cat_especifica['nome_cat'];
    $cat_edicao_cat_principal = $cat_especifica['cat_principal'];
    $cat_edicao_eh_cat_principal = $cat_especifica['eh_cat_principal'];
}

//Guarda os valores na variável $categoria para usar na query

$categoria = array();

$categoria['nomecat'] = $_POST['nomecat'];

if (isset($_POST['ehcatprincipal'])) {
    $categoria['ehcatprincipal'] = 1;
    $categoria['catprincipal'] = "";
} else {
    $categoria['ehcatprincipal'] = 0;

    if (buscar_cat_principal($bdConexao) == null) {
        echo "<script language='javascript' type='text/javascript'>
        alert('Antes de cadastrar uma categoria secundária, é necessário cadastrar pelo menos uma categoria principal. Tente novamente.')</script>";
        header('Location: ' . $origin);
        die();
    } else {
        $categoria['catprincipal'] = $_POST['catprincipal'];
    }
}

if (isset($_POST['apagar']) && $_POST['apagar'] == true) {
    apagar_cat($bdConexao, $id_cat, $cat_edicao_nome, $cat_edicao_cat_principal);
    header('Location: ' . $origin);
    die();
} else if ($edicao == true) {
    cadastrar_cat($bdConexao, $categoria, $edicao, $id_cat, $cat_edicao_nome, $cat_edicao_cat_principal);
    header('Location: ' . $origin);
    die();
} else {
    cadastrar_cat($bdConexao, $categoria, $edicao, null, null, null);
    header('Location: ' . $origin);
    die();
}
