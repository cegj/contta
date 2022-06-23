<?php

include($_SERVER["DOCUMENT_ROOT"] . '/app/function/statement/calculate_result.php');

// Specific account
$account = filter_input(INPUT_GET, 'account', FILTER_SANITIZE_NUMBER_INT);

// Specific category 
if (isset($_GET['mainCat']) && $_GET['mainCat'] === 'true'){
    $mainCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_STRING);
    $secCat = null;
} else {
    $secCat = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);
    $mainCat = null;
}

// Specific month
if (isset($_GET['month'])){
    if ($_GET['month'] === 'current') {
        $month = $mes;
        $maxMonth = $mes;   
    } else {
        $month = $_GET['month'];
        $maxMonth = $_GET['month'];    
    }
} else {
    $month = 1;
    $maxMonth = 12;
}

// Specific year
if (isset($_GET['year'])) {
    $year = $_GET['month'];
} else {
    $year = $ano;
}

//Get data and send
$data = [];

for ($month; $month <= $maxMonth; $month++){

    $incomes = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, null, true, "R"));
    $expenses = floatval(calculate_result($bdConexao, $month, $year, "SSM", $account, $secCat, $mainCat, null, true, "D"));

    if ($mainCat){
        $category = $mainCat;
    } else {
        $category = $secCat;
    }

    $balance = floatval(number_format($incomes + $expenses, 2, ".", ""));

    $object = [
        'month' => intval($month),
        'year' => intval($year),
        'account' => $account,
        'category' => $category,
        'incomes' => $incomes,
        'expenses' => $expenses,
        'balance' => $balance
    ];

    array_push($data, $object);
    }

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;