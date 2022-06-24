<?php

include($_SERVER["DOCUMENT_ROOT"] . '/app/function/transaction/get_transactions.php');
include($_SERVER["DOCUMENT_ROOT"] . '/app/function/utils/get_days_in_month.php');

// Specific account
$account = filter_input(INPUT_GET, 'account', FILTER_SANITIZE_NUMBER_INT);

// Specific category 
$category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);

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
    $year = $_GET['year'];
} else {
    $year = $ano;
}

// Specific day
$days = [];
if (!isset($_GET['day'])){
  $daysInMonth = get_days_in_month($month, $year);
  for ($d = 1; $d <= $daysInMonth; $d++){
      array_push($days, $d);}
} else {
    $days = [$_GET['day']];
}

//Get data and send
$data = [];

for ($month; $month <= $maxMonth; $month++){

  $object = [];

  foreach($days as $day){

    $statement = get_transactions($bdConexao, $day, $month, $year, null, null, $category, $account);

    array_push($data, $statement);
  }
}

$response = json_encode($data, JSON_UNESCAPED_UNICODE);

echo $response;