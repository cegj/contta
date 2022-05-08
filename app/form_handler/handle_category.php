<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_especific_category.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/create_category.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/delete_category.php');

include($_SERVER["DOCUMENT_ROOT"] . '/partes-template/includesiniciais.php');

$origin = $_SERVER['HTTP_REFERER'];
$origin = explode('?', $origin)[0] . '?configurar=true';

$id_cat = filter_input(INPUT_POST, 'id_cat', FILTER_VALIDATE_INT);

if ($id_cat) {
    $cat_especifica = get_especific_category($bdConexao, $id_cat);
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

    if (get_primary_categories($bdConexao) == null) {
        echo "<script language='javascript' type='text/javascript'>
        alert('Antes de cadastrar uma categoria secundária, é necessário cadastrar pelo menos uma categoria principal. Tente novamente.')</script>";
        header('Location: ' . $origin);
        die();
    } else {
        $categoria['catprincipal'] = $_POST['catprincipal'];
    }
}

if (isset($_POST['apagar']) && $_POST['apagar'] == true) {
    delete_category($bdConexao, $id_cat, $cat_edicao_nome, $cat_edicao_cat_principal);
    header('Location: ' . $origin);
    die();
} else if ($id_cat) {
    create_category($bdConexao, $categoria, true, $id_cat, $cat_edicao_nome, $cat_edicao_cat_principal);
    header('Location: ' . $origin);
    die();
} else {
    create_category($bdConexao, $categoria, false, null, null, null);
    header('Location: ' . $origin);
    die();
}

header('Location: ' . $origin);
die();
