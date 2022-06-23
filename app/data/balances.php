<?php

include($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');

$account = filter_input(INPUT_GET, 'account', FILTER_SANITIZE_NUMBER_INT);

if (isset($_GET['mainCat']) && $_GET['mainCat'] === true){
    $mainCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);
    $secCat = null;
} else {
    $secCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);
    $mainCat = null;
}

$data = [];

for ($month = 1; $month <= 12; $month++){

    $data[$month]["incomes"] = calculate_result($bdConexao, $month, $ano, "SSM", $account, $secCat, $mainCat, null, true, "R");

    $data[$month]["expenses"] = calculate_result($bdConexao, $month, $ano, "SSM", $account, $secCat, $mainCat, null, true, "D");
    }

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;