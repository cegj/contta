<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_primary_categories.php');
include_once($_SERVER["DOCUMENT_ROOT"] . '/app/function/category/get_secondary_categories.php');

$data = [];

$primaryCategories = get_primary_categories($bdConexao);

foreach ($primaryCategories as $primaryCategory){

    $categoryArray = [
        'id_cat' => intval($primaryCategory['id_cat']),
        'nome_cat' => $primaryCategory['nome_cat'],
        'eh_cat_principal' => intval($primaryCategory['eh_cat_principal']),
        'cat_principal' => $primaryCategory['cat_principal'],
        'secondaries' => []
    ];

    $secondaryCategories = get_secondary_categories($bdConexao, $primaryCategory);

    foreach ($secondaryCategories as $secondaryCategory){

        $secCatArray = [
            'id_cat' => $secondaryCategory['id_cat'],
            'nome_cat' => $secondaryCategory['nome_cat'],
            'eh_cat_principal' => $secondaryCategory['eh_cat_principal'],
            'cat_principal' => $secondaryCategory['cat_principal']
        ];

        array_push($categoryArray['secondaries'], $secCatArray);
    }
    
    array_push($data, $categoryArray);

}

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;