<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_secondary_categories.php');

$data['categories'] = [];

$categoriasPrincipais = get_primary_categories($bdConexao);

$i = 0;
foreach ($categoriasPrincipais as $categoriaPrincipal){

    array_push($data['categories'], $categoriaPrincipal);

    $categoriasSecundarias = get_secondary_categories($bdConexao, $categoriaPrincipal);
    $data['categories'][$i]['sec'] = [];

    foreach ($categoriasSecundarias as $categoriaSecundaria){

        array_push($data['categories'][$i]['sec'], $categoriaSecundaria);
    }
    
    $i++;
}

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;