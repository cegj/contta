<?php

include($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');

// Specific account
$account = filter_input(INPUT_GET, 'account', FILTER_SANITIZE_NUMBER_INT);

// Specific category 
if (isset($_GET['mainCat']) && $_GET['mainCat'] === true){
    $mainCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);
    $secCat = null;
} else {
    $secCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);
    $mainCat = null;
}

//Get data
$data = [];

if (isset($_GET['month'])) {
    $month = $_GET['month'];
    $maxMonth = $_GET['month'];
} else {
    $month = 1;
    $maxMonth = 12;
}

for ($month; $month <= $maxMonth; $month++){

    $data[$month]["incomes"] = calculate_result($bdConexao, $month, $ano, "SSM", $account, $secCat, $mainCat, null, true, "R");

    $data[$month]["expenses"] = calculate_result($bdConexao, $month, $ano, "SSM", $account, $secCat, $mainCat, null, true, "D");
    }

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;